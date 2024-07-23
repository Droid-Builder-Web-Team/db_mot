@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <div class="col-sm-2 text-left">
                    @if(Auth::user()->id == $asset->user->id || Gate::check('Edit Marketplace'))
                        <a class="btn btn-primary" href={{ route('asset.edit', $asset->id) }}>{{ __('Edit Asset') }}</a>
                    @endif
                </div>
                <div class="col-sm-8 text-center">
                    <h4 class="text-center title">{{$asset->title}}</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <a class="btn btn-primary" href="{{ route('asset.index') }}">{{ __('Back') }}</a>
                </div>
            </div>
        </div>

      <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="row"><div class="col-md-3"><strong>{{ __('Name') }}:</strong></div><div class="col-md-9">{{ $asset->title }}</div></div>
              <div class="row"><div class="col-md-3"><strong>{{ __('Owner') }}:</strong></div><div class="col-md-9">{{ $asset->user->forename }} {{ $asset->user->surname }}</div></div>
              <div class="row"><div class="col-md-3"><strong>{{ __('Current Location') }}:</strong></div><div class="col-md-9">{{ $asset->current_holder->county }} ({{ $asset->current_holder->forename }} {{ $asset->current_holder->surname }})</div></div>
              <div class="row"><div class="col-md-3"><strong>{{ __('Added') }}:</strong></div><div class="col-md-9">{{ $asset->added }}</div></div>
              @if( $asset->created_at != $asset->updated_at)
                <div class="row"><div class="col-md-3"><strong>{{ __('Updated') }}:</strong></div><div class="col-md-9">{{ $asset->updated_at }}</div></div>
              @endif
              <div class="row"><div class="col-md-3"><strong>{{ __('Type') }}:</strong></div><div class="col-md-9">{{ strtoupper($asset->type->value) }}</div></div>
              <div class="row"><div class="col-md-3"><strong>{{ __('Current State') }}:</strong></div>
              @php
                $bgcolor = "grey";
                $color = "black";

                switch ($asset->current_state->value) {
                  case "new":
                    $bgcolor = "blue";
                    $color = "white";
                    break;
                  case "good":
                    $bgcolor = "green";
                    $color = "white";  
                    break;
                  case "worn":
                    $bgcolor = "yellow";
                    $color = "grey"; 
                    break; 
                  case "damaged":
                    $bgcolor = "red";
                    $color = "white";  
                    break;
                  case "retired":
                    $bgcolor = "grey";
                    $color = "black";  
                    break;
                }
              @endphp
                <div class="col-md-9 "><div class="btn-sm" style="background-color: {{ $bgcolor }}; color: {{ $color }}">{{ $asset->current_state }}</div></div>
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <strong>{{ __('Description') }}:</strong>
            <div id="description">{!! $asset->description !!}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id='app'>
    @include('partials.comments', ['comments' => $asset->comments, 'permission' => 'Edit Auction', 'model_type' => 'App\Models\asset', 'model_id' => $asset->id])
</div>

@endsection