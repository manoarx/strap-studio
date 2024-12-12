@extends('layouts.frontend')

@section('content')
@php
$banners = App\Models\Banners::where('page','home')->orderBy('id','DESC')->get();
$clients = App\Models\Clients::orderBy('id','ASC')->get();
$aboutbanner = App\Models\Banners::where('page','homeaboutus')->first();
@endphp
<section class="strp_home_blk_a">
	
	<div class="owl-carousel owl-theme the_HmZ">
		@foreach($banners as $banner)
		<div class="each_hm_slide">
			<figure>
				<span>{{ $banner->title ?? '' }}</span>
				<img src="{{ asset($banner->image ) }}">
  
       
				@if($banner->offerimage)
        <img src="/upload/banners/{{ $banner->offerimage ?? '' }}" class="theOfr" style="width:{{ $banner->offer_width ?? 'auto !important' }};left: {{ $banner->left_pos ?? '10' }}%; top: {{ $banner->top_pos ?? '10' }}%;transform: translate(-{{ $banner->left_pos ?? '10' }}%, -{{ $banner->top_pos ?? '10' }}%);"> 
        @endif
			</figure>
		</div>
		@endforeach


	</div>

	<div class="container cMN_wTh my-auto  each_home_link_holder">

		<div class="row">

			<div class="d-flex col-sm-6 col-md-6 col-lg-3 col-6">
				<a href="{{ route('portfolio') }}" class="each_home_link">
					<img src="/frontend/assets/images/home_link_001.png">
					<p class="each_home_link_text">Photography</p>
				</a>
			</div>

			<div class="d-flex col-sm-6 col-md-6 col-lg-3 col-6">
				<a href="{{ route('videos') }}" class="each_home_link">
					<img src="/frontend/assets/images/home_link_002.png">
					<p class="each_home_link_text">Videography</p>
				</a>
			</div>


			<div class="d-flex col-sm-6 col-md-6 col-lg-3 col-6">
				<a href="{{ route('workshops') }}" class="each_home_link">
					<img src="/frontend/assets/images/home_link_003.png">
					<p class="each_home_link_text">Workshop</p>
				</a>
			</div>

			<div class="d-flex col-sm-6 col-md-6 col-lg-3 col-6">
				<a href="{{ route('studiorentals') }}" class="each_home_link">
					<img src="/frontend/assets/images/home_link_004.png">
					<p class="each_home_link_text">Studio Rental</p>
				</a>
			</div>

		</div>

	</div>

</section>

<section class="home_About_Holder py-3 py-md-4 py-lg-5">
	<div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5">
		<div class="row mx-0">
			<div class="col-xxl-6 col-lg-7 d-flex px-0">
				<div class="home_About_Holder_L" data-sal="fade" style="--sal-duration: 2s; --sal-delay: 0s">
					<figure>
						<img src="{{ isset($aboutbanner->image) ? asset($aboutbanner->image) : '/frontend/assets/images/about_banner.png'}}">
					</figure>
				</div>
			</div>
			<div class="col-xxl-6 col-lg-5 d-flex px-0">
				<div class="home_About_Holder_R px-2 px-md-3 px-xl-4 px-xxl-5 py-3 py-xl-4 py-xxl-5">
					<div class="d-flex flex-column px-2 px-md-3 px-xl-4 px-xxl-5 ">
						<h3 class="home_About_Holder_small_head">About Us</h3>
						<h4 class="home_About_Holder_head">Strap Studios <small>Abu Dhabi</small></h4>
						<p class="home_About_Holder_detail">{{$aboutbanner->short_title ?? 'Welcome to Strap Studios'}}</p>
						<div class="d-flex mt-3 mt-md-4 mt-lg-5">
							<a href="{{ route('about') }}" class="button_a">Know More</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="home_service_Holder py-3 py-md-4 py-lg-5">
	<div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5">
		<div class="row">
			<div class="col-md-6 order-md-1 d-flex pb-3 pb-md-4 pb-lg-5">
				<div class="home_service_head my-auto">
					<h4 class="home_service_header">Services</h4>
				</div>
			</div>

			<div class="col-md-12 px-0  order-md-3">
				<div class="row srvC_WrpzRow">

				@foreach($services as $service)
				<div class="col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
					style="--sal-duration: 2s; --sal-delay: 0s">
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


				</div>
			</div>


			<div class="d-flex col-md-6  order-md-2 pb-0 pb-md-4 pb-lg-5">
				<div class="d-flex mx-auto me-md-0">
					<a href="{{ route('services') }}" class="button_c">Explore All</a>
				</div>
			</div>

		</div>
	</div>
</section>


<section class="home_workshop_Holder py-3 py-md-4 py-lg-5">
	<div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5">
		<div class="row home_workshop_Holder_row">
			<div class="col-md-6 order-md-1 d-flex pb-3 pb-md-4 pb-lg-5">
				<div class="home_service_head my-auto">
					<h4 class="home_service_header">Workshops</h4>
				</div>
			</div>

			<div class="col-md-12 px-md-0  order-md-3">
				<div class="owl-carousel owl-theme the_Wrkshop">

					@foreach($workshops as $workshop)
		            @php
		            $discount_perc=0;
		            if($workshop->discount_price > 0) {
		            $discount_perc=round(($workshop->selling_price - $workshop->discount_price)/$workshop->selling_price*100);
		            }
		            @endphp
					<div class="theWrkshP_item">
						<figure>
							<img src="{{ (!empty($workshop->getFirstMediaUrl('photos'))) ? $workshop->getFirstMediaUrl('photos') : url('upload/no_image.jpg') }}">
						</figure>
						@if($discount_perc) > 0
		                <h4 class="theOffer">{{$discount_perc ?? 0}}% off</h4>
		                @endif
						<div class="theWrkshP_item_detailz">
							<h4 class="theWrkshP_item_detailz_head">{{ $workshop->title ?? "" }}</h4>
							<div class="theWrkshP_item_detailz_price mx-auto">
								@if($discount_perc > 0)
			                    <h4 class="rdcdPrice">AED {{$workshop->selling_price ?? ''}}</h4>
			                    <h4 class="nRmlPrice">AED {{$workshop->discount_price ?? ''}}</h4>
			                    @else
			                    <h4 class="nRmlPrice">AED {{$workshop->selling_price ?? ''}}</h4>
			                    @endif
							</div>
							<div class="d-flex mx-auto mb-0 mt-0">
								<a href="{{url('workshop/'.$workshop->slug)}}" class="button_d">Book Now</a>
							</div>
						</div>
					</div>
					@endforeach






				</div>
			</div>

			<div class="d-flex col-md-6  order-md-2 pb-0 pb-md-4 pb-lg-5 mt-md-0 mt-3 home_workshop_Holder_explore">
				<div class="d-flex mx-auto me-md-0">
					<a href="{{ route('workshops') }}" class="button_c">Explore All</a>
				</div>
			</div>

		</div>
	</div>
</section>


<section class="home_portfolio_Holder py-3 py-md-4 py-lg-5">
	<div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5">
		<div class="row">
			<div class="col-md-6 order-md-1 d-flex pb-3 pb-md-4 pb-lg-5">
				<div class="home_service_head my-auto">
					<h4 class="home_service_header">Portfolio</h4>
				</div>
			</div>

			<div class="col-md-12 px-0  order-md-3">
				<div class=" grid" id="grid_hldR">

            @foreach($portfolios as $portfolio)
            <div class="grid-item ">
              <div class="gridPrtfoliO">
                <figure>
                  <img src="{{$portfolio->getFirstMediaUrl('photos') ?? ''}}">
                </figure>
                <div class="eachprtFolio_sWrp">
                  <h4 class="eachprtFolio_s_Txt">{{ $portfolio->name ?? '' }}</h4>
                </div>
                <a href="{{url('portfolio/'.$portfolio->slug)}}" class="prtFlioPageItemLink"></a>
              </div>
            </div>
            @endforeach

          </div>
			</div>

			<div class="d-flex col-md-6  order-md-2 pb-0 pb-md-4 pb-lg-5">
				<div class="d-flex mx-auto me-md-0">
					<a href="{{ route('portfolio') }}" class="button_c">Explore All</a>
				</div>
			</div>

		</div>
	</div>
</section>


@include('partials.frontend.testimonials')

<section class="home_client_Holder py-3 py-md-4 py-lg-5">
	<div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5">
		<div class="row">
			<div class="col-md-12  d-flex pb-3 pb-md-4 pb-lg-5">
				<div class="home_service_head my-auto">
					<h4 class="home_service_header">Clients</h4>
				</div>
			</div>

			<div class="col-md-12 px-0  the_ClientsWrpinG">
				<!--       <div class="owl-carousel owl-theme the_Clients"> -->
					<ul id="the_Clients">

						@foreach($clients->chunk(2) as $chunkclient)
						<li class="ech_clint">
							@foreach($chunkclient as $client)
							<figure>
								<img src="{{ asset($client->image ) }}">
							</figure>
							@endforeach
						</li>
						@endforeach
						


					</div>



				</div>
			</div>
		</section>

@endsection      


@section('scripts')
<script src="/frontend/assets/js/pinterest_grid.js"></script>
<script>
	
  
    $(document).ready(function () {
      // sal();
      sal({
        threshold: 0.05,
      });

      var grid = new PinterestGrid({
        container: '.grid',
        item: '.grid-item',
        gutt: 10,
        delay: 200
      }); window.addEventListener('resize', function () {
        grid.init();
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