@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')
<div class="pagetitle">
<h1>Settings</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
  <li class="breadcrumb-item active">Settings</li>
</ol>
</nav>
</div><!-- End Page Title -->
<!-- <div class="text-right d-flex">
    <a href="{{ route('admin.settings.create') }}" type="button" class="btn btn-primary ms-auto me-0">Add settings</a>
</div> -->
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Settings List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Value</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($settings as $i => $setting)
              <tr data-entry-id="{{ $setting->id }}">
                <th scope="row">{{ ($i+1) ?? '' }}</th>
                <td>{{ $setting->key ?? '' }}</td>
                <td>{{ Str::limit($setting->value,50) ?? '' }}</td>
                <td>
                  <!-- <a class="btn btn-sm btn-primary" href="{{ route('admin.settings.show', $setting->id) }}">
                      View
                  </a> -->

                  <a class="btn btn-sm btn-info" href="{{ route('admin.settings.edit', $setting->id) }}">
                      Edit
                  </a>

                  <!-- <form action="{{ route('admin.settings.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                  </form> -->
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table with hoverable rows -->

        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Settings</h5>

          <form class="row g-3" action="{{ route("admin.settings.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="key" class="form-control">
            </div>
            <div class="col-md-12">
              <label for="desc" class="form-label">Value</label>
              <input type="text" name="value" class="form-control">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>
  var dataTable;
  var basePath ="{{url('/')}}";
  $(document).ready(function() {
    dataTable = $('#table').DataTable({
      pageLength: 20,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    let deleteButtonTrans = 'Delete'
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.settings.massDestroy') }}",
      className: 'btn-danger',
      action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
            return $(entry).data('entry-id')
        });

        if (ids.length === 0) {
          alert('No rows selected')

          return
        }

        if (confirm('Are you sure')) {
          $.ajax({
            headers: {'x-csrf-token': _token},
            method: 'POST',
            url: config.url,
            data: { ids: ids, _method: 'DELETE' }})
            .done(function () { location.reload() })
        }
      }
    }
    dtButtons.push(deleteButton)
  });



  var uploadedPhotosMap = {}
    Dropzone.options.photosDropzone = {
    url: '{{ route('admin.settings.storeMedia') }}',
    maxFiles: 2,
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif,.webp',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
      uploadedPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotosMap[file.name]
      }
      $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
      @if(isset($event) && $event->photos)
      var files =
        {!! json_encode($event->photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.original_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
        }
      @endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
    }
</script>

@endsection