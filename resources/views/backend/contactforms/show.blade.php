@extends('layouts.backend')

@section('styles')


@endsection

@section('content')

<div class="pagetitle">
<h1>Contact Form</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.contactforms.index') }}">Contact Form</a></li>
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

                  <h5 class="card-title">Contact Form Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Name</div>
                    <div class="col-lg-9 col-md-8">{{ $contactform->name ?? "" }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $contactform->email ?? "" }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Contact No.</div>
                    <div class="col-lg-9 col-md-8">{{ $contactform->contact_number ?? "" }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Message</div>
                    <div class="col-lg-9 col-md-8">{{ $contactform->message ?? "" }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date</div>
                    <div class="col-lg-9 col-md-8">{{ $contactform->created_at ?? "" }}</div>
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