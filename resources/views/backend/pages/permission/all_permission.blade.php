@extends('layouts.backend')

@section('styles')

@endsection

@section('content')


<div class="pagetitle">
<h1>All Permission</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="">Home</a></li>
  <li class="breadcrumb-item active">All Permission</li>
</ol>
</nav>
</div><!-- End Page Title -->
<div class="text-right d-flex">
    <a href="{{ route('admin.add.permission') }}" type="button" class="btn btn-primary ms-auto me-0">Add Permission</a>
</div>
<div>&nbsp;</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">


    <div class="card">
        <div class="card-body">
        	<h5 class="card-title">Permissions List</h5>
            
                <table class="table table-hover table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Permission Name </th>
                            <th>Permission Group</th> 
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($permissions as $key=> $item ) 
                        <tr data-entry-id="{{ $item->id }}">
                            <td>{{ $key+1 }}</td> 
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->group_name }}</td> 
                            <td>
    <a href="{{ route('admin.edit.permission',$item->id) }}" class="btn btn-warning px-3 radius-30"> Edit</a>
    <a href="{{ route('admin.delete.permission',$item->id) }}" class="btn btn-danger px-3 radius-30" id="delete"> Delete</a>

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