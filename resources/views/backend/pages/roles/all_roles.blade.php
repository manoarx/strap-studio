@extends('layouts.backend')

@section('styles')

@endsection

@section('content')


<div class="pagetitle">
<h1>All Roles</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">All Roles</li>
</ol>
</nav>
</div><!-- End Page Title -->
<div class="text-right d-flex">
    <a href="{{ route('admin.add.roles') }}" type="button" class="btn btn-primary ms-auto me-0">Add Roles</a>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($roles as $key=> $item ) 
                        <tr>
                            <td>{{ $key+1 }}</td> 
                            <td>{{ $item->name }}</td> 
                            <td>
    <a href="{{ route('admin.edit.roles',$item->id) }}" class="btn btn-warning px-3 radius-30"> Edit</a>
    <a href="{{ route('admin.delete.roles',$item->id) }}" class="btn btn-danger px-3 radius-30" id="delete"> Delete</a>

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