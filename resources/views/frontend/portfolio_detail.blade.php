@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','portfolio')->first();
$portfolios = App\Models\Portfolios::get();
@endphp
<section class="py-3 py-md-4 py-lg-5 portfolioback_back"
        style="background-image: url({{ isset($banner->image) ? asset($banner->image) : '/frontend/assets/images/portfolio_background.png'}});">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 my-auto ">
          <div class="d-block">
            <h1 class="portfolio_head">{{$portfolio->name ?? 'Portfolio'}}</h1>
          </div>
        </div>
      </section>

      <section class="py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">


          <!-- <div class="filter_portfolio pb-3 pb-md-4 pb-lg-5">
            <form>
              <div class="filter_portfolio_t">
                <div class="filter_portfolio_01">

                  <select class="prtFlioFIltr">
                    <option data-picture="{{$portfolios[0]->getFirstMediaUrl('photos','thumb') ?? ''}}" data-text="All" value="prf1">All</option>
                    @foreach($portfolios as $portfoliolist)
                    <option data-picture="{{$portfoliolist->getFirstMediaUrl('photos','thumb') ?? ''}}" data-text="Production Studio" value="prf1">
                      {{ $portfoliolist->name ?? '' }}
                    </option>
                    @endforeach
                  </select>

                </div>
                <div class="filter_portfolio_02">
                  <button type="button" class="filter_portfolioBtn">Book Now</button>
                </div>
              </div>


            </form>


          </div> -->


          @if(isset($portfolio->photos))



          <div class=" grid row" id="grid_hldR_dtl">
            @if($portfolio->type == 'image')
              @foreach($portfolio->photos as $key => $media)
              <div class="col-6 col-sm-4 col-md-3 d-flex"> 
              <a class="grid-item " href="{{ $media->getUrl() }}" data-lightbox="certificate" rel="gallery">
                <div class="gridPrtfoliO">
                  <figure>
                    <img src="{{ $media->getUrl('medium') }}">
                  </figure>
                </div>
              </a>
                </div> 
              @endforeach
            @else
              @php
              $id = $portfolio->id;
              $portfolioVideos=App\Models\PortfolioVideos::where('portfolio_id',$id)->get();
              @endphp
              @foreach($portfolioVideos as $key => $portfolioVideo)
              @php
                $video_id = explode("?v=", $portfolioVideo->youtube_url);
                $video_id = $video_id[1];
                $thumbnail="http://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
              @endphp
              <div class="col-6 col-sm-4 col-md-3 d-flex"> 
              <a class="video-trigger" href="https://www.youtube.com/watch?v={{ $video_id ?? '' }}">
      <div class="gridPrtfoliO">
         <figure>
            <img src="{{ $thumbnail ?? '' }}">
         </figure>
      </div>
   </a>
                </div> 
              @endforeach
            @endif

            </div>
            @endif







          

        </div>
      </section>

@endsection     

@section('scripts')
<!-- <script src="https://unpkg.com/packery@2/dist/packery.pkgd.min.js"></script> -->

<!-- <script src="/frontend/assets/js/pinterest_grid.js"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

   
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">   
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script> 
 


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

/*       var grid = new PinterestGrid({
        container: '.grid',
        item: '.grid-item',
        gutt: 10,
        delay: 200
      }); window.addEventListener('resize', function () {
        grid.init();
      }); */






    });

document.addEventListener("DOMContentLoaded", function () {
    $('.video-trigger').magnificPopup({
        type: 'iframe',
        iframe: {
            patterns: {
                youtube: {
                    index: 'youtube.com/',
                    id: 'v=',
                    src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                }
            }
        }
    });
});


</script>

@endsection