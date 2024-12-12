@extends('layouts.backend')

@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

@endsection

@section('content')

<div class="pagetitle">
<h1>Student</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Student</a></li>
  <li class="breadcrumb-item active">Edit Student</li>
</ol>
</nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Student</h5>

          <form id="myForm" class="row g-3" action="{{ route('admin.students.update', [$student->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="userid" value="{{ $student->user->id }}">
            <input type="hidden" name="id" value="{{ $student->id }}">
            <input type="hidden" name="old_image" value="{{ $student->image }}">
            <div class="col-md-12">
              <label for="page" class="form-label">School</label>
              <select name="school_id" class="form-select mb-3" aria-label="Default select example" required>
              <option selected="">Select School</option>
              @foreach($schools as $school)
              <option value="{{ $school->id ?? '' }}" {{ $student->school_id == $school->id ? 'selected' : '' }}>{{ $school->school_name ?? '' }}</option>
              @endforeach
              </select>
            </div>
            <div class="form-group col-md-12">
              <label for="student_name" class="form-label">Student Name </label>
              <input type="text" name="student_name" class="form-control" value="{{ old('student_name', isset($student) ? $student->student_name : '') }}" required>
            </div>
            <div class="form-group col-md-12">
              <label for="student_last_name" class="form-label">Student Last Name </label>
              <input type="text" name="student_last_name" class="form-control" value="{{ old('student_last_name', isset($student) ? $student->student_last_name : '') }}">
            </div>
            <div class="form-group col-md-12">
              <label for="classe" class="form-label">Classe </label>
              <input type="text" name="classe" class="form-control" value="{{ old('classe', isset($student) ? $student->classe : '') }}">
            </div>
            <div class="form-group col-md-12">
              <label for="father_name" class="form-label">Father Name</label>
              <input type="text" name="father_name" class="form-control" value="{{ old('father_name', isset($student) ? $student->father_name : '') }}">
            </div>
            <div class="form-group col-md-12">
              <label for="last_father_name" class="form-label">Father Last Name</label>
              <input type="text" name="last_father_name" class="form-control" value="{{ old('last_father_name', isset($student) ? $student->last_father_name : '') }}">
            </div>
            <div class="form-group col-md-12">
              <label for="addresse_email" class="form-label">Addresse Email </label>
              <input type="text" name="addresse_email" class="form-control" value="{{ old('addresse_email', isset($student) ? $student->addresse_email : '') }}">
            </div>
            <div class="form-group col-md-12">
              <label for="addresse_email" class="form-label">Mother Email </label>
              <input type="text" name="mother_email" class="form-control" value="{{ old('mother_email', isset($student) ? $student->mother_email : '') }}">
            </div>
            <div class="form-group col-md-12">
              <label for="telephone_mobile" class="form-label">Telephone / Mobile </label>
              <input type="text" name="telephone_mobile" class="form-control" value="{{ old('telephone_mobile', isset($student) ? $student->telephone_mobile : '') }}">
            </div>
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Image</label>
              <input type="file" name="image" class="form-control"  id="image"   />
            </div>
            <div class="col-md-12">
              <label for="inputPassword4" class="form-label"></label>
              <img id="showImage" src="{{ isset($student->image) ? asset($student->image) : '/upload/no_image.jpg' }}" alt="Admin" style="width:100px; height: 100px;"  >
            </div>
            <div class="form-group col-md-12">
              <label for="telephone_mobile" class="form-label">Year </label>
              <input type="text" name="year" class="form-control" value="{{ old('year', isset($student) ? $student->year : '') }}">
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