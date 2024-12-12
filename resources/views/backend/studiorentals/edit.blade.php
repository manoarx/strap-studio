@extends('layouts.backend')

@section('styles')


@endsection

@section('content')

<div class="pagetitle">
<h1>Studio Rentals</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.studiorentals.index') }}">Studio Rentals</a></li>
  <li class="breadcrumb-item active">Edit Studio Rentals</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Studio Rentals</h5>

          <form id="myForm" class="row g-3" action="{{ route('admin.studiorentals.update', [$studiorental->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $studiorental->id }}">
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Package Name</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', isset($studiorental) ? $studiorental->title : '') }}" required>
            </div>
            <div class="col-md-12">
              <label for="inputNanme4" class="form-label">Price</label>
              <input type="text" name="price" class="form-control" value="{{ old('price', isset($studiorental) ? $studiorental->price : '') }}" required>
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