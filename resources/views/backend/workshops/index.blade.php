@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')
<div class="pagetitle">
<h1>Workshops</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
  <li class="breadcrumb-item active">Workshops</li>
</ol>
</nav>
</div><!-- End Page Title -->
<div class="text-right d-flex">
    <a href="{{ route('admin.workshops.create') }}" type="button" class="btn btn-primary ms-auto me-0">Add workshops</a>
</div>
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Workshops List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <!-- <th scope="col">Product Code</th> -->
                <th scope="col">Selling Price</th>
                <th scope="col">Discount Price</th>
                <th scope="col">Image</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($workshops as $key => $workshop)
              <tr data-entry-id="{{ $workshop->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $workshop->title ?? '' }}</td>
                <!-- <td>{{ $workshop->code ?? '' }}</td> -->
                <td>{{ $workshop->selling_price ?? '' }}</td>
                <td>{{ $workshop->discount_price ?? '' }}</td>
                <td><img src="{{$workshop->getFirstMediaUrl('photos','thumb') ?? ''}}" /></td>
                <td>
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.workshops.show', $workshop->id) }}">
                      View
                  </a>

                  <a class="btn btn-sm btn-info" href="{{ route('admin.workshops.edit', $workshop->id) }}">
                      Edit
                  </a>

                  <form action="{{ route('admin.workshops.destroy', $workshop->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
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
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    let deleteButtonTrans = 'Delete'
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.workshops.massDestroy') }}",
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



  
</script>

@endsection