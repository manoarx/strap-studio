@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','services')->first();
@endphp
<section class="py-3 py-md-3 py-lg-3 services_holder">
        <figure>
          <img src="{{ isset($banner->image) ? asset($banner->image) : '/frontend/assets/images/services_banner.png'}}">
        </figure>
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 my-auto">
          <div class="d-flex">
            <h1 class="services_holder_head">{{$banner->title ?? 'Services'}}</h1>
          </div>
        </div>
      </section>


      <section class="py-3 py-md-4 py-lg-5">

        <div class="container cMN_wTh py-3 py-md-4 py-lg-5">
          <div class="row srvC_WrpzRow">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6 d-flex col-sm-6 col-6">
              <div class="srvC_Wrpz">
                <figure>
                  <img src="{{ isset($service->main_image) ? asset($service->main_image) : '/upload/no_image.jpg'}}">
                </figure>

                <h4 class="srvC_Wrpz_head">{{ $service->title ?? '' }}</h4>
                <div class="srvC_Wrpz_detail">
                  <div class="srvC_Wrpz_detail_txt">
                    <p>{!! $service->short_title ?? '' !!}</p>
                  </div>
                </div>

                <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                  <a href="{{url('service/'.$service->slug)}}" class="button_b">Book Now</a>
                </div>

              </div>
            </div>
            @endforeach
            <!-- <div class="col-lg-4 col-md-6 d-flex col-sm-6 col-6">
              <div class="srvC_Wrpz">
                <figure>
                  <img src="/frontend/assets/images/servc_page_02.png">
                </figure>

                <h4 class="srvC_Wrpz_head">Maternity</h4>
                <div class="srvC_Wrpz_detail">
                  <div class="srvC_Wrpz_detail_txt">
                    <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                      integer. Mi sed egestas elementum vitae urna.</p>
                  </div>
                </div>
                <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                  <a href="services_package.html" class="button_b">Book Now</a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex col-sm-6 col-6">
              <div class="srvC_Wrpz">
                <figure>
                  <img src="/frontend/assets/images/servc_page_03.png">
                </figure>

                <h4 class="srvC_Wrpz_head">Family</h4>
                <div class="srvC_Wrpz_detail">
                  <div class="srvC_Wrpz_detail_txt">
                    <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                      integer. Mi sed egestas elementum vitae urna.</p>
                  </div>
                </div>
                <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                  <a href="services_package.html" class="button_b">Book Now</a>
                </div>
              </div>
            </div>


            <div class="col-lg-4 col-md-6 d-flex col-sm-6 col-6">
              <div class="srvC_Wrpz">
                <figure>
                  <img src="/frontend/assets/images/servc_page_04.png">
                </figure>

                <h4 class="srvC_Wrpz_head">Baby</h4>
                <div class="srvC_Wrpz_detail">
                  <div class="srvC_Wrpz_detail_txt">
                    <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                      integer. Mi sed egestas elementum vitae urna.</p>
                  </div>
                </div>
                <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                  <a href="services_package.html" class="button_b">Book Now</a>
                </div>
              </div>
            </div>


            <div class="col-lg-4 col-md-6 d-flex col-sm-6 col-6">
              <div class="srvC_Wrpz">
                <figure>
                  <img src="/frontend/assets/images/servc_page_05.png">
                </figure>

                <h4 class="srvC_Wrpz_head">Kids </h4>
                <div class="srvC_Wrpz_detail">
                  <div class="srvC_Wrpz_detail_txt">
                    <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                      integer. Mi sed egestas elementum vitae urna.</p>
                  </div>
                </div>
                <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                  <a href="services_package.html" class="button_b">Book Now</a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex col-sm-6 col-6">
              <div class="srvC_Wrpz">
                <figure>
                  <img src="/frontend/assets/images/servc_page_06.png">
                </figure>

                <h4 class="srvC_Wrpz_head">Pet Photography </h4>
                <div class="srvC_Wrpz_detail">
                  <div class="srvC_Wrpz_detail_txt">
                    <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                      integer. Mi sed egestas elementum vitae urna.</p>
                  </div>
                </div>
                <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                  <a href="services_package.html" class="button_b">Book Now</a>
                </div>
              </div>
            </div>

            <div class="col-lg-8">

              <div class="row srvC_WrpzRow">
                <div class="col-md-12 d-flex">
                  <div class="srvC_Wrpz">
                    <figure>
                      <img src="/frontend/assets/images/servc_page_07.png">
                    </figure>

                    <h4 class="srvC_Wrpz_head">Photobooth</h4>
                    <div class="srvC_Wrpz_detail">
                      <div class="srvC_Wrpz_detail_txt">
                        <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                          integer. Mi sed egestas elementum vitae urna.</p>
                      </div>
                    </div>
                    <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                      <a href="services_package.html" class="button_b">Book Now</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6 d-flex">
                  <div class="srvC_Wrpz">
                    <figure>
                      <img src="/frontend/assets/images/servc_page_09.png">
                    </figure>

                    <h4 class="srvC_Wrpz_head">Model Portfolio</h4>
                    <div class="srvC_Wrpz_detail">
                      <div class="srvC_Wrpz_detail_txt">
                        <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                          integer. Mi sed egestas elementum vitae urna.</p>
                      </div>
                    </div>
                    <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                      <a href="services_package.html" class="button_b">Book Now</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6 d-flex">
                  <div class="srvC_Wrpz">
                    <figure>
                      <img src="/frontend/assets/images/servc_page_10.png">
                    </figure>

                    <h4 class="srvC_Wrpz_head">Graduation Shoot </h4>
                    <div class="srvC_Wrpz_detail">
                      <div class="srvC_Wrpz_detail_txt">
                        <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                          integer. Mi sed egestas elementum vitae urna.</p>
                      </div>
                    </div>
                    <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                      <a href="services_package.html" class="button_b">Book Now</a>
                    </div>
                  </div>
                </div>
              </div>


            </div>
            <div class="col-lg-4 d-flex  col-sm-6 col-6">


              <div class="srvC_Wrpz srvC_Wrpz_ht">
                <figure>
                  <img src="/frontend/assets/images/servc_page_08.png">
                </figure>

                <h4 class="srvC_Wrpz_head">Birthday Shoot</h4>
                <h4 class="srvC_Wrpz_tail">Kids | Adults</h4>
                <div class="srvC_Wrpz_detail">
                  <div class="srvC_Wrpz_detail_txt">
                    <p>Lorem ipsum dolor sit amet consectetur. Amet euismod tempus elit faucibus amet justo viverra
                      integer. Mi sed egestas elementum vitae urna.</p>
                  </div>
                </div>
                <div class="srvC_Wrpz_button d-flex mt-auto mb-0 mx-auto">
                  <a href="services_package.html" class="button_b">Book Now</a>
                </div>
              </div>


            </div> -->

          </div>
        </div>
      </section>

@endsection     

@section('scripts')

<script>
    $(document).ready(function () {
      // sal();
      sal({
        threshold: 0.05,
      });

      $(".the_HmZ").owlCarousel({
        autoplayHoverPause: true,
        transitionStyle: "fade",
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        smartSpeed: 5000,
        autoplayTimeout: 6000,
        items: 1,
        loop: true,
        margin: 0,
        autoWidth: false,
        autoplay: true,
        dots: true,
        nav: false,
        navText: [
          '<i class="icon-left_arrow"></i>',
          '<i class="icon-right_arrow"></i>',
        ],
      });


      $('.the_Wrkshop').owlCarousel({
        autoplayHoverPause: true,
        slideTransition: 'linear',
        autoplayTimeout: 2000,
        autoplaySpeed: 2000,
        items: 4,
        loop: true,
        margin: 30,
        autoWidth: false,
        autoplay: false,
        dots: false,
        nav: true,
        navText: ['<i class="icon-chev_left"></i>', '<i class="icon-chev_right"></i>'],
        responsive: {
          0: {
            margin: 8,
            items: 2,
          },
          600: {
            margin: 15,
            items: 2,
          },
          900: {
            margin: 20,
            items: 3,
          },
          1000: {
            margin: 25,
            items: 4,
          },
          1200: {
            margin: 30,
            items: 4,
          }
        }
      });

      $('.the_portfoLio').owlCarousel({
        autoplayHoverPause: true,
        slideTransition: 'linear',
        autoplayTimeout: 2000,
        autoplaySpeed: 2000,
        items: 2,
        loop: true,
        margin: 0,
        autoWidth: true,
        autoplay: false,
        dots: false,
        nav: true,
        navText: ['<i class="icon-chev_left"></i>', '<i class="icon-chev_right"></i>'],
        responsive: {
          0: {
            margin: 0,
            items: 1,
          },
          600: {
            margin: 0,
            items: 1,
          },
          900: {
            margin: 0,
            items: 1,
          },
          1000: {
            margin: 0,
            items: 2,
          },
          1200: {
            margin: 0,
            items: 2,
          }
        }
      });


      $('.the_testMnL').owlCarousel({
        autoplayHoverPause: true,
        slideTransition: 'linear',
        autoplayTimeout: 2000,
        autoplaySpeed: 2000,
        items: 1,
        loop: true,
        margin: 0,
        autoWidth: false,
        autoplay: false,
        dots: true,
        nav: false,
        navText: ['<i class="icon-chev_left"></i>', '<i class="icon-chev_right"></i>'],

      });


      $('.the_Clients').owlCarousel({
        autoplayHoverPause: true,
        slideTransition: 'linear',
        autoplayTimeout: 2000,
        autoplaySpeed: 2000,
        items: 5,
        loop: true,
        margin: 16,
        autoWidth: false,
        autoplay: false,
        dots: false,
        nav: true,
        navText: ['<i class="icon-arrow_left"></i>', '<i class="icon-arrow_right"></i>'],
        responsive: {
          0: {
            margin: 8,
            items: 2,
          },
          600: {
            margin: 15,
            items: 2,
          },
          900: {
            margin: 20,
            items: 3,
          },
          1000: {
            margin: 25,
            items: 4,
          },
          1200: {
            margin: 30,
            items: 5,
          }
        }
      });

    });


  </script>

@endsection    

