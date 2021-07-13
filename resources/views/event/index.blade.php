@extends('layouts.app')

@section('content')
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">Upcoming Events</h4>
      </div>
      <div class="card-body">
    {!! $calendar->calendar() !!}
    {!! $calendar->script() !!}
          <p>
            <br />
            <a class="btn-sm btn-link" href="{{ route('codeofconduct') }}">Droid Builders UK - Event Code of Conduct</a>
          </p>
      </div>
    </div>
  </div>
</div>
<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="card">
	<p>Club PLI covers you for any events listed here. If you want to do an event that is not listed here, either get the event organiser to
	email the club, or email in yourself with the details. </p>
	<p>Details required:
		<ul>
			<li>Event name</li>
			<li>Location (Town and Postcode at least)</li>
			<li>Date/Time</li>
			<li>Public/Private</li>
		</ul>
	</p>
	<a href="mailto:events@droidbuilders.uk">events@droidbuilders.uk</a>
</div>
	</div>
</div>
@endsection
