@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Upcoming Events</h2>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-sm text-center">
        <tr>
          <th width="120px">Date</th>
            <th>Name</th>
            <th>Location</th>
            <th width="160px">Action</th>
        </tr>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->date }}</td>
            <td>{{ $event->name }}</td>
            <td><a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a></td>
            <td>
              <a class="btn-sm btn-view" href="{{ route('event.show',$event->id) }}">View</a>
              @can('Edit Events')
              <a class="btn-sm btn-edit" href="{{ route('admin.events.edit',$event->id) }}">Edit</a>
              @endcan
            </td>
        </tr>
        @endforeach
    </table>

    {!! $events->links() !!}

@endsection
