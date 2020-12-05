@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">Upcoming Events</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-sm table-hover table-dark text-center">
            <tr>
              <th width="120px">Date</th>
              <th>Name</th>
              <th>Location</th>
              <th width="80px">Action</th>
            </tr>
            @foreach ($events as $event)
              <tr>
                <td>{{ $event->date }}</td>
                <td>{{ $event->name }}</td>
                <td><a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a></td>
                <td>
                  <a class="btn-sm btn-view" href="{{ route('event.show',$event->id) }}"><i class="fas fa-eye"></i></a>
                  @can('Edit Events')
                    <a class="btn-sm btn-edit" href="{{ route('admin.events.edit',$event->id) }}"><i class="fas fa-edit"></i></a>
                  @endcan
                </td>
              </tr>
            @endforeach
          </table>
        </div>
        {!! $events->links() !!}
        <p>
          <a class="btn-sm btn-edit" href="{{ route('codeofconduct') }}">Droid Builders UK - Event Code of Conduct</a>
      </div>
    </div>
  </div>
</div>

@endsection
