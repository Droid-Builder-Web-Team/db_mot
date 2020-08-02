@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @guest
            <div>
              Please log in.
            </div>
          @else
            <div class="card">
                <div class="card-header">{{ __('Droids') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Your Droids') }}
                </div>
            </div>
          @endguest
        </div>
    </div>
</div>
@endsection
