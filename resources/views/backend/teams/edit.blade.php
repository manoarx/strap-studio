@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>Team</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.teams.index') }}">Team</a></li>
  <li class="breadcrumb-item active">Edit Team</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Team</h5>

          <form id="myForm" class="row g-3" action="{{ route('admin.teams.update', [$team->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $team->id }}">
            <input type="hidden" name="old_image" value="{{ $team->image }}">
            <div class="col-md-12">
              <label for="page" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', isset($team) ? $team->name : '') }}" required>
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Short Desc</label>
              <input type="text" name="desc" class="form-control" value="{{ old('desc', isset($team) ? $team->desc : '') }}" required>
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Linkedin</label>
              <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin', isset($team) ? $team->linkedin : '') }}">
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Instagram</label>
              <input type="text" name="instagram" class="form-control" value="{{ old('instagram', isset($team) ? $team->instagram : '') }}">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <input type="file" name="image" class="form-control"  id="image"   />
            </div>
            <div class="col-md-12">
              <label for="inputPassword4" class="form-label"></label>
              <img id="showImage" src="{{ asset($team->image)   }}" alt="Admin" style="width:100px; height: 100px;"  >
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
  });
</script>
@endsection