@extends('layouts.app')

@section('content')

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
          <div class="card-header">
            <strong>{{ $location->name }}</strong>

          </div>
          <div class="card-body">
            <div class="row no-gutters">
              <div class="col-md-8">
                <h4>Address</h4>
                {{ $location->street }}<br>
                {{ $location->town }}<br>
                {{ $location->county }}<br>
                {{ $location->postcode }}<br>
              </div>
              <div class="col-md-4">
                <div class="map-responsive">
                  <iframe
                    width="200"
                    height="200"
                    frameborder="0"
                    style="border:1"
                    src="https://www.google.com/maps/embed/v1/place?key={{ config('gmap.google_api_key') }}&q={{ $location->name}},{{ $location->postcode}}"
                    allowfullscreen>
                  </iframe>
                </div>
              </div>
            </div>
            <div class="rating">
              @for ($i = 0; $i < 5; $i++)
                @if ($i < $location->averageRating(\App\User::class))
                  <i class="fas fa-star"></i>
                @else
                  <i class="far fa-star"></i>
                @endif
              @endfor
              <form method="POST" action="{{ route('location.rating', $location) }}">
                @csrf
                <select id="locationRating" name="locationRating">
                  @for ($i = 1; $i <= 5; $i++)
                    @if(Auth::user()->hasRated($location))
                      <option name="ratings[]" value="{{ $i }}">{{$i}}</option>
                    @else
                      <option name="ratings[]" value="{{ $i }}">{{$i}}</option>
                    @endif
                  @endfor
                </select>
                <button type="submit">Rate Location</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Comments
          </div>
          <div class="card-body">
@foreach($location->comments as $comment)
            <div class="card border-primary">
              <div class="card-header">
                <strong>{{ $comment->user->forename }} {{ $comment->user->surname }}</strong>
                @if ($comment->user->can('Edit Events'))
                <i class="fas fa-user-shield"></i>
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
              </div>
            </div>
@endforeach

            <div class="card border-primary">
              <div class="card-header">
                <strong>Add Comment</strong>
              </div>
              <div class="card-body">
                <form action="{{ route('location.comment', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                  <div class="form-group">
                    <textarea type="text" class="form-control" name="body"></textarea>
                  </div>
                  <input type="submit" class="btn-sm btn-primary" name="comment" value="Add Comment">
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
@endsection
