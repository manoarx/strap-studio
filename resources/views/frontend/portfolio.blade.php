@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','portfolio')->first();
$portfolios = App\Models\Portfolios::where('type','image')->get();
@endphp
<section class="py-3 py-md-4 py-lg-5 portfolioback_back"
        style="background-image: url({{ isset($banner->image) ? asset($banner->image) : '/frontend/assets/images/portfolio_background.png'}});">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 my-auto ">
          <div class="d-block">
            <h1 class="portfolio_head">{{$banner->title ?? 'Portfolio'}}</h1>
          </div>
        </div>
      </section>

      <section class="py-0">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">


          <div class="filter_portfolio pb-3 pb-md-4 pb-lg-5">
            <form>
              <div class="filter_portfolio_t">
                <div class="filter_portfolio_01">

                  <select class="prtFlioFIltr" id="portSelect">
                    <option data-picture="{{$portfolios[0]->getFirstMediaUrl('photos','thumb') ?? ''}}" data-text="All" value="prf1">All</option>
                    @foreach($portfolios as $portfolio)
                    <option data-picture="{{$portfolio->getFirstMediaUrl('photos','thumb') ?? ''}}" data-text="{{ $portfolio->name ?? '' }}" value="{{url('portfolio/'.$portfolio->slug)}}">
                      {{ $portfolio->name ?? '' }}
                    </option>
                    @endforeach
                  </select>

                </div>
                <!-- <div class="filter_portfolio_02">
                  <button type="button" class="filter_portfolioBtn">Book Now</button>
                </div> -->
              </div>


            </form>


          </div>



          <div class=" grid showz" id="grid_hldR">

            @foreach($portfolios as $portfolio)
            <div class="grid-item ">
              <div class="gridPrtfoliO">
                <figure>
                  <img src="{{$portfolio->getFirstMediaUrl('photos','medium') ?? ''}}">
                </figure>
                <div class="eachprtFolio_sWrp">
                  <h4 class="eachprtFolio_s_Txt">{{ $portfolio->name ?? '' }}</h4>
                </div>
                <a href="{{url('portfolio/'.$portfolio->slug)}}" class="prtFlioPageItemLink"></a>
              </div>
            </div>
            @endforeach

            <div class="loding_grid">
                <img src="{{ '/frontend/assets/images/1494.gif'}}">
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

      $(".prtFlioFIltr").select2({
        templateSelection: prtflioFrmat,
        templateResult: prtflioFrmat,
        placeholder: "Choose",
        dropdownCssClass: "dropperDown",
      });



      function prtflioFrmat(icon) {
        var originalOption = icon.element;
        var originalPic = $(originalOption).data('picture');
        var originalTxt = $(originalOption).data('text');

        // return $('<h5 class=""><span>' + originalOptionPlace + '</span>' + icon.text + '<span class="badge1">' + originalOptionPrice + '</span></h5>');
        return $('<h5 class="d-flex prfflIo_slT"><img class="ms-0  " src="' + originalPic + '""><span class="my-auto">' + originalTxt + '</span></h5>');
      }

/*
      $('.grid').packery({
        itemSelector: '.grid-item',
        gutter: 30
      });
 */


      var grid = new PinterestGrid({
        container: '.grid',
        item: '.grid-item',
        gutt: 10,
        delay:1000
      }); 
      window.addEventListener('resize', function () {
        grid.init();
      });


      setTimeout(function(){
        grid.init();
        $('#grid_hldR').removeClass("showz");
      },2000);


      $('#portSelect').change(function() {
            var selectedOption = $(this).val();
            console.log(selectedOption);
            window.location.href = selectedOption;
      });


    });





</script>

@endsection