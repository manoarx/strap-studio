@extends('layouts.backend')

@section('styles')


@endsection

@section('content')
<div class="pagetitle">
<h1>Studio Rentals</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Studio Rentals</li>
</ol>
</nav>
</div><!-- End Page Title -->
<!-- <div class="text-right d-flex">
    <a href="{{ route('admin.studiorentals.create') }}" type="button" class="btn btn-primary ms-auto me-0">Add studiorentals</a>
</div> -->
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Studio Rentals List</h5>

          <!-- Table with hoverable rows -->
          <form id="packages-form">
            @csrf
            <table class="table table-hover table-bordered table-striped" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Price</th>
                  <th scope="col">Most Liked</th>
                  <th scope="col">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                @foreach($studiorentals as $key => $studiorental)
                <tr data-entry-id="{{ $studiorental->id }}">
                  <th scope="row">{{ ($key+1) ?? '' }}</th>
                  <td>{{ $studiorental->title ?? '' }}</td>
                  <td>{{ $studiorental->price ?? '' }}</td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="most_liked" data-id="{{ $studiorental->id }}" value="{{ $studiorental->id ?? '' }}" {{  ($studiorental->most_liked == 1 ? 'checked' : '') }}>
                    </div>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.studiorentals.edit', $studiorental->id) }}">
                        Edit
                    </a>
                    <a class="btn btn-sm btn-danger" href="{{ route('admin.studiorentals.delete',$studiorental->id) }}" id="delete" >Delete</a>
                    <!-- <form action="{{ route('admin.studiorentals.destroy', $studiorental->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                    </form> -->
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </form>
          <!-- End Table with hoverable rows -->

        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Studio Rentals</h5>

          <form id="myForm" class="row g-3" action="{{ route("admin.studiorentals.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-12">
              <label for="title" class="form-label">Package Name</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label for="price" class="form-label">Price</label>
              <input type="number" name="price" class="form-control">
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


    $('#packages-form input[type=checkbox]').on('change', function() {
        var packageId = $(this).data('id');
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: "{{ route('admin.studiorentals.mostliked') }}",
            type: "POST",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'package_id': packageId,
            },
            success: function(data) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: 'Updated successfully!',
                  showConfirmButton: false,
                  timer: 1500 // Time in milliseconds
                });
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });



    $('#myForm').validate({
        rules: {
            title: {
                required : true,
            }, 
        },
        messages :{
            title: {
                required : 'Please Enter Package Name',
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
</script>
@endsection