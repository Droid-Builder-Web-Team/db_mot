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

<div id=app>
<div class="build-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="col-12">
                    <span class="float-right">
                        <i class="fas fa-calendar-day"></i>
                        {{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}
                    </span>
                    <h4 class="text-uppercase db-mb-1">{{ $event->name }}</h4>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-uppercase db-mb-1">Description</h4>
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
                                @include('partials.show_contacts', ['contacts' => $event->contacts])
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

                            <br>


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
                            </div>
                            <br>
                            <span class="float-right">
                                <a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a>
                            </span>
                        </div>
                        <div class="col-md-12">
                            @can('Edit Events')
                                <a class="btn btn-info m-2" style="width:auto;" href="{{ route('admin.events.edit',$event->id) }}">Edit</a>
                                <a class="btn btn-info m-2" style="width:auto;" href="{{ route('admin.events.addimage',[ 'event_id' => $event->id]) }}">Add Image</a>
                                <span id="export" class="btn btn-info m-2" onclick="shareToFacebook(event.target);">Share to Facebook</span>
                                <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#addContactModal">Add Contact</button>
                            @endcan
                        </div>
                    </div>
                </div>

{{-- Comments Section --}}

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Comments</h4>
                        </div>
                        <div class="col-12">
                            @foreach($event->comments as $comment)
                                <div class="build-section db-mt-2">
                                    <div class="container-fluid">
                                        <div class="row">
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
                                                {{ Carbon\Carbon::parse($comment->created_at, Auth::user()->settings()->get('timezone'))->isoFormat(Auth::user()->settings()->get('date_format').' - '.Auth::user()->settings()->get('time_format')) }}
                                            </span>
                                        </div>
                                        <div class="row">
                                            {!! nl2br(e($comment->body)) !!}
                                            @can('Edit Events')
                                                <span class="float-right">
                                                    <a href="{{ route('comment.delete', $comment->id )}}" class="btn-sm btn-danger">Delete</a>
                                                </span>
                                            @endcan
                                            <span class="float-right">
                                                <reaction-component
                                                    :comment="{{ $comment->id }}"
                                                    :summary='@json($comment->reactionSummary())'
                                                    @auth
                                                    :reacted='@json($comment->reacted())'
                                                    @endauth
                                                />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

    {{-- Add Comment --}}
                            @if($event->isFuture())
                                <div class="build-section db-mt-2">
                                    <div class="container-fluid">
                                        <div class="col-12">
                                            <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Add Comment</h4>
                                        </div>

                                        <div class="col-12">
                                            <form action="{{ route('comment.add', ['id' => $event->id] ) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="model" value="App\Event">
                                            <div class="form-group">
                                                <textarea type="text" class="form-control" name="body"></textarea>
                                            </div>
                                            <input type="submit" class="btn-sm btn-comment" name="comment" value="Add Comment"
                                                        onclick="this.disabled=true;this.form.submit();">
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>

{{-- Show interest section--}}
            <div class="col-4">
                <div class="build-section">
                    <div class="container-fluid">
                        <div class="col-12">
                            @if(!$event->isFuture())
                                <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Attended By:</h4>
                            </div>
                            <div class="col-12">
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


                                @can('Edit Events')
                                    <hr>
                                    <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Confirm Attendance:</h4>
                                    <ul>
                                        @foreach( $event->users as $user)
                                            @if($user->event($event->id)->attended == 0)
                                                <li>{{$user->forename}} {{ $user->surname}}
                                                    <a href="{{ route('admin.events.attendance.confirm', [ 'event_id' => $event->id, 'user_id' => $user->id] )}}"><i class="fas fa-check-circle"></i></a>
                                                    /
                                                    <a href="{{ route('admin.events.attendance.deny', [ 'event_id' => $event->id, 'user_id' => $user->id] )}}"><i class="fas fa-times-circle"></i></a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endcan
                            @else
                                <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Currently Interested:</h4>
                            @endif
                        </div>
                        <div class="col-12">
                            @if(!$event->isFuture())

                            @else
                                <i class="fas fa-check-circle"></i><strong> Going</strong>
                                <ul>
                                @foreach($event->going as $user)
                                        <li>
                                            @canany(['Edit Events', 'Add MOT'])
                                                <a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
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
                                                <a href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                                            </li>
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
                </div>

{{-- Register Interest Section --}}
                @if($event->isFuture())
                    <div class="build-section db-mt-2">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Register Interest</h4>
                                </div>

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
                    </div>
                @endif


            </div>

        </div>
    </div>
</div>
</div>



    @can('Edit Events')
        @include('partials.add_contact', ['model_id' => $event->id, 'model_type' => 'App\Event'])
    @endcan
@endsection
