@extends('layouts.frontend')
@section('content')
<section class="py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh my-auto pb-3 pb-md-4 pb-lg-5">
          <div class="d-flex flex-wrap position-relative das_intr" >
          <div class="dash_user_wrpRMenu">
              <button class="dash_user_wrpRMenu_icon"><i class="icon-menu"></i></button>
            </div>
            <div class="dash_user_baKgrey"></div>


            <div class="inside_page_Head">
              <h4>Wishlist</h4>
            </div>
            @include('frontend.customer.sidebar')
            <div class="inside_page_Rft">

              @foreach($wishlists as $wishlist)
              <div class="inside_page_Rft_Ech" id="wishlist-{{$wishlist->id ?? ''}}">
                <figure>
                  <img src="{{$wishlist->workshop->getFirstMediaUrl('photos','thumb') ?? ''}}">
                </figure>
                <div class="inside_page_Rft_Ech_head">
                  <h4>{{$wishlist->workshop->title ?? ''}}</h4>
                </div>
                <div class="inside_page_Rft_Ech_price">
                  @php
                  if($wishlist->workshop->discount_price >0) {
                    $price = $wishlist->workshop->discount_price;
                  @endphp
                  <h4 class="inside_page_Rft_Ech_price_offer">AED {{$wishlist->workshop->selling_price ?? ''}}</h4>
                  <h4 class="inside_page_Rft_Ech_price_actual">AED {{$wishlist->workshop->discount_price ?? ''}}</h4>
                  @php
                  } else {
                    $price = $wishlist->workshop->selling_price;
                  @endphp
                  <h4 class="inside_page_Rft_Ech_price_actual">AED {{$wishlist->workshop->selling_price ?? ''}}</h4>
                  @php
                  }
                  @endphp
                </div>

                <div class="inside_page_Rft_Ech_bTz">
                  <a href="#" class="Rft_Ech_bTz_A wsp-add-to-cart" data-id="{{$wishlist->workshop->id ?? ''}}" data-totprice="{{ $price ?? '' }}" data-type="workshop"><i class="icon-bag"></i><span>Add to cart</span></a>
                  <a type="submit" id="{{$wishlist->id ?? ''}}" onclick="wishlistRemove(this.id)" class="Rft_Ech_bTz_B"><i class="icon-minus"></i><span>Remove</span></a>
                </div>

              </div>
              @endforeach


              <!-- <div class="inside_page_Rft_Ech">
                <figure>
                  <img src="assets/images/wishlist.png">
                </figure>
                <div class="inside_page_Rft_Ech_head">
                  <h4>Intro to Smartphone Photography</h4>
                </div>
                <div class="inside_page_Rft_Ech_price">
                  <h4 class="inside_page_Rft_Ech_price_offer">AED 256</h4>
                  <h4 class="inside_page_Rft_Ech_price_actual">AED 128</h4>
                </div>

                <div class="inside_page_Rft_Ech_bTz">
                  <a href="#" class="Rft_Ech_bTz_A"><i class="icon-bag"></i><span>Add to cart</span></a>
                  <a href="#" class="Rft_Ech_bTz_B"><i class="icon-minus"></i><span>Remove</span></a>
                </div>

              </div>





              <div class="inside_page_Rft_Ech">
                <figure>
                  <img src="assets/images/wishlist.png">
                </figure>
                <div class="inside_page_Rft_Ech_head">
                  <h4>Intro to Smartphone Photography</h4>
                </div>
                <div class="inside_page_Rft_Ech_price">
                  <h4 class="inside_page_Rft_Ech_price_offer">AED 256</h4>
                  <h4 class="inside_page_Rft_Ech_price_actual">AED 128</h4>
                </div>

                <div class="inside_page_Rft_Ech_bTz">
                  <a href="#" class="Rft_Ech_bTz_A"><i class="icon-bag"></i><span>Add to cart</span></a>
                  <a href="#" class="Rft_Ech_bTz_B"><i class="icon-minus"></i><span>Remove</span></a>
                </div>

              </div> -->





            </div>

          </div>
        </div>
      </section>
@endsection
@section('scripts')
<script>
  $.ajaxSetup({
      headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
  })

  /// Start Add To Cart Prodcut 
  $(document).on('click', '.wsp-add-to-cart', function(e) {
    e.preventDefault();
    var pkgId = $(this).data('id');
    var pkgType = $(this).data('type');
    var totprice = $(this).data('totprice');
    var addonid = 0;
    var optionid = 0;
      
    $.ajax({
        type: "POST",
        dataType : 'json',
        data:{
            pkg_type:pkgType, option_id:optionid, addon_id:addonid, totprice:totprice
        },
        url: "/cart/servicepackage/store/"+pkgId,
        success:function(data){
            $('#cartQty').text(data.cartQty);
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  icon: 'success', 
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    title: data.success, 
                    })
            }else{
               
              Toast.fire({
                    type: 'error',
                    title: data.error, 
                    })
            }
        }
     });
  });
  /// End Add To Cart Prodcut 


  function wishlistRemove(id){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "/wishlist-remove/"+id,
        success:function(data){
          $('#wishlist-'+id).hide();
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
        }
    })
  }

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