@extends('layouts.app')
@section('content')
	<div class="build-section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 text-center">
					<h4>Past Events</h4>

					<div class="buttons">
						<a class="btn btn-back" href="{{ url()->previous() }}">Back</a>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table text-center table-hover">
						<thead>
							<tr>
								<th>Date</th>
								<th>Event</th>
								<th>Location</th>
								<th>Charity Raised</th>
								<th>Report Link</th>
							</tr>
						</thead>
						<tbody>
							@foreach($events as $event)
							<tr>
								<td>{{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
								<td><a href="{{ route('event.show', $event->id) }}">{{ $event->name }}<a/></td>
								<td><a class="btn btn-standard" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
								<td>
									@if($event->charity_raised > 0)
										£{{ $event->charity_raised }}
									@endif
								</td>
								<td>
									@if($event->report_link != "")
										<a class="btn btn-standard" href="{{ $event->report_link }}">Report</a>
									@endif
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				{{ $events->links() }}
			</div>
		</div>
	</div>
@endsection

