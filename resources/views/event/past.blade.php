
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
		</tr>
		@foreach($events as $event)
			<tr>
				<td>{{ $event->date }}</td>
				<td><a href="{{ route('event.show', $event->id) }}">{{ $event->name }}<a/></td>
				<td><a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
			</tr>
		@endforeach
	</table>
	{{ $events->links() }}
      </div>
    </div>
  </div>
</div>


@endsection

