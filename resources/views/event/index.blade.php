@extends('layouts.app')

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
@endsection

@section('content')

<div class="build-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Upcoming Events</h4>
            </div>


            <div class="col-12 db-my-2">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>


            <div class="col-12 buttons">
                <a class="btn btn-standard" href="{{ route('codeofconduct') }}">Droid Builders UK - Event Code of Conduct</a>
                <a class="btn btn-standard" href="{{ route('event.past') }}">Past Events</a>
                <a class="btn btn-standard" href="{{ route('event.map') }}">View as Map</a>
            </div>

        </div>
    </div>
</div>

<div class="build-section db-mt-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Submit Events</h4>
            </div>

            <div class="col-12">
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
</div>

@endsection
