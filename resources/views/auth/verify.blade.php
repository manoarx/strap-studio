<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
  <link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />
  <link href="/frontend/assets/css/animate.css" rel="stylesheet" />
  <link href="/frontend/assets/css/sal.css" rel="stylesheet" />
  <link href="/frontend/assets/css/Glyphter.css" rel="stylesheet" />
  <link href="/frontend/assets/css/owl.theme.default.min.css" rel="stylesheet" />
  <link href="/frontend/assets/css/owl.carousel.min.css" rel="stylesheet" />
  <link href="/frontend/assets/css/slick.css" rel="stylesheet" />

  <link href="/frontend/assets/css/variables.css" rel="stylesheet" />
  <link href="/frontend/assets/css/style.css" rel="stylesheet" />
  <link href="/frontend/assets/css/responsive.css" rel="stylesheet" />

  <link rel="apple-touch-icon" sizes="180x180" href="/frontend/assets/images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/frontend/assets/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/frontend/assets/images/favicon-16x16.png">
  <link rel="manifest" href="/frontend/assets/images/site.webmanifest">

  <title>Login - Strap Studios</title>
</head>

<body>
    <section class="sectLogin">
      <div class="blkZVerify">
        <div class="blkZLogin_orNl">
          <div class="">
            <figure>
              <a class="navbar-brand my-auto hDr_Logo" href="{{ route('index') }}">
          <img src="/frontend/assets/images/strap_studio_logo.png" alt="Strap Studios" />
        </a>
            </figure>

            <!-- <div class="blkZLogin_orNl_thSTxt">
              <h4>XYZ SCHOOL</h4>
              <a href="#" class="blkZLogin_orNl_thSlNk">Photo Outlet</a>
            </div> -->

          </div>
          <!-- <div class="blkZLogin_orNloG">
            <a href="#" class="blkZLogin_orNloG_img">
              <img src="/frontend/assets/images/strap_studio_logo.png">
            </a>
          </div> -->
        </div>

    <div class="pG_wrp">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="GET" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</body>

</html>