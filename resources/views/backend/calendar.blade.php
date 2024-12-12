@extends('layouts.backend')
  
@section('content')
<div class="pagetitle">
<h1>Calendar</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Calendar</li>
</ol>
</nav>
</div><!-- End Page Title -->


<iframe src="https://calendar.google.com/calendar/embed?src=vg13elo7m6o55vn4e085ubsb1k%40group.calendar.google.com&ctz=Asia%2FDubai" style="border: 0" width="100%" height="700" frameborder="0" scrolling="no"></iframe>

@endsection

@section('scripts')


@endsection