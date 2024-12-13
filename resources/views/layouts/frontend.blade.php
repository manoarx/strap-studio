<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

        <!-- SEO START-->
        {!! SEO::generate() !!}
        <!-- SEO END-->

        <link href="{{asset('manifest.json')}}" rel="manifest">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <meta name="apple-mobile-web-app-title" content="Strap Studios">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <link rel="apple-touch-icon" href="{{asset('icons/apple-touch-icon.png')}}">
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
                <a href="https://wa.me/+971501544994" class="each_conCTWhatsapp"><img
                        src="/frontend/assets/images/007_whatsapp.png"></a>
            </div>

        </div>

        @yield('modal')
        @include('partials.frontend.scripts')
        @yield('scripts')

    </body>

</html>
