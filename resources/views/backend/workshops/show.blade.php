@extends('layouts.backend')

@section('styles')


@endsection

@section('content')

<div class="pagetitle">
<h1>workshops</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.workshops.index') }}">Workshops</a></li>
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

                  <h5 class="card-title">Workshops Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Title</div>
                    <div class="col-lg-9 col-md-8">{{ $workshop->title ?? "" }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Product Code</div>
                    <div class="col-lg-9 col-md-8">{{ $workshop->code ?? "" }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Selling Price</div>
                    <div class="col-lg-9 col-md-8">{{ $workshop->selling_price ?? "" }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Discount Price</div>
                    <div class="col-lg-9 col-md-8">{{ $workshop->discount_price ?? "" }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Short Title</div>
                    <div class="col-lg-9 col-md-8">{{ $workshop->short_title ?? "" }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">About Course</div>
                    <div class="col-lg-9 col-md-8">{!! $workshop->about_course ?? "" !!}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Covered Items</div>
                    <div class="col-lg-9 col-md-8">{!! $workshop->cover ?? "" !!}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Notes</div>
                    <div class="col-lg-9 col-md-8">{!! $workshop->notes ?? "" !!}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Image</div>
                    <div class="col-lg-9 col-md-8">@foreach($workshop->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endforeach</div>
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