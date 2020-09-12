@extends('layouts.app')

@section('content')

@php
  $parsed_date = \Carbon\Carbon::createFromFormat('Y-m-d', $event->date);
@endphp

    <div class="row">
        <div class="col-lg-1">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('event.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="card">
          <div class="card-header">
            <strong>{{ $event->name }}</strong>
            <span class="float-right">
              <i class="fas fa-calendar-day"></i>
              {{ $event->date }}
            </span>
          </div>
          <div class="card-body">
            <div class="row no-gutters">
              <div class="col-md-8">
                <h2 class="card-title">Description</h2>
                {!! nl2br(e($event->description)) !!}
                @if($parsed_date->isPast())
                  <strong>Charity Raised:</strong>
                  £{{ $event->charity_raised }}
                @endif
              </div>
              <div class="col-md-4">
                <div class="map-responsive">
                <iframe
                  width="200"
                  height="200"
                  frameborder="0"
                  style="border:1"
                  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD2QiwZdErH0x-FaVAQxdDkaW-EA-lK8ng&q={{ $event->location->name}},{{ $event->location->postcode}}"
                  allowfullscreen>
                </iframe>
              </div>
                <br>
                <span class="float-right">
                  <a class="btn-sm btn-info" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="card">
          <div class="card-header">
            @if($parsed_date->isPast())
              Attended By:
            @else
              Currently Interested:
            @endif
          </div>
          <div class="card-body">
            @if($parsed_date->isPast())

            @else
              <strong>Going</strong>
              <ul>
                @foreach($event->going as $user)
                  <li><a href="{{ route('user.show', $user->id) }}">{{ $user->forename}} {{ $user->surname }}</a>
                    @if ($user->event($event->id)->spotter == 'yes')
                      <i class="fas fa-binoculars"></i>
                    @endif
                  </li>
                @endforeach
              </ul>
              <strong>Maybe:</strong>
              <ul>
                @foreach($event->maybe as $user)
                  <li><a href="{{ route('user.show', $user->id) }}">{{ $user->forename}} {{ $user->surname }}</a>
                    @if ($user->event($event->id)->spotter == 'yes')
                      <i class="fas fa-binoculars"></i>
                    @endif
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
        </div>
      </div>
    </div>

@if(!$parsed_date->isPast())
@php
  $user_status="no";
  $user_spotter="no";
  $user = $event->users->only([ Auth::user()->id ])->first();
  if ($user != NULL) {
      $user_status = $event->users->only([ Auth::user()->id ])->first()->pivot->status;
      $user_spotter = $event->users->only([ Auth::user()->id ])->first()->pivot->spotter;
    }
@endphp
    <form action="{{ route('event.update',$event->id) }}" method="POST">
              @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div row="row">
      <div class="col-6-md">
        <div class="card">
          <div class="card-header">Register Interest</div>
          <div class="card-body">
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="going" id="not_going" value="no" {{ $user_status == 'no' ? 'checked' : '' }}>
                <label class="form-check-label" for="not_going">
                  Not Going
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="going" id="maybe_going" value="maybe" {{ $user_status == 'maybe' ? 'checked' : '' }}>
                <label class="form-check-label" for="maybe_going">
                  Maybe
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="going" id="is_going" value="yes" {{ $user_status == 'yes' ? 'checked' : '' }}>
                <label class="form-check-label" for="is_going">
                  Going
                </label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="spotter" id="with_droid" value="no" {{ $user_spotter == 'no' ? 'checked' : '' }}>
                <label class="form-check-label" for="with_droid">
                  With Droid
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="spotter" id="no_droid" value="yes" {{ $user_spotter == 'yes' ? 'checked' : '' }}>
                <label class="form-check-label" for="no_droid">
                  Spotter
                </label>
              </div>
            </div>

            <div class="form-group">
              <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
    @endif
@endsection
