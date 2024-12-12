@extends('layouts.backend')
  
@section('content')
<div class="pagetitle">
<h1>Dashboard</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Dashboard</li>
</ol>
</nav>
</div><!-- End Page Title -->


@endsection

@section('scripts')


@endsection