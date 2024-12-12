@extends('layouts.backend')

@section('styles')


@endsection

@section('content')

<div class="pagetitle">
<h1>Videography</h1>
<nav>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.videos.index') }}">Videography</a></li>
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

                  <h5 class="card-title">Videography Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Name</div>
                    <div class="col-lg-9 col-md-8">{{ $video->name ?? "" }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Background Image</div>
                    <div class="col-lg-9 col-md-8">@foreach($video->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endforeach</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Videos</div>
                    <div>&nbsp;</div>
                    @foreach($video->getMedia('video') as $videoItem)
                      <div>
                          <video width="320" height="240" controls>
                              <source src="{{ $videoItem->getUrl() }}" type="{{ $videoItem->mime_type }}">
                              Your browser does not support the video tag.
                          </video>
                      </div>
                  @endforeach
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