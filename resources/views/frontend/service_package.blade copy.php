@extends('layouts.frontend')

@section('content')

<section class="py-3 ">
        <div class="container cMN_wTh py-3">
          <div class="bread_crumz">
            <button class="my-auto home_btn_crum">
              <i class="icon-menu"></i>
            </button>
            <ul>
              <li><a href="{{ route('services') }}">Services</a></li>
              <li>{{ $service->title ?? '' }}</li>
            </ul>
          </div>
        </div>
      </section>

      <section class="pb-3 pb-md-4 pb-lg-5 ">
        <div class="container cMN_wTh pb-3 pb-md-4 pb-lg-5 ">
          <div class="row mb-3 mb-md-4 mb-lg-4">
            <div class="col-lg-6 d-flex">
              <div class="service_pack_L">
                <figure>
                  <img src="{{ isset($service->main_image) ? asset($service->main_image) : '/upload/no_image.jpg'}}">
                </figure>
              </div>
            </div>
            <div class="col-lg-6 d-flex">
              <div class="service_pack_R">

                <h4 class="home_service_header">{{ $service->title ?? '' }}</h4>

                <!-- <p>{{ $service->short_title ?? '' }}</p> -->

                <div class="d-flex flex-column">
                  <div  id="collapseService">
                    <div class="bdy_ofclPz">
                      <p>{!! $service->short_title ?? '' !!}</p>
                    </div>

                    <div class="d-flex w-100 flex-column mt-3 more_shadow">

                    <button class="more_btn  mx-auto" type="button">
                      <span class="toShow">Show less</span>
                      <span class="toHide">Readmore</span>
                      <i class="icon-arrow_down"></i>
                    </button>
                  </div>


                  </div>
                  


                </div>
              </div>
            </div>
          </div>


          <div class="row">
            @foreach($service->photos as $key => $media)
            <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="{{ $media->getUrl() }}">
                </figure>
              </div>
            </div>
            @endforeach
            <!-- <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="/frontend/assets/images/portait_02.png">
                </figure>
              </div>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="/frontend/assets/images/portait_03.png">
                </figure>
              </div>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6 d-flex col-6">
              <div class="echPrtRt">
                <figure>
                  <img src="/frontend/assets/images/portait_04.png">
                </figure>
              </div>
            </div> -->

            <div class="col-sm-12 d-flex pt-3 pt-md-4 pt-lg-5 mt-3 mt-md-4 mt-lg-5">
              <a href="{{ route('portfolio') }}" class="button_e mx-auto"><span>View Portfolio</span><i class="icon-image"></i></a>
            </div>
          </div>
        </div>
      </section>


      <section class="pacKgz_Wrp
       py-3 py-md-4 py-lg-5 ">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">
          <div class="row">

            <div class="col-md-12 pb-3 pb-md-4 pb-lg-5">
              <h4 class="home_service_header">Packages</h4>
            </div>

            @php
            $packages = App\Models\ServicePackages::where('service_id',$service->id)->orderBy('id','ASC')->get();
            @endphp
            @if(count($packages) > 0)
            @foreach($packages as $key => $package)
            <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
              <div class="pacKgz py-3 py-md-4 py-lg-5">
                @if($package->most_liked == 1)
                <div class="pacKgz_info">
                  <h5>Most liked</h5>
                </div>
                @endif
                <h4 class="home_service_header">{{ $package->package_name ?? '' }}</h4>


                <div class="pacKgz_list mt-2 mt-sm-3 pt-2 pt-md-3 pt-md-4">
                  {!! $package->about_package ?? '' !!}
                </div>

                @if(count($package->packageoptions)>0)
                <div class="pacKgz_pricing">
                  <select class="packag_drop">
                    <option data-place="Select Option" data-price="">A</option>
                    @foreach($package->packageoptions as $options)
                    <option data-pkgid="{{$package->id ?? ''}}" data-amount="{{$options->option_price ?? ''}}" data-place="{{$options->option_name ?? ''}}" data-price="{{$options->option_price ?? ''}} AED">A</option>
                    @endforeach
                    <!-- <option data-place="outdoor" data-price="200 AED">B</option>
                    <option data-place="indoor and outdoor" data-price="300 AED">C</option> -->
                  </select>
                </div>
                @endif
                @if(count($package->packageaddons)>0)
                <div class="pacKgz_addonzz">
                  <select class="packag_addonz updateaddon" multiple="multiple">
                    @foreach($package->packageaddons as $addons)
                    <option data-pkgid="{{$package->id ?? ''}}" data-amount="{{$addons->addon_price ?? ''}}" data-place="{{$addons->addon_name ?? ''}}" data-price="{{$addons->addon_price ?? ''}} AED" value="{{$addons->id ?? ''}}">{{$addons->id ?? ''}}</option>
                    @endforeach
                    <!-- <option data-place="Professional Makeup Optional (Extra) 1 look" data-price="200 AED" value="a2">a2
                    </option>
                    <option data-place="Professional Makeup Optional (Extra) 1 look" data-price="300 AED" value="a3">a3
                    </option> -->
                  </select>
                  <div class="pacKgz_addonzz_placeHldr">
                    <h5>Addons <small>(optional)</small></h5>
                  </div>
                  <div class="adnSelecTd">

                  </div>
                </div>
                @endif

                <div class="pacKgz_add_To">
                  <div class="pacKgz_add_ToTxt">
                    <h5 class="pacKgz_add_ToTxt_tax">Total(incl. vat)</h5>
                    <input type="hidden" id="option_price_{{$package->id ?? ''}}" value="">
                    <input type="hidden" id="addon_price_{{$package->id ?? ''}}" value="">
                    <input type="hidden" id="pkg_price_{{$package->id ?? ''}}" value="{{ $package->price ?? '' }}">
                    <input type="hidden" id="final_price_{{$package->id ?? ''}}" value="">
                    <h4 class="pacKgz_add_ToTxt_price"><span id="totPrice{{$package->id ?? ''}}">{{ $package->price ?? '' }}</span> AED</h4>
                  </div>
                  <a href="#" class="pacKgz_add_ToCart">Add to Cart</a>
                </div>


              </div>
            </div>
            @endforeach
            @endif
            


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

      $('.packag_drop').on('change', function() {
        // Get the selected option's price attribute
        var optionprice = $(this).find(':selected').data('amount');
        var pkgid = $(this).find(':selected').data('pkgid');

        // Update the price in the DOM
        var option_price = parseInt(optionprice);
        if(isNaN(option_price)) {
          option_price = 0;
        }
        console.log('option_price - '+option_price);

        var addon_price = parseInt($('#addon_price_'+pkgid).val());
        if(isNaN(addon_price)) {
          addon_price = 0;
        }
        console.log('addon_price - '+addon_price);

        var pkg_price = parseInt($('#pkg_price_'+pkgid).val());
        if(isNaN(pkg_price)) {
          pkg_price = 0;
        }
        console.log('pkg_price - '+pkg_price);

        var result = option_price + addon_price + pkg_price;
        console.log('updateaddon - '+result);

        $('#option_price_'+pkgid).val(option_price);
        $('#addon_price_'+pkgid).val(addon_price);
        $('#final_price_'+pkgid).val(result);

        $('#totPrice'+pkgid).text(result);
      });

      $('.updateaddon').on('change', function() {
        // Get the selected option's price attribute
        var price = $(this).find(':selected').data('amount');
        console.log('price - '+price);
        var pkgid = $(this).find(':selected').data('pkgid');

        // Update the price in the DOM

        var option_price = parseInt($('#option_price_'+pkgid).val());
        if(isNaN(option_price)) {
          option_price = 0;
        }
        console.log('option_price - '+option_price);

        var addon_price = parseInt($('#addon_price_'+pkgid).val())+parseInt(price);
        if(isNaN(addon_price)) {
          addon_price = 0;
        }
        console.log('addon_price - '+addon_price);

        var pkg_price = parseInt($('#pkg_price_'+pkgid).val());
        if(isNaN(pkg_price)) {
          pkg_price = 0;
        }
        console.log('pkg_price - '+pkg_price);



        var result = option_price + addon_price + pkg_price;
        console.log('updateaddon - '+result);

        $('#option_price_'+pkgid).val(option_price);
        $('#addon_price_'+pkgid).val(addon_price);
        $('#final_price_'+pkgid).val(result);

        $('#totPrice'+pkgid).text(result);
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
        var selectedItemAmount = e.params.data.element.dataset.amount;
        var selectedItemPkgId = e.params.data.element.dataset.pkgid;
        console.log("select2:select", e);
        // console.log('Selected Item:', selectedItem);
        //  console.log('Selected Item Template:', selectedItemTemplate);
        // console.log(selectedItemTemplate);
        //$(this).parent().find(".adnSelecTd").attr("pp", "pp");
        $(this).parent().find(".adnSelecTd").append('<div class="d-flex echSlctd_adN"><span class="ms-0 me-auto txTAdn">' +
          selectedItemTemplatePlace + '</span><span class="ms-auto me-0 txTAdnPr">' + selectedItemTemplatePrice + '</span><button type="button" class="delete_it" data-value=' + selectedItemValue + ' data-amount=' + selectedItemAmount + ' data-pkgid=' + selectedItemPkgId + '><i class="icon-minus"></i></button></div>');
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

        var price = $(this).attr('data-amount');
        console.log('dprice - '+price);
        var pkgid = $(this).attr('data-pkgid');
        console.log('dpkgid - '+pkgid);
        //var price = $(this).find(':selected').data('amount');
        //var pkgid = $(this).find(':selected').data('pkgid');

        var option_price = parseInt($('#option_price_'+pkgid).val());
        if(isNaN(option_price)) {
          option_price = 0;
        }
        console.log('option_price - '+option_price);

        var addon_price = parseInt($('#addon_price_'+pkgid).val())-parseInt(price);
        if(isNaN(addon_price)) {
          addon_price = 0;
        }
        console.log('addon_price - '+addon_price);

        var pkg_price = parseInt($('#pkg_price_'+pkgid).val());
        if(isNaN(pkg_price)) {
          pkg_price = 0;
        }
        console.log('pkg_price - '+pkg_price);



        var result = option_price + addon_price + pkg_price;
        console.log('updateaddon - '+result);

        $('#option_price_'+pkgid).val(option_price);
        $('#addon_price_'+pkgid).val(addon_price);
        $('#final_price_'+pkgid).val(result);

        $('#totPrice'+pkgid).text(result);

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