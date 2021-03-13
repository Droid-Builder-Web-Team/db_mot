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

@endsection
