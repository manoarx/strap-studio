@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','aboutus')->get();
$teams = App\Models\Teams::get();
@endphp
<section class="about_start">
        <figure><img src="{{ isset($banner[0]->image) ? asset($banner[0]->image) : '/frontend/assets/images/Nikon-2371Bw-banner.jpg'}}"></figure>
        <div class="container cMN_wTh about_start_btm">
          <div class="mx-auto about_start_txtz">
            <h1 class="about_start_head home_service_header">{{$banner[0]->title ?? 'Welcome to Strap Studios'}}</h1>
            <p>{{$banner[0]->short_title ?? ''}}
            </p>
          </div>
        </div>
      </section>
      <section class="about_our_aprCh py-3 py-md-4 py-lg-5">
        <div class="about_our_aprCh_banner">
          <figure>
            <img src="{{ isset($banner[1]->image) ? asset($banner[1]->image) : '/frontend/assets/images/about_approach.png'}}">
          </figure>
        </div>

        <div class="round_aprch round_aprch_a ">

        </div>
        <div class="round_aprch round_aprch_b">

        </div>


        <div class="container cMN_wTh py-3 py-md-4 py-lg-5">

          <div class="row">
            <div class="col-md-6 d-flex" data-sal="slide-up" style="--sal-duration: 2s; --sal-delay: 0s">
              <div class="_our_aprCh my-3 my-md-0">
                <h4 class="_our_aprCh_head home_service_header">Our Approach</h4>
                <p>{{ $settings['about_our_approach'] ?? '' }}</p>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 d-flex" data-sal="slide-up" style="--sal-duration: 2s; --sal-delay: 0.2s">
              <div class="_our_aprCh my-3 my-md-0">
                <h4 class="_our_aprCh_head home_service_header">Our Experience</h4>
                <p>{{ $settings['about_our_experience'] ?? '' }}</p>
              </div>
            </div>
          </div>


        </div>
      </section>


      <section class="about_portfoliO_wrap py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5">

          <div class="mx-auto about_portfoliO mb-3 mb-md-4 mb-lg-5">
            <h4 class="home_service_header">Portfolio</h4>
            <p>{{ $settings['about_portfolio'] ?? '' }}</p>
            <div class="d-flex mx-auto">
              <a href="{{ route('portfolio') }}" class="button_c">View Our Portfolio</a>
            </div>

          </div>

          <div class="row prtFlio_ mt-0 mt-sm-3 mt-md-4 mt-lg-5">
            @foreach($portfolios as $portfolio)
            <div class="col-lg-4 col-sm-7">
              <div class="prtFlio_z">
                <figure>
                  <img src="{{$portfolio->getFirstMediaUrl('photos') ?? ''}}">
                </figure>
                <h4 class="prtFlio_z_head">{{ $portfolio->name ?? '' }}</h4>
                <a href="{{url('portfolio/'.$portfolio->slug)}}" class="prtFlioPageItemLink"></a>
              </div>
            </div>
            @endforeach
            <!-- <div class="col-lg-3 col-sm-5">
              <div class="prtFlio_z">
                <figure>
                  <img src="/frontend/assets/images/portfolio_04.png">
                </figure>
                <h4 class="prtFlio_z_head">Food Photos</h4>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="prtFlio_z">
                <figure>
                  <img src="/frontend/assets/images/portfolio_01.png">
                </figure>
                <h4 class="prtFlio_z_head">Production Studio</h4>
              </div>
            </div> -->



          </div>
        </div>
      </section>

      <section class="about_our_team py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5">
          <div class="row">
            <div class="col-md-12">
              <div class="pb-3 pb-md-4 pb-lg-5">
                <h4 class="home_service_header">Our Team</h4>
              </div>
            </div>

            @foreach($teams as $team)
            <div class="col-6 col-sm-6 col-md-6 col-lg-4 d-flex">
              <div class="orTeam_wrp">
                <figure>
                  <img src="{{ isset($team->image) ? asset($team->image) : '/upload/no_image.jpg'}}">
                </figure>
                <div class="orTeam_wrp_txt">
                  <h4 class="orTeam_wrp_head">{{$team->name ?? ''}}</h4>
                  <p>{{$team->desc ?? ''}}</p>
                </div>
                <div class="orTeam_wrp_socail">
                  <ul>
                    <li>
                      <a href="{{$team->linkedin ?? ''}}">
                        <i class="icon-linkedin"></i>
                        <span>Linkedin</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{$team->instagram ?? ''}}">
                        <i class="icon-instagram"></i>
                        <span>Instagram</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            @endforeach

          </div>
        </div>
      </section>



      @include('partials.frontend.testimonials')

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

      $(document).on("click", ".theBookIng", function () {
        $("#bookingModal").modal("show");

      });


    });


  </script>

@endsection    