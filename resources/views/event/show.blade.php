@extends('layouts.app')

@section('scripts')

<script>
   function exportList(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>


<script>
   function shareToFacebook(_this) {
  var body = 'A new event has been added to the Droid Builders Portal. ';
  body += 'Follow the link to see more details and to register your interest or ask any questions';
  FB.ui({
    display: 'iframe',
    app_id: '{{ config('fb.fb_app_id', 'Laravel') }}',
    method: 'share',
    hashtag: '#dbukevent',
    href: '{{ URL::current() }}',
    quote: body,
  }, function(response){});
}
</script>

<script>

  function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(() => {
          // Optional: Add a success message
          alert("Link copied to clipboard!");
      }).catch(err => {
          // Optional: Handle error
          console.error("Failed to copy: ", err);
      });
  }
</script>


<script type="application/javascript" async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '{{ config('fb.fb_app_id', 'Laravel') }}',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v10.0'
    });
  };
</script>

<script type="application/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        $(this).ekkoLightbox();
        event.preventDefault();
    });
</script>

@endsection

@section('content')

@php
  $user_status="no";
  $user_spotter="no";
  $user_mot="0";
  $user = $event->users->only([ Auth::user()->id ])->first();
  if ($user != NULL) {
      $user_status = $event->users->only([ Auth::user()->id ])->first()->pivot->status;
      $user_spotter = $event->users->only([ Auth::user()->id ])->first()->pivot->spotter;
      $user_mot = $event->users->only([ Auth::user()->id ])->first()->pivot->mot_required;
    }
@endphp

    <div class="row">
      <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="card">
          <div class="card-header">
            <strong>{{ $event->name }}</strong>
            <span class="float-right">
              <i class="fas fa-calendar-day"></i>
              {{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}
            </span>
          </div>
          <div class="card-body">
            <div class="row no-gutters">
              <div class="col-md-8">
                <h2 class="card-title">{{ __('Description') }}</h2>
                @if($event->created_at > \Carbon\Carbon::create(2021,8,23,0,0,0, 'Europe/London'))
                 <div id="event_description">{!! $event->description !!}</div>
                @else
                 <div id="event_description">{!! nl2br($event->description) !!}</div>
                @endif

                @if(!is_null($event->parking_details))
                  <div class="parking_details">
                    <p>{{ $event->parking_details }}</p>
                  </div>
                @endif

                @if($event->quantity != 0)
                  <div class="droid_limit">
                      <p>{{ __('Attendee Limit') }}: {{ $event->quantity }}</p>
                  </div>
                @endif

                @if($event->sw_only == 1)
                  <div class="sw_only">
                    <p><b>{{ __('Star Wars Only event') }}</b></p>
                  </div>
                <br>
                @endif

                @can('Edit Events')
                    @include('partials.show_contacts', ['contacts' => $event->contacts, 'model_type' => 'App\Event', 'model_id' => $event->id])
                @endcan

                @if(!$event->isFuture())
                  <strong>{{ __('Charity Raised') }}:</strong>
                  £{{ $event->charity_raised }}
                @endif
                @if($event->url != "")
                  <br>
                  <strong>{{ __('Event URL') }}:</strong> <a href="{{ $event->url }}" target="_blank">{{$event->url}}</a>
                @endif
                <hr>
                <i class="fas fa-calendar-day"></i> {{ __('Add to Calendar') }}:
                <a target="_blank" href="{{ $link->google() }}" class="btn-sm btn-link">Google</a>
                <a target="_blank" href="{{ $link->webOutlook() }}" class="btn-sm btn-link">Outlook</a>
                <a target="_blank" href="{{ $link->ics() }}" class="btn-sm btn-link">Apple</a>
              </div>
              <div class="col-md-4">
                @if($event->hasImage())
                <div class="image-wrapper" style="display:flex; justify-content:right;">
                    <a href="{{ route('events.showimage', $event->id) }}" data-toggle="lightbox">
                        <img src="{{ route('events.showimage', $event->id) }}" class="img-fluid">
                    </a>
                </div>
                @endif
                <div>
                  @if($event->location->name == "No Location")
                    <!-- No Location -->
                  @elseif ($event->location->name == "Online")
                    @if($event->url != "")
                      @php
                        parse_str( parse_url( $event->url, PHP_URL_QUERY ), $args );
                      @endphp
                      <iframe id="ytplayer" type="text/html" width="250" height="200"
                        src="https://www.youtube.com/embed/{{ $args['v'] }}?autoplay=0&origin=https://portal.droidbuilders.uk"
                        frameborder="0"></iframe>
                    @else
                      <iframe src="https://www.youtube.com/embed/?listType=user_uploads&list=DroidbuildersUK" width="250" height="200"></iframe>
                    @endif
                  @else
                    <div class="map-responsive">
                      <iframe
                        width="200"
                        height="200"
                        frameborder="0"
                        style="border:1"
                        src="https://www.google.com/maps/embed/v1/place?key={{ config('gmap.google_api_key') }}&q={{ urlencode($event->location->name) }},{{ urlencode($event->location->postcode) }}"
                        allowfullscreen>
                      </iframe>
                    </div>
                  @endif
                  <br>
                  <span class="float-right">
                    <a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a>
                  
                  @for ($i = 0; $i < 5; $i++)
                    @if ($i < $event->location->averageRating(\App\User::class))
                      <i class="fas fa-star"></i>
                    @else
                      <i class="far fa-star"></i>
                    @endif
                  @endfor
                  ( {{ $event->location->usersRated() }} ratings )
                  </span>
                </div>
              </div>
            </div>
            @can('Edit Events')
              <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.events.edit',$event->id) }}">{{ __('Edit') }}</a>
              <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.events.addimage',[ 'event_id' => $event->id]) }}">{{ __('Add Image') }}</a>
              <span id="export" class="btn btn-info" onclick="shareToFacebook(event.target);">Share to Facebook</span>
              <button class="btn btn-info" onclick="copyToClipboard('{{ url()->current() }}')">Copy Link</button>
              <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#addContactModal">{{ __('Add Contact') }}</button>

            @endcan
            <div>
              <span class="float-right">
                <small>{{ __('Event Submitted By') }}: {{  $event->organiser->forename }} {{  $event->organiser->surname }}</small>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="card">
            @if(!$event->isFuture())
                <div class="card-header">
                  {{ __('Attended By') }}:
                </div>
            @else
                <div class="card-header">
                  {{ __('Currently Interested') }}:
                </div>
            @endif
            <div class="card-body">
                @if(!$event->isFuture())
                    <ul>
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
                                @can('Edit Events')
                                    <a href="{{ route('admin.events.attendance.deny', [ 'event_id' => $event->id, 'user_id' => $user->id] )}}"><i class="fas fa-times-circle"></i></a>
                                @endcan
                            </li>
                        @endforeach
                    </ul>
                    @can('Edit Events')
                        <i class="far fa-question-circle"></i><strong> No Show:</strong>
                        <ul>
                            @foreach($event->notAttended as $user)
                                <li>
                                    <a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                                    @if ($user->event($event->id)->spotter == 'yes')
                                        <i class="fas fa-binoculars"></i>
                                    @endif
                                 </li>
                            @endforeach
                        </ul>
                    @endcan
                @else
                <i class="fas fa-check-circle"></i><strong> {{ __('Going') }}</strong>
                <ul>
                  @foreach($event->going as $user)
                    <li>
                      @canany(['Edit Events', 'Add MOT'])
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                        @if($user->pli_expires() < \Carbon\Carbon::parse($event->date) && $user->pli_type == 0)
                          <span class="badge badge-danger">PLI expired</span>
                        @endif
                        @if($user->pli_type > 0)
                          <span class="badge badge-warning">Third Party PLI</span>
                        @endif
                        @if($user->event($event->id)->mot_required)
                          <i class="fas fa-tools" title="MOT will be required"></i>
                        @endif
                      @else
                        {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                      @endcan
                      @if ($user->event($event->id)->spotter == 'yes')
                        <i class="fas fa-binoculars" title="No droid, just a spotter"></i>
                      @endif
                    </li>
                  @endforeach
                </ul>
                @canany(['Edit Events', 'Add MOT'])
                  <i class="far fa-question-circle"></i><strong> {{ __('Cancelled') }}:</strong>
                  <ul>
                    @foreach($event->notgoing as $user)
                      <li><a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a></li>
                    @endforeach
                  </ul>
                @endcan
                @can('Edit Events')
                <span id="export" class="btn btn-primary" data-href={{ route('admin.events.export', $event->id) }} onclick="exportList(event.target);">Download list as CSV
                </span>
                @endcan
                @endif
          </div>
        </div>


      @if($event->isFuture())
      <form action="{{ route('event.update',$event->id) }}" method="POST">
        @csrf
  @method('PUT')
  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
<div class="card">
<div class="card-header">{{ __('Register Interest') }}</div>
<div class="card-body">
    @if($user_status == "no" && $event->isFull())
    {{ __('Event is Full') }}
    @else
      <div class="form-group">
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="going" id="not_going" value="no" {{ $user_status == 'no' ? 'checked' : '' }}>
          <label class="form-check-label" for="not_going">
            {{ __('Not Going') }}
          </label>
      </div>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="going" id="is_going" value="yes" {{ $user_status == 'yes' ? 'checked' : '' }}>
          <label class="form-check-label" for="is_going">
            {{ __('Going') }}
          </label>
      </div>
      </div>
      <div class="form-group">
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="spotter" id="with_droid" value="no" {{ $user_spotter == 'no' ? 'checked' : '' }}>
          <label class="form-check-label" for="with_droid">
            {{ __('With Droid') }}
          </label>
      </div>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="spotter" id="no_droid" value="yes" {{ $user_spotter == 'yes' ? 'checked' : '' }}>
          <label class="form-check-label" for="no_droid">
            {{ __('Spotter') }}
          </label>
      </div>
      </div>
      @if ($event->canMOT())
      <div class="form-group">
      <div class="form-check form-check-inline">
          {{Form::hidden('mot_required','0')}}
          <input type="checkbox" id="mot_required" name="mot_required" {{ $user_mot ? 'checked=1 value=1' : 'value=1' }} class="form-check-input">
          <label class="form-check-label" for="mot_required">{{ __('Request MOT at event') }}</label>
      </div>
      </div>
      @else
      <div class="form-group">
          {{Form::hidden('mot_required','0')}}
          MOT are not available at this event
      </div>
      @endif
      @if (!$event->canWIP())
      <div class="form-group">
          Only completed droids at this event please.
      </div>
      @endif
      <div class="form-group">
          <button type="submit" class="btn btn-mot">{{ __('Submit') }}</button>
      </div>
    @endif
</div>
</div>
</form>
@endif
</div>
    </div>
<div id='app'>
    @include('partials.comments', ['comments' => $event->comments, 'permission' => 'Edit Events', 'model_type' => 'App\Event', 'model_id' => $event->id])
</div>

@can('Edit Events')
    @include('partials.add_contact', ['model_id' => $event->id, 'model_type' => 'App\Event'])
@endcan
@endsection
