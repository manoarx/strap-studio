@extends('layouts.backend')

@section('styles')

@endsection

@section('content')


<div class="pagetitle">
<h1>Edit Roles</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">Edit Roles</li>
</ol>
</nav>
</div><!-- End Page Title -->

<div>&nbsp;</div>
<section class="section">
	<div class="row">
		<div class="col-lg-12">

			<div class="col-lg-12">

				<div class="card">

					<div class="card-body p-4">
						<form  class="row g-3" action="{{ route('admin.update.roles') }}" method="post" enctype="multipart/form-data">
         @csrf

        <input type="hidden" name="id" value="{{ $roles->id }}">  

    <div class="col-md-6">
        <label for="input1" class="form-label">Roles Name </label>
        <input type="text" name="name" class="form-control" value="{{ $roles->name }}"   >

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