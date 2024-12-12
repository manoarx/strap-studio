@extends('layouts.frontend')

@section('content')
@php
$banner = App\Models\Banners::where('page','portfolio')->first();
$portfolios = App\Models\Portfolios::where('type','video')->get();
@endphp
<section class="py-3 py-md-4 py-lg-5 portfolioback_back"
        style="background-image: url({{ isset($banner->image) ? asset($banner->image) : '/frontend/assets/images/portfolio_background.png'}});">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 my-auto ">
          <div class="d-block">
            <h1 class="portfolio_head">Videos</h1>
          </div>
        </div>
      </section>

      <section class="py-3 py-md-4 py-lg-5">
        <div class="container cMN_wTh py-3 py-md-4 py-lg-5 ">







          <div class=" grid row" id="grid_hldR_dtl">
   
              @foreach($videos as $videoItem)
              <div class="col-6 col-sm-4 col-md-3 d-flex flex-column"> 
                <video class="w-100" width="320" height="240" controls>
                    <source src="{{ $videoItem->video }}" type="{{ $videoItem->mime_type }}">
                    Your browser does not support the video tag.
                </video>
                <br/>
                <h4>{{ $videoItem->title }}</h4>
              </div> 
              @endforeach


            </div>






          

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