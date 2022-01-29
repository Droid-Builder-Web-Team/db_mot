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


<div class="build-section text-center page-heading-text d-flex flex-column db-mt-2" id="app">
    <div class="container-fluid">


        <div class="row">
            {{-- Event Header --}}
            <div class="col-12 col-md-4">
                <h4><i class="fas fa-calendar-day"></i> {{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</h4>
            </div>
            <div class="col-12 col-md-4">
                <h4>{{ $event->name }}</h4>
            </div>
            <div class="col-12 col-md-4">
                <h4><i class="fas fa-map-marker-alt"></i> <a class="p-link" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a></h4>
            </div>
            <div class="col-12">
                <div class="buttons icon-text">
                    <a class="btn btn-back" href="{{ url()->previous() }}">Back</a>
                </div>
            </div>
            @can('Edit Events')
                <div class="col-12">
                    <a class="btn btn-info m-1" href={{ route('admin.events.edit', $event->id) }}>Edit Event</a>
                    <a class="btn btn-info m-1" style="width:auto;" href="{{ route('admin.events.addimage',[ 'event_id' => $event->id]) }}">Add Image</a>
                    <button id="export" class="btn btn-info m-1" onclick="shareToFacebook(event.target);">Share</button>
                    <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#addContactModal">Add Contact</button>
                </div>
            @endcan
        </div>


        <div class="row">
            <div class="col-xl-8">
                <div class="build-section db-my-2">
                    <div class="container-fluid">
                        {{-- Image --}}
                        <div class="row">
                            @if($event->hasImage())
                                    <div class="col-lg-6 db-my-1">
                                        <div class="image-wrapper">
                                            <a href="{{ route('events.showimage', $event->id) }}" data-toggle="lightbox">
                                                <img src="{{ route('events.showimage', $event->id) }}" class="img-fluid" width=500 height=500>
                                            </a>
                                        </div>
                                    </div>
                            @endif

                            <div class="col-lg-6 db-my-1">
                                <div>
                                    @if($event->location->name == "No Location")
                                        <!-- No Location -->
                                    @elseif ($event->location->name == "Online")
                                        @if($event->url != "")
                                        @php
                                            parse_str( parse_url( $event->url, PHP_URL_QUERY ), $args );
                                        @endphp
                                        <iframe id="ytplayer" type="text/html" width="500" height="500"
                                            src="https://www.youtube.com/embed/{{ $args['v'] }}?autoplay=0&origin=https://portal.droidbuilders.uk"
                                            frameborder="0"></iframe>
                                        @else
                                            <iframe src="https://www.youtube.com/embed/?listType=user_uploads&list=DroidbuildersUK" width="500" height="500"></iframe>
                                        @endif
                                    @else
                                        <div class="map-responsive">
                                            <iframe
                                                width="500"
                                                height="300"
                                                frameborder="0"
                                                style="border:1"
                                                src="https://www.google.com/maps/embed/v1/place?key={{ config('gmap.google_api_key') }}&q={{ urlencode($event->location->name) }},{{ urlencode($event->location->postcode) }}"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Main Text --}}
                        <div class="col-md-12">
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
                                    <p>Attendee Limit: {{ $event->quantity }}</p>
                                </div>
                            @endif

                            @can('Edit Events')
                                @include('partials.show_contacts', ['contacts' => $event->contacts, 'model_type' => 'App\Event', 'model_id' => $event->id])
                            @endcan

                            @if(!$event->isFuture())
                                <strong>Charity Raised:</strong>
                                £{{ $event->charity_raised }}
                            @endif

                            @if($event->url != "")
                                <br>
                                <strong>Event URL:</strong> <a href="{{ $event->url }}" target="_blank">{{$event->url}}</a>
                            @endif
                            <hr>
                            <i class="fas fa-calendar-day"></i> Add to Calendar:
                            <a target="_blank" href="{{ $link->google() }}" class="btn-sm btn-link">Google</a>
                            <a target="_blank" href="{{ $link->webOutlook() }}" class="btn-sm btn-link">Outlook</a>
                            <a target="_blank" href="{{ $link->ics() }}" class="btn-sm btn-link">Apple</a>
                        </div>
                    </div>
                </div>
            </div>

{{-- Show interest section--}}
            <div class="col-xl-4">
                <div class="build-section db-my-2">
                    <div class="container-fluid">
                        @if(!$event->isFuture())
                            <div class="col-12">
                                <h5 class="col-12 text-center db-mb-1">Attended By:</h5>
                            </div>
                            <div class="col-12 form-section text-center text-sm-left db-my-1">
                                <ul>
                                    @foreach($event->attended as $user)
                                        <li>
                                            @can('Edit Events')
                                                <a class="p-link" href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                                            @else
                                                {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                                            @endcan

                                            @if ($user->event($event->id)->spotter == 'yes')
                                                <i class="fas fa-binoculars"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                @can('Edit Events')
                                    <h5 class="col-12 text-center db-mb-1">Confirm Attendance:</h5>
                                    <ul>
                                        @foreach( $event->users as $user)
                                            @if($user->event($event->id)->attended == 0)
                                                <li>{{$user->forename}} {{ $user->surname}}
                                                    <a class="p-link" href="{{ route('admin.events.attendance.confirm', [ 'event_id' => $event->id, 'user_id' => $user->id] )}}"><i class="fas fa-check-circle"></i></a>
                                                    /
                                                    <a class="p-link" href="{{ route('admin.events.attendance.deny', [ 'event_id' => $event->id, 'user_id' => $user->id] )}}"><i class="fas fa-times-circle"></i></a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endcan
                            </div>
                        @else
                            <div class="col-12">
                                <h5 class="col-12 text-center db-mb-1">Currently Interested:</h5>
                            </div>
                            <div class="col-12 form-section text-left db-my-1">
                                <i class="fas fa-check-circle"></i><strong> Going</strong>
                                <ul>
                                    @foreach($event->going as $user)
                                        <li>
                                            @canany(['Edit Events', 'Add MOT'])
                                                <a class="p-link" href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                                                @if($user->pli_expires() < \Carbon\Carbon::parse($event->date))
                                                    &nbsp;<span class="badge badge-danger">PLI expired</span>
                                                @endif
                                                @if($user->event($event->id)->mot_required)
                                                    &nbsp;<i class="fas fa-tools" title="MOT will be required"></i>
                                                @endif
                                            @else
                                                {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                                            @endcan
                                            @if ($user->event($event->id)->spotter == 'yes')
                                                &nbsp;<i class="fas fa-binoculars" title="No droid, just a spotter"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                @canany(['Edit Events', 'Add MOT'])
                                    <i class="far fa-question-circle"></i><strong> Cancelled:</strong>
                                    <ul>
                                        @foreach($event->notgoing as $user)
                                            <li>
                                                <a class="p-link" href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endcan

                            </div>
                            @can('Edit Events')
                                <div class="col-12">
                                    <button class="btn btn-primary" data-href={{ route('admin.events.export', $event->id) }} onclick="exportList(event.target);">Download list as CSV
                                    </button>
                                </div>
                            @endcan
                        @endif



{{-- Register Interest Section --}}
                        @if($event->isFuture())
                            <br>
                            <div class="divider"></div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="col-12 text-center db-mb-1">Register Interest</h5>
                                </div>
                                <div class="col-12">
                                    <form action="{{ route('event.update',$event->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                        @if($user_status == "no" && $event->isFull())
                                            Event is full
                                        @else
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="going" id="not_going" value="no" {{ $user_status == 'no' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="not_going">
                                                        Not Going
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
                                            @if ($event->canMOT())
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        {{Form::hidden('mot_required','0')}}
                                                        <input type="checkbox" id="mot_required" name="mot_required" {{ $user_mot ? 'checked=1 value=1' : 'value=1' }} class="form-check-input">
                                                        <label class="form-check-label" for="mot_required">Request MOT at event</label>
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
                                                <button type="submit" class="btn btn-link">Submit</button>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('partials.comments', ['comments' => $event->comments, 'permission' => 'Edit Events', 'model_type' => 'App\Event', 'model_id' => $event->id])
    </div>
</div>





    @can('Edit Events')
        @include('partials.add_contact', ['model_id' => $event->id, 'model_type' => 'App\Event'])
    @endcan
@endsection
