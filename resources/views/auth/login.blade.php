@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header text-center text-lg-left">{{ __('Login') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @samlidp
                        <div class="row mb-3 d-flex justify-content-center align-items-center">
                            <div class="col-sm-2 text-center">
                                <label for="inputEmail3" class="mb-2 mb-lg-0 text-center text-lg-left">{{ __('E-Mail Address') }}</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="row mb-2 d-flex justify-content-center align-items-center">
                            <div class="col-sm-2 text-center">
                                <label for="inputPassword3" class="mb-2 mb-lg-0 text-center text-lg-left">{{ __('Password') }}</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror 
                            </div>
                        </div>

                        <div class="row mb-3 d-flex justify-content-center align-items-center">
                            <div class="col-12 text-center oauth-buttons">
                            <a href="{{ url('/auth/redirect/github') }}" class="btn btn-primary"><i class="fab fa-github"></i> Github</a>
                            <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-primary"><i class="fab fa-facebook"></i> Facebook</a>
                            <a href="{{ url('/auth/redirect/google') }}" class="btn btn-primary"><i class="fab fa-google"></i> Google</a>
                            </div>
                        </div>

                        <div class="row mb-3 d-flex justify-content-center align-items-center">
                            <div class="col-12 text-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
