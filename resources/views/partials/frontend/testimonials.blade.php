@php
$testimonials = App\Models\Testimonials::get();
@endphp
@if(count($reviews) > 0)
<section class="home_testMlr_Holder py-3 py-md-4 py-lg-5">

  <div class="d-flex home_testMlr_HolderFl mx-0">
    <div class=" home_testMlr_HolderL d-flex px-0">
      <img src="/frontend/assets/images/home_testimonial.png">
    </div>
    <div class="home_testMlr_HolderR d-flex px-0"></div>

  </div>

  <div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5">

    <div class="the_testMnL_holdR py-0 py-md-3 py-lg-3  ">
      <div class="owl-carousel owl-theme the_testMnL">

        <!-- @foreach($testimonials as $testimonial)
        <div class="ech_testMnL">
          <div class="ech_testMnL_txt">
            <p>{{$testimonial->desc ?? ''}}</p>
          </div>
          <div class="ech_testMnL_dtL">
            <img src="{{ isset($testimonial->image) ? asset($testimonial->image) : '/upload/no_image.jpg'}}">
            <div class="ech_testMnL_dtLR">
              <h4>{{$testimonial->name ?? ''}}</h4>
            </div>
          </div>
        </div>
        @endforeach -->
        @foreach ($reviews as $review)
        <div class="ech_testMnL">
          <div class="ech_testMnL_txt">
            <div class="review-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review['rating'])
                            <span class="star-filled">&#9733;</span>
                        @else
                            <span class="star-empty">&#9734;</span>
                        @endif
                    @endfor
                </div>
            <p>{{ $review['text'] }}</p>
            
          <img src="/frontend/assets/images/google.png" alt="google" />
          </div>
          <div class="ech_testMnL_dtL">
            
            <div class="ech_testMnL_dtLR">
              <h4>{{ $review['author_name'] }}</h4>
            </div>
            <span><a href="{{ route('reviews') }}">View More</a></span>
          </div>
        </div>
        @endforeach

      </div>
    </div>



  </div>
</section>
@endif
