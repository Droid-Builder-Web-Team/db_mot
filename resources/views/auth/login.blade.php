@extends('layouts.app')

@section('content')
<div class="build-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="text-center db-mb-2">Login</h4>
            </div>
        </div>
        <div class="row w-100 d-flex justify-content-center">
            <div class="col-12 col-lg-6">
                <form class="w-100" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="col-12 db-my-2">
                        <label>Email Address</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 db-my-2">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>

                    <div class="col-12 db-my-2 d-flex">
                        <a href="{{ url('/auth/redirect/github') }}" class="btn btn-oauth git"><i class="fab fa-github"></i> Github</a>
                        <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-oauth facebook"><i class="fab fa-facebook"></i> Facebook</a>
                        <a href="{{ url('/auth/redirect/google') }}" class="btn btn-oauth google"><i class="fab fa-google"></i> Google</a>
                    </div>

                    <div class="col-12 db-my-2 d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-12 text-center d-flex">
                        <button type="submit" class="btn btn-login">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-forgot" href="{{ route('password.request') }}">
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
