@extends('layouts.frontend')
@section('styles')
<style>
/**
* The CSS shown here will not be introduced in the Quickstart guide, but shows
* how you can use CSS to style your Element's container.
*/
  .StripeElement {
    box-sizing: border-box;
    height: 40px;
    width: 100%;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
  }
  .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }
  .StripeElement--invalid {
    border-color: #fa755a;
  }
  .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;}
  </style>
  @endsection
  @section('content')
  <section class="py-3 py-md-4 py-lg-5">
    <div class="container cMN_wTh my-auto pb-3 pb-md-4 pb-lg-5">
      <div class="d-flex flex-wrap">
        <div class="inside_page_Head">
          <h4>Cart</h4>
        </div>

        <div class="insid_car_Lft">

          <div class="accordion" id="accordionCart">
            @php
            $disablepayment = false;
            @endphp
            @foreach($carts as $cart)
            @if($cart->options->pkg_type == 'service')
            @php
            $selected_date = $cart->options->booked_date;
            $selectedStartTime = $cart->options->booked_stime;
            $duration = $cart->options->booked_duration;
            $selectedEndTime = date('H:i', strtotime($selectedStartTime . ' +' . $duration . ' minutes'));
            

            $warning_msg = '';

            $isBooked = DB::table('order_items')
            ->where('booked_date', '=', $selected_date)
            ->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
                $query->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
                    $query->where('booked_stime', '<=', $selectedStartTime)
                        ->where('booked_etime', '>', $selectedStartTime);
                })->orWhere(function ($query) use ($selectedStartTime, $selectedEndTime) {
                    $query->where('booked_stime', '<', $selectedEndTime)
                        ->where('booked_etime', '>=', $selectedEndTime);
                });
            })->exists();

            if ($isBooked) {
                $disablepayment = true;
                $warning_msg = 'Selected date and time already booked, Please remove from cart and select another date.';
                
            }

            $servicepackage = App\Models\ServicePackages::find($cart->id);
            $serviceoptions = $serviceaddons = "";
            if($cart->options->option_id > 0) {
              $serviceoptions = App\Models\ServicePackageOptions::find($cart->options->option_id);
            }
            if($cart->options->addon_id > 0) {
              $serviceaddons = App\Models\ServicePackageAddons::find($cart->options->addon_id);
            }
            $optionprice = isset($serviceoptions->option_price) ? $serviceoptions->option_price : 0;
            $addonprice = isset($serviceaddons->addon_price) ? $serviceaddons->addon_price : 0;
            $totprice = ($servicepackage->price + $optionprice + ($addonprice*$cart->options->addon_qty));
            @endphp
            <div class="accordion-item" id="{{$cart->rowId ?? ''}}">
              <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">

                <div class="accordionCart_Header">

                  <div class="accordionCart_Head_EbLk accordionCart_Head_01">
                    <h4>#0{{ $loop->iteration }}</h4>
                  </div>

                  <div class="accordionCart_Head_EbLk accordionCart_Head_02">
                    <h4>{{ $servicepackage->service->title ?? '' }} </h4>
                    <!-- <p><strong>Added on</strong> 03 -03 2023</p> -->

                  </div>

                  <div class="accordionCart_Head_EbLk accordionCart_Head_03">
                    <h4>{{ $servicepackage->package_name ?? '' }}</h4>
                  </div>

                  <div class="accordionCart_Head_EbLk accordionCart_Head_04">
                    <h4>{{ $cart->qty }}</h4>
                  </div>

                  <div class="accordionCart_Head_EbLk accordionCart_Head_05">
                    <h4>{{ $totprice ?? '' }} AED</h4>
                  </div>

                </div>
              </button>
            </h2>
            <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $loop->iteration }}"
              data-bs-parent="#accordionCart">
              <div class="accordion-body">
                <div class="cart_adnZ_Wrp">
                  <div class="cart_adnZ">
                    @if($serviceoptions)
                    <div class="accordionCart_Head_EbLk">
                      <h4>Options</h4>
                    </div>

                    <div class="accordionCart_opTionz">

                      <div class="accordionCart_opTionz_01">
                        <p>{{$serviceoptions->option_name ?? ''}}</p>
                        <p>{{$serviceoptions->option_price ?? ''}} AED</p>
                        <p>&nbsp;</p>
                      </div>

                    </div>
                    @endif

                    @if($serviceaddons)
                    <div class="accordionCart_Head_EbLk">
                      <h4>Addons</h4>
                    </div>

                    <div class="accordionCart_opTionz">

                      <div class="accordionCart_opTionz_01">
                        <p>{{$serviceaddons->addon_name ?? ''}}</p>
                        <p>{{$serviceaddons->addon_price ?? ''}} AED</p>
                        <p>
                          <select name="addon_qty" data-addon-price="{{$serviceaddons->addon_price ?? ''}}" data-cart-id="{{$cart->rowId ?? ''}}" class="addon_qty_update">
                            <option value="1" @if($cart->options->addon_qty == 1) selected @endif>1</option>
                            <option value="2" @if($cart->options->addon_qty == 2) selected @endif>2</option>
                            <option value="3" @if($cart->options->addon_qty == 3) selected @endif>3</option>
                            <option value="4" @if($cart->options->addon_qty == 4) selected @endif>4</option>
                            <option value="5" @if($cart->options->addon_qty == 5) selected @endif>5</option>
                          </select>
                        </p>
                      </div>

                    </div>
                    @endif

                    <div class="cart_adnZ_dTlz_service">
                      
                      <div class="cart_adnZ_dTlz02">
                        <div class="accordionCart_Head_EbLk">
                          <!-- <h4>Location</h4> -->
                        </div>
                        <!-- <p><i class="icon-location"></i>Lorem ipsum, sgagew, kgsgjas, gake</p> -->
                        <div class="pacKgz_list mt-2 mt-sm-3 pt-2 pt-md-3 pt-md-4">
                        {!! $servicepackage->about_package ?? '' !!}
                        </div>
                      </div>
                      <div class="cart_adnZ_dTlz01">
                        
                      </div>
                      <div class="cart_adnZ_dTlz03 mt-auto mb-0 me-0">
                        <div class="accordionCart_Head_EbLk">
                          <h4>Date</h4>
                        </div>
                        <p><i class="icon-date"></i>{{ $cart->options->booked_date }}, {{ $cart->options->booked_stime }}</p>
                        <a type="submit" class="Rft_Ech_bTz_B" id="{{$cart->rowId ?? ''}}" onclick="cartRemove(this.id)"><i class="icon-minus"></i><span>Remove</span></a>
                      </div>

                    </div>
                    <div class="warning">{{ $warning_msg ?? ''}}</div>


                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif


          @if($cart->options->pkg_type == 'studiorental')
          @php
          $studiorental = App\Models\StudioRentals::find($cart->id);
          @endphp
          <div class="accordion-item" id="{{$cart->rowId ?? ''}}">
            <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
              data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">

              <div class="accordionCart_Header">

                <div class="accordionCart_Head_EbLk accordionCart_Head_01">
                  <h4>#0{{ $loop->iteration }}</h4>
                </div>

                <div class="accordionCart_Head_EbLk accordionCart_Head_02">
                  <h4>Studio Rental </h4>
                  <!-- <p><strong>Added on</strong> 03 -03 2023</p> -->
                </div>

                <div class="accordionCart_Head_EbLk accordionCart_Head_03">
                  <h4>{{ $studiorental->title ?? '' }}</h4>
                </div>

                <div class="accordionCart_Head_EbLk accordionCart_Head_04">
                  <h4>1</h4>
                </div>

                <div class="accordionCart_Head_EbLk accordionCart_Head_05">
                  <h4>{{ $studiorental->price ?? '' }} AED</h4>
                </div>

              </div>
            </button>
          </h2>
          <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $loop->iteration }}"
            data-bs-parent="#accordionCart">
            <div class="accordion-body">
              <div class="cart_adnZ_Wrp">
                <div class="cart_adnZ">


                  <div class="cart_adnZ_dTlz">
                    <div class="cart_adnZ_dTlz01">
                      <div class="accordionCart_Head_EbLk">
                        <h4>Date</h4>
                      </div>
                      <p><i class="icon-date"></i>{{ $cart->options->booked_date }}, {{ $cart->options->booked_stime }}</p>
                    </div>
                    <div class="cart_adnZ_dTlz02">
                      <div class="accordionCart_Head_EbLk">
                        <!-- <h4>Location</h4> -->
                      </div>
                      <!-- <p><i class="icon-location"></i>Lorem ipsum, sgagew, kgsgjas, gake</p> -->
                    </div>
                    <div class="cart_adnZ_dTlz03 mt-auto mb-0 me-0">
                      <a type="submit" class="Rft_Ech_bTz_B" id="{{$cart->rowId ?? ''}}" onclick="cartRemove(this.id)"><i class="icon-minus"></i><span>Remove</span></a>
                    </div>

                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
        @endif



        @if($cart->options->pkg_type == 'workshop')
        @php
        $workshop = App\Models\Workshops::find($cart->id);
        @endphp
        <div class="accordion-item" id="{{$cart->rowId ?? ''}}">
          <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">

            <div class="accordionCart_Header">

              <div class="accordionCart_Head_EbLk accordionCart_Head_01">
                <h4>#0{{ $loop->iteration }}</h4>
              </div>

              <div class="accordionCart_Head_EbLk accordionCart_Head_02">
                <h4>Workshop </h4>
                <!-- <p><strong>Added on</strong> 03 -03 2023</p> -->
              </div>

              <div class="accordionCart_Head_EbLk accordionCart_Head_03">
                <h4>{{ $workshop->title ?? '' }}</h4>
              </div>

              <div class="accordionCart_Head_EbLk accordionCart_Head_04">
                <h4>1</h4>
              </div>

              <div class="accordionCart_Head_EbLk accordionCart_Head_05">
                @if($workshop->discount_price > 0)
                <h4>{{ $workshop->discount_price ?? '' }} AED</h4>
                @else
                <h4>{{ $workshop->selling_price ?? '' }} AED</h4>
                @endif
              </div>

            </div>
          </button>
        </h2>
        <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $loop->iteration }}"
          data-bs-parent="#accordionCart">
          <div class="accordion-body">
            <div class="cart_adnZ_Wrp">
              <div class="cart_adnZ">


                <div class="cart_adnZ_dTlz">
                  <div class="cart_adnZ_dTlz01">
                    <div class="accordionCart_Head_EbLk">
                      <h4>Date</h4>
                    </div>
                    <p><i class="icon-date"></i>{{ $cart->options->booked_date }}, {{ $cart->options->booked_stime }}</p>
                  </div>
                  <div class="cart_adnZ_dTlz02">
                    <div class="accordionCart_Head_EbLk">
                      <!-- <h4>Location</h4> -->
                    </div>
                    <!-- <p><i class="icon-location"></i>Lorem ipsum, sgagew, kgsgjas, gake</p> -->
                  </div>
                  <div class="cart_adnZ_dTlz03 mt-auto mb-0 me-0">
                    <a type="submit" class="Rft_Ech_bTz_B" id="{{$cart->rowId ?? ''}}" onclick="cartRemove(this.id)"><i class="icon-minus"></i><span>Remove</span></a>
                  </div>

                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
      @endif


      @endforeach


    </div>


    <div class="col-sm-12 mb-3 mt-3 mt-md-4 mt-xl-5 carTheDzWrap px-3 px-md-4 py-3 py-md-4"> 
        @if(Session::has('coupon'))
        <div class="table" id="couponField">
          <div id="couponCalField">

          </div>
        </div>
        @else


        <div class="table" id="couponField">
          <div class="carTheDz">
                <span class="estimate-title">Discount Code</span>
                <p>Enter your coupon code if you have one..</p>
          </div>
          <div class="d-flex">
            

            
                <div class="form-group my-auto">
                  <input type="text" class="form-control unicase-form-control text-input" placeholder="You Coupon.." id="coupon_name">
                </div>
                <div class="clearfix pull-right my-auto ms-3">
                  <button type="submit" class="btn-upper btn btn-primary aplY_btNCup" onclick="applyCoupon()">APPLY COUPON</button>
                </div>
                <span class="coupon_err_msg"></span>

                
          </div>
        </div>
        @endif


    </div>

  </div>
  @php

  if (is_numeric($cartTotal)) {
    $amount = round($cartTotal,2);
  } else {
    $amount = str_replace(",", "", $cartTotal);
    $amount = round($amount, 2);
  }

  $vatPercentage = 5;

  $vatAmount = $amount * ($vatPercentage / 100);

  $totalAmount = round(($amount + $vatAmount),2);

  //$totalAmount = round(($amount),2);

  @endphp
  <div class="insid_car_Ryt">
    <div class="insid_car_Ryt_payment">
      <h4>Total</h4>
      <h3><span id="totAmt">{{ $totalAmount ?? 0 }}</span> AED</h3>
      <h4>Inc vat 5%</h4>

      <div>&nbsp;</div>
      <form action="{{ route('stripe.order') }}" method="post" id="payment-form" class="crt_Zfotm">
      @csrf
      <input type="hidden" name="name" value="{{ Auth::user()->name }}">
      <input type="hidden" name="email" value="{{ Auth::user()->email }}">
      <input type="hidden" name="phone" value="{{ Auth::user()->phone ?? '' }}">
      <input type="hidden" name="post_code" value="11111">
      <input type="hidden" name="division_id" value="1">
      <input type="hidden" name="district_id" value="1">
      <input type="hidden" name="state_id" value="1">
      <input type="hidden" name="address" value="{{ Auth::user()->address ?? '' }}">
      <input type="hidden" name="notes" value="{{ $cart->options->pkg_type ?? '' }}">
      <div class="d-flex mt-5 pt-5 mb-0">
      <button class="btn btn-primary mk_paymnt" type="submit" id="checkout-live-button"><i class="icon-ion_card"></i><span>Checkout</span></button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
</section>
@endsection
@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
$.ajaxSetup({
  headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  }
})

// Create a Stripe client.
//var stripe = Stripe('pk_test_IT7QMo2O84CNZRKVtbLyki9n00u4YT6txD');  //Test
//var stripe = Stripe('pk_live_THXB8sZiASYweDuTptrlH51g00W1e2Zq71'); //LIVE
var stripe = Stripe('{{config('stripe.pk')}}');
// Create an instance of Elements.
var elements = stripe.elements();
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
// Create an instance of the card Element.
var card = elements.create('card', { style: style });
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  stripe.createToken(card).then(function(result) {
    if (result.error) {
// Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
// Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});


// Create an instance of the Apple Pay button
var applePayButton = elements.create('applePay', {
    style: {
        type: 'plain',
        color: 'black',
        height: '40px',
        width: '100%',
    },
});

// Check if Apple Pay is available
        applePayButton.on('ready', function() {
            applePayButton.mount('#apple-pay-button');
        });



// Submit the form with the token ID.
function stripeTokenHandler(token) {

  var paymentBtn = document.getElementById('paymentBtn');
  paymentBtn.disabled = true; // Disable the button to prevent further clicks
  paymentBtn.innerHTML = 'Processing...';

  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  setTimeout(function() {
    form.submit();
  }, 200);
  
}
</script>
<script>

// Cart Remove Start 
  function cartRemove(id){
    $.ajax({
      type: "GET",
      dataType: 'json',
      url: "/cart-remove/"+id,
      success:function(data){
        $('#'+id).hide();
//cart();
        miniCart();
        $('#totAmt').text(data.cartTotal);
// Start Message 
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',

          showConfirmButton: false,
          timer: 3000 
        })
        if ($.isEmptyObject(data.error)) {

          Toast.fire({
            type: 'success',
            icon: 'success', 
            title: data.success, 
          })
        }else{

          Toast.fire({
            type: 'error',
            icon: 'error', 
            title: data.error, 
          })
        }
// End Message  
        window.location.reload();
      }
    })
  }

  $(".addon_qty_update").on('change', function() {
    var addon_qty = $(this).val();
    var cart_id = $(this).data('cart-id');
    var addon_price = $(this).data('addon-price');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {addon_qty:addon_qty, cart_id: cart_id, addon_price: addon_price},
      url: "{{ url('/addon-qty-update') }}",
      success:function(data){
        if (data.validity == true) {
          $('#couponField').hide();
        }

        // Start Message 
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',

          showConfirmButton: false,
          timer: 3000
        })
        if ($.isEmptyObject(data.error)) {
          Toast.fire({
            type: 'success',
            icon: 'success',
            title: data.success
          })

        }else{
          Toast.fire({
            type: 'error',
            icon: 'error',
            title: data.error
          })

        }

        // End Message 
        window.location.reload();
      }

    })
  });

  function applyCoupon(){
    var coupon_name = $('#coupon_name').val();
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {coupon_name:coupon_name},
      url: "{{ url('/coupon-apply') }}",
      success:function(data){
        couponCalculation();
        if (data.validity == true) {
          $('#couponField').hide();
          window.location.reload();
        }

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',

          showConfirmButton: false,
          timer: 3000
        })
        if ($.isEmptyObject(data.error)) {
          Toast.fire({
            type: 'success',
            icon: 'success',
            title: data.success
          })

        }else{
          Toast.fire({
            type: 'error',
            icon: 'error',
            title: data.error
          })

        }
      }

    })
  } 

  function couponCalculation(){
    $.ajax({
      type:'GET',
      url: "{{ url('/coupon-calculation') }}",
      dataType: 'json',
      success:function(data){
        if (data.total) {
          $('#couponCalField').html(
            `<div>
            <div>
            <div class="cart-sub-total">
            Subtotal<span class="inner-left-md"> AED ${data.total}</span>
            </div>
            <div class="cart-grand-total">
            Grand Total<span class="inner-left-md"> AED ${data.total}</span>
            </div>
            </div>
            </div>`
            )

        }else{

          $('#couponCalField').html(
            `<div>
            <div>
            <div class="cart-sub-total">
            Subtotal : <span class="inner-left-md"> AED ${data.subtotal}</span>
            </div>
            <div class="cart-sub-total">
            Coupon : <span class="inner-left-md"> ${data.coupon_name} - (${data.coupon_code})</span>
            <button type="submit" onclick="couponRemove()"><i class="fa fa-times"></i>  </button>
            </div>

            <div class="cart-sub-total">
            Discount Amount : <span class="inner-left-md"> AED ${data.discount_amount}</span>
            </div>


            <div class="cart-grand-total">
            Grand Total : <span class="inner-left-md"> AED ${data.total_amount}</span>
            </div>
            </div>
            </div>`
            )

        }
      }

    });
  }

  function couponRemove(){
    $.ajax({
      type:'GET',
      url: "{{ url('/coupon-remove') }}",
      dataType: 'json',
      success:function(data){
        couponCalculation();
        $('#couponField').show();
        $('#coupon_name').val('');


// Start Message 
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',

          showConfirmButton: false,
          timer: 3000
        })
        if ($.isEmptyObject(data.error)) {
          Toast.fire({
            type: 'success',
            icon: 'success',
            title: data.success
          })

        }else{
          Toast.fire({
            type: 'error',
            icon: 'error',
            title: data.error
          })

        }
        window.location.reload();
// End Message 

      }
    });

  }
  couponCalculation();


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