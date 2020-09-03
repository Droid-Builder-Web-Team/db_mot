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
        {{ $event->location->name}}
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6">
        <strong>Date:</strong>
        {{ $event->date }}
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <strong>Charity Raised:</strong>
        £{{ $event->charity_raised }}
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6">
        <strong>Links:</strong>
        @if(!empty($event->forum_link))
          <a class="btn btn-primary" href="{{ $event->forum_link }}">Forum</a>
        @endif

        @if(!empty($event->report_link))
          <a class="btn btn-primary" href="{{ $event->report_link }}">Report</a>
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
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h4>Currently Interested: </h4>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
      </div>
    </div>

    <form action="{{ route('event.update',$event->id) }}" method="POST">
    <div row="row">
      <h4>Register Interest</h4>
    </div>
    <div class="row">

      <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="going" id="not_going" value="no" checked>
          <label class="form-check-label" for="not_going">
            Not Going
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="going" id="maybe_going" value="maybe">
          <label class="form-check-label" for="maybe_going">
            Maybe
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="going" id="maybe_going" value="yes">
          <label class="form-check-label" for="is_going">
            Going
          </label>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6">
        <br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="droid" id="with_droid" value="yes" checked>
          <label class="form-check-label" for="not_going">
            With Droid
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="droid" id="without_droid" value="no">
          <label class="form-check-label" for="without_droid">
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
@endsection
