@extends('layouts.frontend')
@section('content')
<section class="py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh my-auto pb-3 pb-md-4 pb-lg-5">
          <div class="d-flex flex-wrap pt-3 pt-md-0">
            <div class="inside_page_Head">
              <h4>Orders</h4>
            </div>
            <div class="inside_page_Rft">

              <div class="insd_order_head">
                <div class="insd_order_head01">
                  <h4>Id</h4>
                </div>
                <div class="insd_order_head02">
                  <h4>Date</h4>
                </div>
                <div class="insd_order_head02">
                  <h4>School</h4>
                </div>
                <div class="insd_order_head02">
                  <h4>Payment</h4>
                </div>
                <div class="insd_order_head03">
                  <h4>Total</h4>
                </div>
                <!-- <div class="insd_order_head06">
                  <h4>Download</h4>
                </div> -->
                <div class="insd_order_head04">
                  <h4>Action</h4>
                </div>
              </div>
              @foreach($orders as $key=> $order)
              <div class="insd_order_ech">

                <div class="insd_order_ech_01">
                  <h4>#0{{ $key+1 }}</h4>
                </div>
                <div class="insd_order_ech_02 insd_order_echH_z">
                  <h4>{{ $order->order_date }}</h4>
                </div>
                <div class="insd_order_ech_02 insd_order_echH_z">
                  <h4>{{ $order->user->school->school_name ?? '' }}</h4>
                </div>
                <div class="insd_order_ech_02 insd_order_echH_z">
                  <h4>{{ $order->payment_method }}</h4>
                </div>
                <div class="insd_order_ech_03 insd_order_echH_z">
                  <h4>{{ $order->amount }} AED</h4>
                </div>
                <!-- <div class="insd_order_ech_06 ">
                  <a href="{{ url('invoice_download/'.$order->id) }}" class="order_download"><i class="icon-download"></i><span>Invoice</span></a>
                </div> -->
                <div class="insd_order_ech_04 ">
                  <a href="{{ url('user/order_details/'.$order->id) }}" class="order_download"><i class="icon-download"></i><span>View</span></a>
                </div>
              </div>
              @endforeach


            </div>

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


      fadeslider007.init({
        wrapperId: "the_Clients",
        items: 5,
        timer: 4000,
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
        },
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
            items: 1,
          },
          500: {
            margin: 15,
            items: 2,
          },
          900: {
            margin: 20,
            items: 3,
          },
          1000: {
            margin: 25,
            items: 3,
          },
          1200: {
            margin: 30,
            items: 3,
          },
          1300: {
            margin: 30,
            items: 4,
          }
        }
      });

      $('.the_portfoLio').owlCarousel({
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
            autoWidth: false,
            margin: 0,
            items: 2,
          },
          600: {
            autoWidth: false,
            margin: 0,
            items: 2,
          },
          900: {
            autoWidth: true,
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

      /*       $('.the_portfoLio').on('mousedown', function () {
              $(this).trigger('stop.owl.autoplay');
            });
       */

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
        transitionStyle: "fade",
        autoplayTimeout: 2000,
        autoplaySpeed: 2000,
        items: 5,
        loop: true,
        margin: 16,
        autoWidth: false,
        autoplay: true,
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