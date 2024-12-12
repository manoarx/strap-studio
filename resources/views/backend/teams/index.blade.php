@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')
<div class="pagetitle">
<h1>Teams</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Teams</li>
</ol>
</nav>
</div><!-- End Page Title -->

<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Teams List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name </th>
                <th scope="col">Image</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teams as $key => $team)
              <tr data-entry-id="{{ $team->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $team->name ?? '' }}</td>
                <td><img src="{{ (!empty($team->image)) ? asset($team->image) : url('upload/no_image.jpg') }}" style="width: 70px; " >  </td>
                <td>
                  <a class="btn btn-sm btn-info" href="{{ route('admin.teams.edit', $team->id) }}">
                      Edit
                  </a>
                  <a class="btn btn-sm btn-danger" href="{{ route('admin.teams.delete',$team->id) }}" id="delete" >Delete</a>
                  <!-- <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
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
    <div class="col-lg-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Team</h5>

          <form id="myForm" class="row g-3" action="{{ route("admin.teams.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group col-md-12">
              <label for="name" class="form-label">Name </label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group col-md-12">
              <label for="desc" class="form-label">Short Desc </label>
              <input type="text" name="desc" class="form-control" required>
            </div>
            <div class="form-group col-md-12">
              <label for="linkedin" class="form-label">Linkedin</label>
              <input type="text" name="linkedin" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label for="instagram" class="form-label">Instagram</label>
              <input type="text" name="instagram" class="form-control">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <input type="file" name="image" class="form-control"  id="image" required />
            </div>
            <div class="col-md-12">
              <label for="desc" class="form-label"></label>
              <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Admin" style="width:100px; height: 100px;"  >
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
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });



    $('#image').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });


    $('#myForm').validate({
        rules: {
            title: {
                required : true,
            }, 
        },
        messages :{
            title: {
                required : 'Please Enter Title',
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