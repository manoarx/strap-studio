@extends('layouts.backend')

@section('styles')


@endsection

@section('content')

<div class="pagetitle">
<h1>Settings</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
  <li class="breadcrumb-item active">Detail</li>
</ol>
</nav>
</div>

<section class="section profile">
      <div class="row">


        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">

              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Settings Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Name</div>
                    <div class="col-lg-9 col-md-8">{{ $setting->name ?? "" }}</div>
                  </div>


                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Value</div>
                    <div class="col-lg-9 col-md-8">{{ $setting->value ?? "" }}</div>
                  </div>


                </div>

 

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

@endsection

@section('scripts')


@endsection