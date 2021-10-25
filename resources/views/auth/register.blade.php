@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>
          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              <input type="hidden" name="recaptcha" id="recaptcha">
              @csrf

              <div class="row mb-3 d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                  <label for="forename" class="mb-2 mb-lg-0 text-center text-lg-left">{{ __('Forename') }}</label>
                </div>

                <div class="col-md-10">
                  <input id="forename" type="text" class="form-control @error('forename') is-invalid @enderror" name="forename" value="{{ old('forename') }}" required autocomplete="forename" autofocus>
                  @error('forename')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3 d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                <label for="surname" class="mb-2 mb-lg-0 text-center text-lg-left">{{ __('Surname') }}</label>
                </div>
                <div class="col-md-10">
                  <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
                  @error('surname')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3 d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                <label for="email" class="mb-2 mb-lg-0 text-center text-lg-left">{{ __('E-Mail Address') }}</label>
                </div>
                <div class="col-md-10">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3 d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                <label for="password" class="mb-2 mb-lg-0 text-center text-lg-left">{{ __('Password') }}</label>
                </div>
                <div class="col-md-10">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              
              <div class="row mb-3 d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                <label for="password-confirm" class="mb-2 mb-lg-0 text-center text-lg-left">{{ __('Confirm Password') }}</label>
                </div>
                <div class="col-md-10">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
              </div>

              <div class="row mb-3 d-flex justify-content-center align-items-center">
                  <div class="col-12 text-center oauth-buttons">
                  <a href="{{ url('/auth/redirect/github') }}" class="btn btn-primary"><i class="fab fa-github"></i> Github</a>
                  <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-primary"><i class="fab fa-facebook"></i> Facebook</a>
                  <a href="{{ url('/auth/redirect/google') }}" class="btn btn-primary"><i class="fab fa-google"></i> Google</a>
                  </div>
              </div>

              <div class="col-12 text-center mb-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Register') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script>


@endsection
