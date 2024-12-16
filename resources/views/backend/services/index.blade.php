@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="pagetitle">
<h1>Services</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
  <li class="breadcrumb-item active">Services</li>
</ol>
</nav>
</div><!-- End Page Title -->
<!-- <div class="text-right d-flex">
    <a href="{{ route('admin.services.create') }}" type="button" class="btn btn-primary ms-auto me-0">Add services</a>
</div> -->
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Services List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($services as $key => $service)
              @php
              $package_cnt=DB::table('service_packages')->select('id')->where('service_id',$service->id)->count();
              $addons_cnt=DB::table('service_package_addons')->select('id')->where('service_id',$service->id)->count();
              $options_cnt=DB::table('service_package_options')->select('id')->where('service_id',$service->id)->count();
              @endphp
              <tr data-entry-id="{{ $service->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $service->title ?? '' }}</td>
                <td>
                  <!-- <img src="{{$service->getFirstMediaUrl('photos','thumb') ?? ''}}" /> -->
                  <img src="{{ (!empty($service->main_image)) ? asset($service->main_image) : url('upload/no_image.jpg') }}" style="width: 70px;" />
                </td>
                <td>
                  <a class="btn btn-sm btn-info" href="{{ route('admin.services.edit', $service->id) }}">
                      Edit
                  </a>
                  @if($package_cnt>0)
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.services.package', $service->id) }}">
                      Edit Package
                  </a>
                  @else
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.services.package', $service->id) }}">
                      Add Package
                  </a>
                  @endif
                  @if($addons_cnt>0 || $options_cnt>0)
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.services.addonsoptions', $service->id) }}">
                      Edit Addons/Options
                  </a>
                  @else
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.services.addonsoptions', $service->id) }}">
                      Add Addons/Options
                  </a>
                  @endif

                  <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table with hoverable rows -->

        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Services</h5>

          <form id="myForm" class="row g-3" action="{{ route("admin.services.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
              <label for="title" class="form-label">Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label for="short_title" class="form-label">Short Title</label>
              <textarea name="short_title" class="form-control summernote" style="height: 100px"></textarea>
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Images</label>
              <div class="needsclick dropzone" id="photos-dropzone">

              </div>
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Main Image</label>
              <input type="file" name="image" class="form-control"  id="image"   />
            </div>
            <div class="col-md-12">
              <label for="desc" class="form-label"></label>
              <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Admin" style="width:100px; height: 100px;"  >
            </div>
            <div class="col-md-12">
              <label for="meta_title" class="form-label">Meta Title</label>
              <input type="text" name="meta_title" id="meta_title" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea name="meta_description" id="meta_description" class="form-control" style="height: 100px"></textarea>
            </div>
            <div class="col-md-12">
              <label for="meta_keywords" class="form-label">Meta Keywords</label>
              <textarea name="meta_keywords" id="meta_keywords" class="form-control" style="height: 100px"></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>
  var dataTable;
  var basePath ="{{url('/')}}";
  $(document).ready(function() {
    $('.summernote').summernote({
        height: 200
    });
    dataTable = $('#table').DataTable({
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


    $('#image').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });


    $('#myForm').validate({
        rules: {
            name: {
                required : true,
            },
        },
        messages :{
            name: {
                required : 'Please Enter client Name',
            },
        },
        errorElement : 'span',
        errorPlacement: function (error,element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight : function(element, errorClass, validClass){
            $(element).addClass('is-invalid');
        },
        unhighlight : function(element, errorClass, validClass){
            $(element).removeClass('is-invalid');
        },
    });
  });



  var uploadedPhotosMap = {}
    Dropzone.options.photosDropzone = {
    url: '{{ route('admin.services.storeMedia') }}',
    maxFiles: 20,
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
          this.options.thumbnail.call(this, file, file.url)
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
