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
                {{ $location->country }}<br>
                {{ $location->postcode }}<br>
              </div>
              <div class="col-md-4">
                @if($location->name == "Online" || $location->name == "No Location")
                      <!-- No map to display -->
                @else
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
                @endif
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
              ( {{ $location->raters(\App\User::class)->get()->count() }} ratings )
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
      <div class="col-md-8">
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
		  {{ Carbon\Carbon::parse($comment->created_at, Auth::user()->settings()->get('timezone'))->isoFormat(Auth::user()->settings()->get('date_format').' - '.Auth::user()->settings()->get('time_format')) }}
                </span>
              </div>
              <div class="card-body">
                {!! nl2br(e($comment->body)) !!}
                @can('Edit Events')
                <span class="float-right">
                  <a href="{{ route('comment.delete', $comment->id )}}" class="btn-sm btn-danger">Delete</a>
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
                <form action="{{ route('comment.add', [$location->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="model" value="App\Location">
                  <div class="form-group">
                    <textarea type="text" class="form-control" name="body"></textarea>
                  </div>
                  <input type="submit" class="btn-sm btn-primary" name="comment" value="Add Comment"
                        onclick="this.disabled=true;this.form.submit();">
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          Events
        </div>
        <div class="card-body">
         <h2>Previous</h2>
         @if( count($events) === 0 )
		    No previous events listed
	    @else
         <table class="table table-striped table-sm table-hover table-dark text-center">
           <tr><th>Date</th><th>Name</th></tr>
           @foreach($events as $event)
           <tr>
	        <td>{{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
            <td><a href="{{ route('event.show', $event->id) }}">{{ $event->name }}</a></td>
           </tr>
           @endforeach
         </table>
         @endif
         <hr>
         <h2>Upcoming</h2>
         @if( count($upcoming) === 0 )
             No upcoming events listed
         @else
          <table class="table table-striped table-sm table-hover table-dark text-center">
            <tr><th>Date</th><th>Name</th></tr>
            @foreach($upcoming as $event)
            <tr>
             <td>{{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
             <td><a href="{{ route('event.show', $event->id) }}">{{ $event->name }}</a></td>
            </tr>
            @endforeach
          </table>
          @endif
        </div>
      </div>
    </div>
   </div>
@endsection
