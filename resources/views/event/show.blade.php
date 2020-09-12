@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('event.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <strong>Name:</strong>
        {{ $event->name }}
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <strong>Location</strong>
        <a href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6">
        <strong>Date:</strong>
        {{ $event->date }}
      </div>
    </div>

@php
  $parsed_date = \Carbon\Carbon::createFromFormat('Y-m-d', $event->date);
@endphp
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
      @if($parsed_date->isPast())
        <strong>Charity Raised:</strong>
        £{{ $event->charity_raised }}
      @endif
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6">
        <strong>Links:</strong>
        @if(!empty($event->forum_link))
          <a class="btn-sm btn-info" href="{{ $event->forum_link }}">Forum</a>
        @endif

        @if(!empty($event->report_link))
          <a class="btn-sm btn-info" href="{{ $event->report_link }}">Report</a>
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <strong>Description:</strong><br>
        {{ $event->description }}
      </div>
    </div>

<div class="row">
  <hr>
</div>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
      @if($parsed_date->isPast())
        <h4>Attended By: </h4>
      </div>
    </div>            
      @else
        <h4>Currently Interested: </h4>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <ul>
    @foreach($event->going as $user)
        <li><a href="{{ route('user.show', $user->id) }}">{{ $user->forename}} {{ $user->surname }}</a>
        </li>
    @endforeach
  </ul>
  <h6>Maybe:</h6>
      <ul>
    @foreach($event->maybe as $user)
        <li><a href="{{ route('user.show', $user->id) }}">{{ $user->forename}} {{ $user->surname }}</a></li>
    @endforeach
  </ul>
  </div>
    </div>
    @endif

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
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
      <h4>Register Interest</h4>
    </div>
    <div class="row">

      <div class="col-xs-6 col-sm-6 col-md-6">
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
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <br>
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
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>

    </form>
    @endif
@endsection
