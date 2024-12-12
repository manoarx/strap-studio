<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin - {{ config('app.name', 'Laravel') }}</title>

  @include('partials.backend.styles')

  @yield('styles')

</head>

<body>
  

<div class="prLdr loader"  id="loader">

<div class="lds-facebook">
  <div></div>
  <div></div>
  <div></div>
</div>

</div>

@include('partials.backend.header')

@include('partials.backend.sidebar')

<main id="main" class="main">

@yield('content')

</main>

@include('partials.backend.footer')

@include('partials.backend.scripts')

@yield('scripts')
  
</body>

</html>