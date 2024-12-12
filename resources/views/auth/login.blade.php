@extends('layouts.frontend')

@section('content')

<section class="py-3 py-md-4 py-lg-5 insd_register_page" style="background-image: url(/frontend/assets/images/register_back.png);">
<div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5 ">
  <div class="row">
    <div class="col-md-12 d-flex">

      <div class="insd_register mx-auto me-md-0">
        <div class="insd_register_HEad mb-0">
          <h4>Login</h4>
        </div>
        @include('flash-message')
        @if (auth()->user() && !auth()->user()->hasVerifiedEmail())
            <div class="alert alert-warning">
                Your email address is not verified. Please check your email for a verification link or <a href="{{ route('verification.resend') }}">click here to request another one</a>.
            </div>
        @endif
        <div class="insd_register_Pswrd mt-3 mt-md-4 mt-lg-5">
          <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
          <div class="col-md-12 mb-3 mb-lg-4 mt-0">
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">Please enter your username.</div>
          </div>
          <div class="col-md-12 mb-3 mb-lg-4 mt-0">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          <div class="invalid-feedback">Please enter your password!</div>
          </div>
          <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
          <div class="d-flex">
            <button type="submit" class="btN_a mx-auto">Login</button>
          </div>
          <div class="col-12">
            <a class="btn btn-link btN_a_Reg" href="{{ route('register') }}">
                Register
            </a>
          </div>
          <div class="col-12 mt-3">
              @if (Route::has('password.request'))
                          <a class="btn btn-link btN_a_Forg" href="{{ route('password.request') }}">
                              {{ __('Forgot Your Password?') }}
                          </a>
                      @endif
          </div>
        </form>


        </div>
      </div>


    </div>
  </div>
</div>
</section>


@endsection
