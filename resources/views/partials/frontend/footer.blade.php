<footer class=" py-2 py-lg-3 py-xl-3">
  <div class="container cMN_wTh my-auto py-3 py-lg-4 py-xl-5">
    <div class="d-flex flex-wrap ftr_wrpzzz">
      <div class="ftr_logo">
        <a href="{{ route('index') }}" class="ftr_logo_a">
          <img src="/frontend/assets/images/strap_studio_logo.png">
        </a>
      </div>
      <div class="ftr_adrz">
        <i class="icon-location"></i>
        <a href="https://maps.app.goo.gl/suNKW3N3YKBUD8vr5" target="_blank"><p>{{ $settings['contact_address'] ?? '' }}</p></a>
      </div>
      <div class="ftr_linkz ms-auto me-0 my-auto">

        <ul class="py-3">
          <li><a href="{{ route('about') }}">About</a></li>
          <li><a href="{{ route('services') }}">Services</a></li>
          <li><a href="{{ route('portfolio') }}">Portfolio</a></li>
          <li><a href="{{ route('workshops') }}">Workshop</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
        <div class="ftr_linkzsocaiLz py-3">
          <ul>
            <li><a href="{{ $settings['instagram'] ?? '' }}"><i class="icon-instagram"></i></a></li>
            <li><a href="{{ $settings['linkedin'] ?? '' }}"><i class="icon-linkedin"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
 



<div class="fb-customerchat"
     attribution="setup_tool"
     page_id="295095361194584"
     theme_color="#0084ff">
</div>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v11.0'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>




        </div>
</footer>