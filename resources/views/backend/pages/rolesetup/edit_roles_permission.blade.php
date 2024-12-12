@extends('layouts.backend')

@section('styles')
 <style>
    .form-check-label{
        text-transform: capitalize;
    }
 </style>
@endsection

@section('content')


<div class="pagetitle">
<h1>Edit Roles in Permission</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Edit Roles in Permission</li>
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
						<form  class="row g-3" action="{{ route('admin.admin.roles.update',$role->id) }}" method="post" enctype="multipart/form-data">
         @csrf



    <div class="col-md-6">
        <label for="input1" class="form-label">Roles Name </label>
        <h3>{{ $role->name }}</h3>

    </div> 

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="CheckDefaultmain">
        <label class="form-check-label" for="CheckDefaultmain">Permission All </label>
    </div>

    <hr>

        @foreach ($permission_groups as $group) 
        <div class="row"> 
            <div class="col-3">
     @php
      $permissions = App\Models\User::getpermissionByGroupName($group->group_name)
     @endphp

                <div class="form-check">
      <input class="form-check-input" type="checkbox"  id="CheckDefault" {{ App\Models\User::roleHasPermissions($role,$permissions) ? 'checked' : '' }}>

      <label class="form-check-label" for="CheckDefault"> {{ $group->group_name }} </label>
                </div>

            </div>

            <div class="col-9">

            @foreach ($permissions as $permission) 
                <div class="form-check">
            <input class="form-check-input" type="checkbox" name="permission[]"  id="CheckDefault{{ $permission->id }}" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>

                    <label class="form-check-label" for="CheckDefault{{ $permission->id }}">{{ $permission->name }} </label>
                </div>
                @endforeach
                <br>
            </div>

        </div>
        @endforeach





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
<script>
    $('#CheckDefaultmain').click(function(){
        if ($(this).is(':checked')) {
           $('input[ type= checkbox]').prop('checked',true); 
        }else{
            $('input[ type= checkbox]').prop('checked',false); 
        }
    });
 </script>
@endsection