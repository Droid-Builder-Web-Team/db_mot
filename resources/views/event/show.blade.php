@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-1">
            <div class="pull-right">
                <a class="btn btn-mot" href="{{ route('event.index') }}"> Back</a>
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
                <br>
                @if(!$event->isFuture())
                  <strong>Charity Raised:</strong>
                  £{{ $event->charity_raised }}
                @endif
                <hr>
                Add to:
                <a target="_blank" href="{{ $link->google() }}" class="btn-sm">Google</a>
                <a target="_blank" href="{{ $link->webOutlook() }}" class="btn-sm">Outlook</a>
                <a target="_blank" href="{{ $link->ics() }}" class="btn-sm">Apple</a>
              </div>
              <div class="col-md-4">
                <div class="map-responsive">
                <iframe
                  width="200"
                  height="200"
                  frameborder="0"
                  style="border:1"
                  src="https://www.google.com/maps/embed/v1/place?key={{ config('gmap.google_api_key') }}&q={{ $event->location->name}},{{ $event->location->postcode}}"
                  allowfullscreen>
                </iframe>
              </div>
                <br>
                <span class="float-right">
                  <a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="card">
          <div class="card-header">
            @if(!$event->isFuture())
              Attended By:
            </div>
            <div class="card-body">
                @foreach($event->attended as $user)
                  <li>
                    @can('Edit Events')
                      <a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                    @else
                      {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                    @endcan
                    @if ($user->event($event->id)->spotter == 'yes')
                      <i class="fas fa-binoculars"></i>
                    @endif
                  </li>
                @endforeach
            @else
              Currently Interested:
            @endif
          </div>
          <div class="card-body">
            @if(!$event->isFuture())

            @else
            <i class="fas fa-check-circle"></i><strong> Going</strong>
              <ul>
                @foreach($event->going as $user)
                  <li>
                    @can('Edit Events')
                      <a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                      @if($user->pli_expires() < \Carbon\Carbon::parse($event->date))
                        <span class="badge badge-danger">PLI expired</span>
                      @endif
                    @else
                      {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                    @endcan
                    @if ($user->event($event->id)->spotter == 'yes')
                      <i class="fas fa-binoculars"></i>
                    @endif
                  </li>
                @endforeach
              </ul>
              <i class="far fa-question-circle"></i><strong> Maybe:</strong>
              <ul>
                @foreach($event->maybe as $user)
                  <li>
                    @can('Edit Events')
                      <a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                    @else
                      {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                    @endcan
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

    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            Comments
          </div>
          <div class="card-body">
@foreach($event->comments as $comment)
            <div class="card border-primary">
              <div class="card-header">
                <strong>{{ $comment->user->forename ?? "Deactivated"}} {{ $comment->user->surname ?? "User"}}</strong>
                @if ($comment->user != NULL)
                  @if ($comment->user->can('Edit Events'))
                    <i class="fas fa-user-shield"></i>
                  @endif
                @endif
                <span class="float-right">
                  @if ($comment->broadcast)
                    <i class="fas fa-bullhorn"></i>
                  @endif
                  {{ $comment->created_at }}
                </span>
              </div>
              <div class="card-body">
                {!! nl2br(e($comment->body)) !!}
                @can('Edit Events')
                <span class="float-right">
                  <a href="{{ route('admin.events.delete_comment', $comment->id )}}" class="btn-sm btn-danger">Delete</a>
                </span>
                @endcan
              </div>
            </div>
@endforeach

            <div class="card border-primary">
              <div class="card-header">
                <strong>Add Comment</strong>
              </div>
              <div class="card-body">
                <form action="{{ route('event.comment', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                  <div class="form-group">
                    <textarea type="text" class="form-control" name="body"></textarea>
                  </div>
                  <input type="submit" class="btn-sm btn-comment" name="comment" value="Add Comment">
                  @can('Edit Events')
                    <div class="form-check float-right">
                      <input class="form-check-input" type="checkbox" name="broadcast" id="broadcast">
                      <label class="form-check-label" for="broadcast">Broadcast</label>
                    </div>
                  @endcan
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
@if($event->isFuture())
@php
  $user_status="no";
  $user_spotter="no";
  $user = $event->users->only([ Auth::user()->id ])->first();
  if ($user != NULL) {
      $user_status = $event->users->only([ Auth::user()->id ])->first()->pivot->status;
      $user_spotter = $event->users->only([ Auth::user()->id ])->first()->pivot->spotter;
    }
@endphp


      <div class="col-md-4">
        <form action="{{ route('event.update',$event->id) }}" method="POST">
                  @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
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
                <button type="submit" class="btn btn-mot">Submit</button>
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>
    @endif
@endsection
