
@extends('layouts.app')
  
@section('content')
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">Past Events</h4>
      </div>
      <div class="card-body">
	<table class="table table-striped table-sm table-hover table-dark text-center">
		<tr>
			<th>Date</th>
			<th>Event</th>
			<th>Location</th>
			<th>Charity Raised</th>
			<th>Report Link</th>
		</tr>
		@foreach($events as $event)
			<tr>
				<td>{{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
				<td><a href="{{ route('event.show', $event->id) }}">{{ $event->name }}<a/></td>
				<td><a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
				<td>
					@if($event->charity_raised > 0)
						£{{ $event->charity_raised }}
					@endif
				</td>
				<td>
					@if($event->report_link != "")
						<a class="btn-sm btn-link" href="{{ $event->report_link }}">Report</a>
					@endif
				</td>
			</tr>
		@endforeach
	</table>
      </div>
    </div>
    {{ $events->links() }}
  </div>
</div>


@endsection

