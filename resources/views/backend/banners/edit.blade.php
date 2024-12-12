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
  <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banner</a></li>
  <li class="breadcrumb-item active">Edit Banner</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Banner</h5>

          <form id="myForm" class="row g-3" action="{{ route('admin.banners.update', [$banner->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $banner->id }}">
            <input type="hidden" name="old_image" value="{{ $banner->image }}">
            <input type="hidden" name="old_offer_image" value="{{ $banner->offerimage }}">
            <div class="col-md-12">
              <label for="page" class="form-label">Page</label>
              <select name="page" class="form-select mb-3" aria-label="Default select example" required>
              <option selected="">Select Page</option>
              <option value="home" {{ $banner->page == 'home' ? 'selected' : '' }}>Home</option>
              <option value="homeaboutus" {{ $banner->page == 'homeaboutus' ? 'selected' : '' }}>Home About Us</option>
              <option value="services" {{ $banner->page == 'services' ? 'selected' : '' }}>Services</option>
              <option value="studiorentals" {{ $banner->page == 'studiorentals' ? 'selected' : '' }}>Studio Rentals</option>
              <option value="workshops" {{ $banner->page == 'workshops' ? 'selected' : '' }}>Workshops</option>
              <option value="portfolio" {{ $banner->page == 'portfolio' ? 'selected' : '' }}>Portfolio</option>
              <option value="aboutus" {{ $banner->page == 'aboutus' ? 'selected' : '' }}>About Us</option>
              <option value="contact" {{ $banner->page == 'contact' ? 'selected' : '' }}>Contact</option>
              </select>
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', isset($banner) ? $banner->title : '') }}" >
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Short Title</label>
              <input type="text" name="short_title" class="form-control" value="{{ old('title', isset($banner) ? $banner->short_title : '') }}">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <input type="file" name="image" class="form-control"  id="image"   />
            </div>
            <div class="col-md-12">
              <label for="inputPassword4" class="form-label"></label>
              <img id="showImage" src="{{ asset($banner->image)   }}" alt="Admin" style="width:100px; height: 100px;"  >
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Offer Image</label>
              <input type="file" name="offerimage" class="form-control"  id="offerimage"   />
            </div>
            <div class="col-md-12">
              <label for="inputPassword4" class="form-label"></label>
              <img id="showOfferImage" src="/upload/banners/thumb/{{ $banner->offerimage ?? 'no_image.jpg' }}" alt="Admin" style="width:100px; height: 100px;"  >
              <button type="button" class="btn btn-danger" id="removeImage" data-banner-id="{{ $banner->id }}">Remove Image</button>
            </div>
            <div class="form-group col-md-4">
              <label for="left_pos" class="form-label">Left Position</label>
              <input type="text" name="left_pos" class="form-control" value="{{ old('left_pos', isset($banner->left_pos) ? $banner->left_pos : '10') }}">
            </div>
            <div class="form-group col-md-4">
              <label for="top_pos" class="form-label">Top Position</label>
              <input type="text" name="top_pos" class="form-control" value="{{ old('top_pos', isset($banner->top_pos) ? $banner->top_pos : '10') }}">
            </div>
            <div class="form-group col-md-4">
              <label for="top_pos" class="form-label">Image Width</label>
              <input type="text" name="offer_width" class="form-control" value="{{ old('offer_width', isset($banner->offer_width) ? $banner->offer_width : '') }}">
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

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                page: {
                    required : true,
                }, 
            },
            messages :{
                page: {
                    required : 'Please Select Page',
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
    
  $(document).ready(function(){
    $('#image').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });

    $('#removeImage').on('click', function () {
        var bannerId = $(this).data('banner-id');
        $.ajax({
            type: 'POST',
            url: '{{ url("admin/remove-offerimage") }}/' + bannerId, // Adjust the route accordingly
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                // Handle success - remove the image from the DOM
                $('#showOfferImage').attr('src', '/upload/banners/thumb/no_image.jpg');
                alert('Offer Image Removed');
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });
  });
</script>
@endsection