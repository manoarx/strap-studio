@extends('layouts.backend')

@section('styles')

@endsection

@section('content')


<div class="pagetitle">
<h1>Add Admin User</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Add Admin User</li>
</ol>
</nav>
</div><!-- End Page Title -->
<!-- <div class="text-right d-flex">
    <a href="{{ route('admin.add.permission') }}" type="button" class="btn btn-primary ms-auto me-0">Add Roles</a>
</div> -->
<div>&nbsp;</div>
<section class="section">
	<div class="row">
		<div class="col-lg-12">

			<div class="col-lg-12">

				<div class="card">

					<div class="card-body p-4">
						<form  class="row g-3" action="{{ route('admin.store.admin') }}" method="post" enctype="multipart/form-data">
							@csrf



							<div class="col-md-6">
        <label for="input1" class="form-label">Admin User Name </label>
        <input type="text" name="name" class="form-control"   >
         
    </div>

    <div class="col-md-6">
        <label for="input1" class="form-label">Admin User Email </label>
        <input type="email" name="email" class="form-control"   >
         
    </div>

    <div class="col-md-6">
        <label for="input1" class="form-label">Admin User Phone </label>
        <input type="text" name="phone" class="form-control"   >
         
    </div>
    <div class="col-md-6">
        <label for="input1" class="form-label">Admin User Address </label>
        <input type="text" name="address" class="form-control"   >
         
    </div>


    <div class="col-md-6">
        <label for="input1" class="form-label">Admin Password </label>
        <input type="password" name="password" class="form-control"   >
         
    </div>

    <div class="col-md-6">
        <label for="input1" class="form-label">Role Name </label>
        <select name="roles" class="form-select mb-3" aria-label="Default select example">
            <option selected="">Select Role </option>
            @foreach ($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }} </option> 
            @endforeach
            
        </select>
         
    </div>
    
 
                 
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">Save Changes </button>
                            
                        </div>
                    </div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>


@endsection

@section('scripts')

@endsection