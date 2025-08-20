@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-2 text-left">
                    </div>
                    <div class="col-sm-8 text-center">
                        <h4 class="text-center title">{{ __('Nominate Member') }}</h4>
                    </div>
                    <div class="col-sm-2 text-right">
                        <a class="btn btn-primary" href="{{ route('nominations.index') }}">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

              <ul>
                <li><b>{{ __('Nominee') }}:</b> {{  $nomination->nominee->forename }} {{  $nomination->nominee->surname }} </li>
                <li><b>{{ __('Nominated by') }}:</b> {{  $nomination->user->forename }} {{  $nomination->user->surname }} </li>
                <li><b>{{  __('Date') }}:</b> {{ $nomination->created_at }}
              </ul>

              <div>
              {!!  $nomination->reason !!}
              </div>

            </div>
        </div>
    </div>
</div>
@endsection