<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Home - Strap Studios</title>
  @include('partials.frontend.styles')
  @yield('styles')
</head>

<body>
  <div class="pG_wrp">
    @auth
    @if(Auth::user()->type == 'user')
    @include('partials.user.header')
    @else
    @include('partials.frontend.header')
    @endif
    @else
    @include('partials.frontend.header')
    @endif
      <div id="pG_Body">
        <!-- @include('flash-message') -->
    @yield('content')

    @include('partials.frontend.footer')

    </div>

    <div class="cntctInfo_007">
      <a href="https://wa.me/+971501544994" class="each_conCTWhatsapp"><img src="/frontend/assets/images/007_whatsapp.png"></a>
    </div>

  </div>

  @yield('modal')
  @include('partials.frontend.scripts')
  @yield('scripts')
  
</body>

</html>