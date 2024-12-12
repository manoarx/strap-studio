@extends('layouts.backend')

@section('styles')

@endsection

@section('content')


<div class="pagetitle">
<h1>All Admin User</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">All Admin User</li>
</ol>
</nav>
</div><!-- End Page Title -->
<div class="text-right d-flex">
    <a href="{{ route('admin.add.admin') }}" type="button" class="btn btn-primary ms-auto me-0">Add Admin</a>
</div>
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">


    <div class="card">
        <div class="card-body">
        	<h5 class="card-title">Admin List</h5>
            
                <table class="table table-hover table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Image </th>
                            <th>Name </th> 
                            <th>Email </th>
                            <th>Phone </th>
                            <th>Role </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($alladmin as $key=> $item ) 
                        <tr>
                            <td>{{ $key+1 }}</td> 
                            <td> <img src="{{ (!empty($item->photo)) ? url('upload/admin_images/'.$item->photo) : url('upload/no_image.jpg') }}" alt="" style="width: 70px; height:40px;"> </td>  
                            <td>{{ $item->name }}</td> 
                            <td>{{ $item->email }}</td> 
                            <td>{{ $item->phone }}</td> 
                            <td>
                             @foreach ($item->roles as $role)
                                 <span class="badge badge-pill bg-danger">{{ $role->name }}</span>
                             @endforeach   
                            
                            </td>  
                            <td>
                <a href="{{ route('admin.edit.admin',$item->id) }}" class="btn btn-warning px-3 radius-30"> Edit</a>
                <a href="{{ route('admin.delete.admin',$item->id) }}" class="btn btn-danger px-3 radius-30" id="delete"> Delete</a>

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