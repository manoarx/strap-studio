@extends('layouts.frontend')
@section('content')
<section class="py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh my-auto pb-3 pb-md-4 pb-lg-5">
          <div class="d-flex flex-wrap">
            <div class="inside_page_Head">
              <h4>Orders</h4>
            </div>
            @if(Auth::user()->type == 'customer')
            @include('frontend.customer.sidebar')
            @endif
            <div class="inside_page_Rft">
<div class="col-md-6">
            <div class="card">
               <div class="card-header"><h4>Order Details
<span class="text-danger">Invoice : {{ $order->invoice_no }} </span></h4>
                </div> 
               <hr>
               <div class="card-body">
                <table class="table" style="background:#F4F6FA;font-weight: 600;">
                    <tr>
                        <th> Name :</th>
                        <th>{{ $order->user->name }}</th>
                    </tr>
                    @if($order->user->school_id != "")
                    <tr>
                        <th> School Name :</th>
                        <th>{{ $order->user->school->school_name ?? '' }}</th>
                    </tr>
                    @endif
                    <tr>
                        <th>Phone :</th>
                      <th>{{ $order->user->phone }}</th>
                    </tr>

                    <tr>
                        <th>Payment Type:</th>
                       <th>{{ $order->payment_method }}</th>
                    </tr>


                    <tr>
                        <th>Transx ID:</th>
                       <th>{{ $order->transaction_id }}</th>
                    </tr>

                    <tr>
                        <th>Invoice:</th>
                       <th class="text-danger">{{ $order->invoice_no }}</th>
                    </tr>

                    <tr>
                        <th>Order Amonut:</th>
                         <th>AED {{ $order->amount }}</th>
                    </tr>

                     <tr>
                        <th>Order Status:</th>
      <th><span class="badge rounded-pill bg-warning">{{ $order->status }}</span></th>
                    </tr>
                    
                </table>
                   
               </div>

            </div>
        </div>
                <div class="col-md-12">
                    <div class="table-responsive">
<table class="table" style="font-weight: 600;">
    <tbody>
        <tr>
            <td class="col-md-2">
                <label>Type </label>
            </td>
            @if($order->user->school_id != "")
            <td class="col-md-2">
                <label>Student Name </label>
            </td>
            @endif
            <td class="col-md-2">
                <label>Product Name </label>
            </td>
            @if(Auth::user()->type == 'customer')
            <td class="col-md-2">
                <label>Time</label>
            </td>
            @endif
            <td class="col-md-1">
                <label>Quantity </label>
            </td>

            <td class="col-md-3">
                <label>Price  </label>
            </td> 

        </tr>


        @foreach($orderItem as $item)
        @php
        if($item->product_type == 'workshop') {
          $itemtype = $item->workshop;
          $title = $itemtype->title;
        } elseif($item->product_type == 'service') {
          $itemtype = $item->servicepackage;
          $title = $itemtype->service->title." - ".$itemtype->package_name;
        } elseif($item->product_type == 'studiorental') {
          $itemtype = $item->studiorental;
          $title = $itemtype->title;
        } else {
          $itemtype = $item->product;
          $title = $itemtype->title;
        } 
        @endphp
         <tr>
            <td class="col-md-2">
                <label>{{ ucwords($item->product_type) }}</label>
            </td>
            @if($order->user->school_id != "")
            <td class="col-md-2">
                <label>{{ $item->product->student->student_name ?? '' }} {{ $item->product->student->student_last_name ?? '' }} - {{ $item->product->student->classe ?? '' }}</label>
            </td>
            @endif
            <td class="col-md-2">
                <label>{{ $title ?? ''}}</label>
                @if($item->option_id)
                <span>Option - {{$item->option->option_name ?? ''}}</span>
                @endif
                @if($item->addon_id)
                <span>Addon - {{$item->addon->addon_name ?? ''}}</span>
                @endif
            </td>
            @if(Auth::user()->type == 'customer')
            <td class="col-md-2">
                <label>{{ $item->booked_date }} - ({{ $item->booked_stime }} - {{ $item->booked_etime }})</label>
            </td>
            @endif
            <td class="col-md-1">
                <label>{{ $item->qty }} </label>
            </td>
            @if($item->product_type == 'product')
            <td class="col-md-2">
                <label>Hard Copy </label>
            </td>
            <td class="col-md-2">
                <label>Digital Copy </label>
            </td>
            @else
            <td class="col-md-3">
                <label>AED {{ $item->price }}    </label>
            </td>
            @endif
            

        </tr>
        @endforeach

    </tbody>
</table>
                        
                    </div>
                    
                </div>


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