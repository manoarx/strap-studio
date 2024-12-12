@extends('layouts.backend')

@section('styles')

@endsection

@section('content')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit Permission </div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
							</ol>
						</nav>
					</div>

				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-body p-4">

       <form  class="row g-3" action="{{ route('admin.update.permission') }}" method="post" enctype="multipart/form-data">
         @csrf

    <input type="hidden" name="id" value="{{ $permission->id }}"> 

    <div class="col-md-6">
        <label for="input1" class="form-label">Permission Name </label>
        <input type="text" name="name" class="form-control" value="{{ $permission->name }}"  >

    </div>

    <div class="col-md-6">
        <label for="input1" class="form-label">Permission Group </label>
        <select name="group_name" class="form-select mb-3" aria-label="Default select example">
            <option selected="">Select Group </option>
            <option value="Banners" {{ $permission->group_name == 'Banners' ? 'selected' : '' }}>Banners</option>
            <option value="Schools" {{ $permission->group_name == 'Schools' ? 'selected' : '' }}>Schools</option>
            <option value="Testimonials" {{ $permission->group_name == 'Testimonials' ? 'selected' : '' }}>Testimonials</option>
            <option value="Coupons" {{ $permission->group_name == 'Coupons' ? 'selected' : '' }}>Coupons</option>
            <option value="Clients" {{ $permission->group_name == 'Clients' ? 'selected' : '' }}>Clients</option>
            <option value="Teams" {{ $permission->group_name == 'Teams' ? 'selected' : '' }}>Teams</option>
            <option value="Services" {{ $permission->group_name == 'Services' ? 'selected' : '' }}>Services</option>
            <option value="Studio Rentals" {{ $permission->group_name == 'Studio Rentals' ? 'selected' : '' }}>Studio Rentals</option>
            <option value="Workshops" {{ $permission->group_name == 'Workshops' ? 'selected' : '' }}>Workshops</option>
            <option value="Portfolios" {{ $permission->group_name == 'Portfolios' ? 'selected' : '' }}>Portfolios</option>
            <option value="Videography" {{ $permission->group_name == 'Videography' ? 'selected' : '' }}>Videography</option>
            <option value="Contact Forms" {{ $permission->group_name == 'Contact Forms' ? 'selected' : '' }}>Contact Forms</option>
            <option value="Orders" {{ $permission->group_name == 'Orders' ? 'selected' : '' }}>Orders</option>
            <option value="Settings" {{ $permission->group_name == 'Settings' ? 'selected' : '' }}>Settings</option>
            <option value="Role and Permission" {{ $permission->group_name == 'Role and Permission' ? 'selected' : '' }}>Role and Permission </option>
            <option value="Manage Admin User" {{ $permission->group_name == 'Manage Admin User' ? 'selected' : '' }}>Manage Admin User </option>
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
				</div>
			</div>


@endsection

@section('scripts')

@endsection