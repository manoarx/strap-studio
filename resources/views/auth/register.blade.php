@extends('layouts.frontend')

@section('content')

<section class="py-3 py-md-4 py-lg-5 insd_register_page" style="background-image: url(/frontend/assets/images/register_back.png);">
<div class="container cMN_wTh my-auto py-3 py-md-4 py-lg-5 ">
  <div class="row">
    <div class="col-md-6 d-flex"></div>
    <div class="col-md-6 d-flex">

      <div class="insd_register">
        <div class="insd_register_HEad">
          <h4>{{ __('Register') }}</h4>
        </div>
        <div class="insd_register_Pswrd">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <input placeholder="First Name" id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="fname" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-4">
                <input placeholder="Last Name" id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-4">
                <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-4">
                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-4">
                <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="d-flex">
              <button type="submit" class="insd_register_bTN mx-auto">{{ __('Register') }}</button>
            </div>
          </form>


        </div>
      </div>


    </div>
  </div>
</div>
</section>


@endsection
