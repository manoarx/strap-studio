@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','workshops')->first();
$workshops = App\Models\Workshops::get();
@endphp
<section class=" py-2 py-sm-3">
  <!-- <figure><img src="{{ isset($banner->image) ? asset($banner->image) : '/frontend/assets/images/portfolio_background.png'}}"></figure> -->
        <div class="container cMN_wTh py-2 py-sm-3">
          <div class="bread_crumz">
            <button class="my-auto home_btn_crum">
              <i class="icon-menu"></i>
            </button>
            <ul>
              <li>Workshops</li>
              <!-- <li>Business Portraits</li> -->
            </ul>
          </div>
        </div>
      </section>

      <section class="pt-3 pt-md-4 pt-lg-5 ">
        <div class="container cMN_wTh pb-3 ">


          <div class="wrkShop_wrp mx-auto">
            <div class="row">
              <div class="col-md-12 pb-3 pb-md-4 pb-lg-5">
                <h4 class="home_service_header text-center">{{ $settings['workshop_header_title'] ?? '' }}</h4>
              </div>
              <div class="col-md-12 wrkShop_wrp_p pb-2 mb-2 pb-sm-3 mb-sm-3">
                <p>{{ $settings['workshop_header_description'] ?? '' }}</p>
              </div>

              <div class="col-6 d-flex">
                <div class="d-flex mx-auto me-md-3 me-2">
                  <!-- <a href="{{url('workshop/single')}}" class="button_c">Book Now</a> -->
                </div>
              </div>

              <div class="col-6 d-flex">
                <div class="d-flex mx-auto ms-md-3 ms-2">
                  <button class="more_btn collapsed">
                    <span class="toHide">Readmore</span>
                    <i class="icon-arrow_down"></i>
                  </button>
                </div>
              </div>


            </div>
          </div>



        </div>
      </section>


      <section class="py-3 py-md-4 py-lg-5 ">
        <div class="container cMN_wTh pb-3 pb-md-4 pb-lg-5 ">
          <div class="row wrkShpItmz">

            @foreach($workshops as $workshop)
            @php
            $discount_perc=0;
            if($workshop->discount_price > 0) {
            $discount_perc=round(($workshop->selling_price - $workshop->discount_price)/$workshop->selling_price*100);
            }
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: 0s">
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

            </div>
            @endforeach

            <!-- <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: .5s">

              <div class="theWrkshP_item">
                <figure>
                  <img src="/frontend/assets/images/work_shop_002.png">
                </figure>
                <div class="theWrkshP_item_detailz">
                  <h4 class="theWrkshP_item_detailz_head">Indoor Portrait
                    Workshop</h4>
                  <div class="theWrkshP_item_detailz_price mx-auto">
                    <h4 class="nRmlPrice">AED 128</h4>
                  </div>
                  <div class="d-flex mx-auto mb-0 mt-0">
                    <a href="{{url('workshop/single')}}" class="button_d">Book Now</a>
                  </div>
                </div>
              </div>

            </div>


            <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: 1s">

              <div class="theWrkshP_item">
                <figure>
                  <img src="/frontend/assets/images/work_shop_003.png">
                </figure>
                <div class="theWrkshP_item_detailz">
                  <h4 class="theWrkshP_item_detailz_head">Outdoor Portraits
                    Workshop</h4>

                  <div class="theWrkshP_item_detailz_price mx-auto">
                    <h4 class="nRmlPrice">AED 128</h4>
                  </div>

                  <div class="d-flex mx-auto mb-0 mt-0">
                    <a href="{{url('workshop/single')}}" class="button_d">Book Now</a>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: 1.5s">

              <div class="theWrkshP_item">
                <figure>
                  <img src="/frontend/assets/images/work_shop_004.png">
                </figure>
                <div class="theWrkshP_item_detailz">
                  <h4 class="theWrkshP_item_detailz_head">Intro to Photoshop Retouching</h4>

                  <div class="theWrkshP_item_detailz_price mx-auto">
                    <h4 class="nRmlPrice">AED 128</h4>
                  </div>

                  <div class="d-flex mx-auto mb-0 mt-0">
                    <a href="{{url('workshop/single')}}" class="button_d">Book Now</a>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: 0s">
              <div class="theWrkshP_item">
                <figure>
                  <img src="/frontend/assets/images/work_shop_001.png">
                </figure>
                <h4 class="theOffer">50% off</h4>
                <div class="theWrkshP_item_detailz">
                  <h4 class="theWrkshP_item_detailz_head">Photography 101 <br>(PASM)</h4>
                  <div class="theWrkshP_item_detailz_price mx-auto">
                    <h4 class="rdcdPrice">AED 256</h4>
                    <h4 class="nRmlPrice">AED 128</h4>
                  </div>
                  <div class="d-flex mx-auto mb-0 mt-0">
                    <a href="{{url('workshop/single')}}" class="button_d">Book Now</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: 0.5s">

              <div class="theWrkshP_item">
                <figure>
                  <img src="/frontend/assets/images/work_shop_002.png">
                </figure>
                <div class="theWrkshP_item_detailz">
                  <h4 class="theWrkshP_item_detailz_head">Indoor Portrait
                    Workshop</h4>
                  <div class="theWrkshP_item_detailz_price mx-auto">
                    <h4 class="nRmlPrice">AED 128</h4>
                  </div>
                  <div class="d-flex mx-auto mb-0 mt-0">
                    <a href="{{url('workshop/single')}}" class="button_d">Book Now</a>
                  </div>
                </div>
              </div>

            </div>


            <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: 1s">

              <div class="theWrkshP_item">
                <figure>
                  <img src="/frontend/assets/images/work_shop_003.png">
                </figure>
                <div class="theWrkshP_item_detailz">
                  <h4 class="theWrkshP_item_detailz_head">Outdoor Portraits
                    Workshop</h4>

                  <div class="theWrkshP_item_detailz_price mx-auto">
                    <h4 class="nRmlPrice">AED 128</h4>
                  </div>

                  <div class="d-flex mx-auto mb-0 mt-0">
                    <a href="{{url('workshop/single')}}" class="button_d">Book Now</a>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 d-flex col-sm-6 col-6" data-sal="slide-up"
              style="--sal-duration: 2s; --sal-delay: 1.5s">

              <div class="theWrkshP_item">
                <figure>
                  <img src="/frontend/assets/images/work_shop_004.png">
                </figure>
                <div class="theWrkshP_item_detailz">
                  <h4 class="theWrkshP_item_detailz_head">Intro to Photoshop Retouching</h4>

                  <div class="theWrkshP_item_detailz_price mx-auto">
                    <h4 class="nRmlPrice">AED 128</h4>
                  </div>

                  <div class="d-flex mx-auto mb-0 mt-0">
                    <a href="{{url('workshop/single')}}" class="button_d">Book Now</a>
                  </div>
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

      $(".packag_drop").select2({
        templateSelection: iformat,
        templateResult: iformat,
        placeholder: "Choose",
        dropdownCssClass: "dropperDown",
      });



      function iformat(icon) {
        var originalOption = icon.element;
        var originalOptionPlace = $(originalOption).data('place');
        var originalOptionPrice = $(originalOption).data('price');

        // return $('<h5 class=""><span>' + originalOptionPlace + '</span>' + icon.text + '<span class="badge1">' + originalOptionPrice + '</span></h5>');
        return $('<h5 class="d-flex"><span class="ms-0 me-auto txTSml">' + originalOptionPlace + '</span><span class="ms-auto me-0 txTHg">' + originalOptionPrice + '</span></h5>');
      }


      $(".packag_addonz").select2({
        templateSelection: iformat,
        templateResult: iformat,
        dropdownCssClass: "dropperDownAdnz",
      });

      $('.packag_addonz').on('select2:select', function (e) {
        var selectedItem = e.params.data;
        var selectedItemValue = e.params.data.id;
        // var selectedItemTemplate = e.params.data.element.dataset.template;
        var selectedItemTemplatePlace = e.params.data.element.dataset.place;
        var selectedItemTemplatePrice = e.params.data.element.dataset.price;
        console.log("select2:select", e);
        // console.log('Selected Item:', selectedItem);
        //  console.log('Selected Item Template:', selectedItemTemplate);
        // console.log(selectedItemTemplate);
        //$(this).parent().find(".adnSelecTd").attr("pp", "pp");
        $(this).parent().find(".adnSelecTd").append('<div class="d-flex echSlctd_adN"><span class="ms-0 me-auto txTAdn">' +
          selectedItemTemplatePlace + '</span><span class="ms-auto me-0 txTAdnPr">' + selectedItemTemplatePrice + '</span><button class="delete_it" data-value=' + selectedItemValue + '><i class="icon-minus"></i></button></div>');
      });

      $(document).on("click", ".delete_it", function (event) {
        var valu_ofThe = $(this).attr("data-value");
        var the_current_stay = $(this).parent();
        console.log("select2:select", valu_ofThe);
        $(this).parent().parent().parent().find(".select2  .selection ul li").each(function () {
          console.log($(this).attr('title').trim());
          if ($(this).attr('title').trim() == valu_ofThe) {
            // $(this).find("button").attr("to", "max")
            $(this).find("button").click();
            the_current_stay.remove();
          }
        });
        // $(this).parent().parent().parent().find(".select2  .selection ul li[title='a2              ']").attr("to", "max");
        // $(this).parent().remove();
      });



      /*       $(".packag_addonz").on("select2:select", function (e) { console.log("select2:select", e); });
            $(".packag_addonz").on("select2:unselect", function (e) { console.log("select2:unselect", e); });
      
       */

      //.pacKgz_list
    });


  </script>

@endsection    