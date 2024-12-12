@extends('layouts.backend')

@section('styles')

@endsection

@section('content')


<div class="pagetitle">
<h1>All Roles Permission</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">All Roles Permission</li>
</ol>
</nav>
</div><!-- End Page Title -->
<div class="text-right d-flex">
    <a href="{{ route('admin.add.roles.permission') }}" type="button" class="btn btn-primary ms-auto me-0">Add Role in Permission</a>
</div>
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">


    <div class="card">
        <div class="card-body">
        	<h5 class="card-title">Roles List</h5>
            
                <table class="table table-hover table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Roles Name </th> 
                            <th>Permission </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($roles as $key=> $item ) 
                        <tr>
                            <td>{{ $key+1 }}</td> 
                            <td>{{ $item->name }}</td> 

                            <td>
                            @foreach ($item->permissions as $perm)
       <span class="badge bg-danger">{{ $perm->name  }}</span>                         
                            @endforeach    
                            </td> 
                            <td>
    <a href="{{ route('admin.admin.edit.roles',$item->id) }}" class="btn btn-warning px-3 radius-30"> Edit</a>
    <a href="{{ route('admin.admin.delete.roles',$item->id) }}" class="btn btn-danger px-3 radius-30" id="delete"> Delete</a>

                            </td>
                        </tr>
                        @endforeach 

                    </tbody>

                </table>
            
        </div>
    </div>

   

</div>
</div>
</section>


@endsection

@section('scripts')

@endsection