@extends('layouts.front')

@section('header')
<!-- Header -->
<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Welcome!</h1>
              <p class="text-lead text-white"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
@endsection
@section('main-content')
<div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Verify otp</small>
              </div>
              <form method="POST" action="{{ route('verify.otp') }}">
                @csrf
                <div class="form-group mb-3">   
                  <label for="">Enter otp received in your email</label>  
                  <input type="hidden" name="email" value="{{$data['email']}}">                           
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input id="login" type="text" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="otp" value="{{ old('otp') }}" required autofocus>
                    <!-- <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="username" autofocus> -->
                  </div> 
                    @if ($errors->has('otp') )
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('otp') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="form-check-input custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember">
                         <span class="text-muted">{{ __('Remember Me') }}</span>
                    </label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Validate and Sign In</button>
                </div>
           
              </form>
            </div>
          </div>
          <div class="row mt-3">

        </div>
      </div>
    </div>
@endsection
