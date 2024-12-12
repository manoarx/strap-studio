@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')
<div class="pagetitle">
<h1>Banner</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Banner</li>
</ol>
</nav>
</div><!-- End Page Title -->

<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Banner List</h5>

          <!-- Table with hoverable rows -->
          <table class="table table-hover table-bordered table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title </th>
                <th scope="col">Page</th>
                <th scope="col">Image</th>
                <th scope="col">OfferImage</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($banners as $key => $banner)
              <tr data-entry-id="{{ $banner->id }}">
                <th scope="row">{{ ($key+1) ?? '' }}</th>
                <td>{{ $banner->title ?? '' }}</td>
                <td>{{ $banner->page ?? '' }}</td>
                <td><img src="{{ (!empty($banner->image)) ? asset($banner->image) : url('upload/no_image.jpg') }}" style="width: 50px; height:30px;" >  </td>
                <td><img src="/upload/banners/thumb/{{ (!empty($banner->offerimage)) ? $banner->offerimage : 'no_image.jpg' }}" style="width: 50px; height:30px;" >  </td>
                <td>
                  <a class="btn btn-sm btn-info" href="{{ route('admin.banners.edit', $banner->id) }}">
                      Edit
                  </a>
                  <a class="btn btn-sm btn-danger" href="{{ route('admin.banners.delete',$banner->id) }}" id="delete" >Delete</a>
                  <!-- <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
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
          <h5 class="card-title">Add Banner</h5>

          <form id="myForm" class="row g-3" action="{{ route("admin.banners.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-12">
              <label for="page" class="form-label">Page</label>
              <select name="page" class="form-select mb-3" aria-label="Default select example" required>
              <option selected="">Select Page</option>
              <option value="home">Home</option>
              <option value="homeaboutus">Home About Us</option>
              <option value="services">Services</option>
              <option value="studiorentals">Studio Rentals</option>
              <option value="workshops">Workshops</option>
              <option value="portfolio">Portfolio</option>
              <option value="aboutus">About Us</option>
              <option value="contact">Contact</option>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label for="title" class="form-label">Title </label>
              <input type="text" name="title" class="form-control" >
            </div>
            <div class="form-group col-md-12">
              <label for="banner_name" class="form-label">Short Title</label>
              <input type="text" name="short_title" class="form-control">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Banner</label>
              <input type="file" name="image" class="form-control"  id="image" required />
            </div>
            <div class="col-md-12">
              <label for="desc" class="form-label"></label>
              <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Admin" style="width:100px; height: 100px;"  >
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Offer Image</label>
              <input type="file" name="offerimage" class="form-control"  id="offerimage"  />
            </div>
            <div class="col-md-12">
              <label for="desc" class="form-label"></label>
              <img id="showOfferImage" src="{{ url('upload/no_image.jpg') }}" alt="Admin" style="width:100px; height: 100px;"  >
            </div>
            <div class="form-group col-md-4">
              <label for="left_pos" class="form-label">Left Position</label>
              <input type="text" name="left_pos" class="form-control" value="10">
            </div>
            <div class="form-group col-md-4">
              <label for="top_pos" class="form-label">Top Position</label>
              <input type="text" name="top_pos" class="form-control" value="10">
            </div>
            <div class="form-group col-md-4">
              <label for="offer_width" class="form-label">Image Width</label>
              <input type="text" name="offer_width" class="form-control" value="10">
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

    $('#offerimage').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showOfferImage').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });


    $('#myForm').validate({
        rules: {
            image: {
                required : true,
            }, 
        },
        messages :{
            image: {
                required : 'Select Banner',
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