@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','aboutus')->get();
$teams = App\Models\Teams::get();
@endphp

      <section class="about_our_aprCh py-3 py-md-4 py-lg-5">


        <div class="round_aprch round_aprch_a ">

        </div>
        <div class="round_aprch round_aprch_b">

        </div>


        <div class="container cMN_wTh py-3 py-md-4 py-lg-5">

          <div class="row">
            <div class='sk-ww-google-reviews' data-embed-id='228990'></div><script src='https://widgets.sociablekit.com/google-reviews/widget.js' async defer></script>
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

      $(document).on("click", ".theBookIng", function () {
        $("#bookingModal").modal("show");

      });


    });


  </script>

@endsection    