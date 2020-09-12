@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Upcoming Events</h2>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
          <th width="120px">Date</th>
            <th>Name</th>
            <th>Location</th>
            <th width="160px">Links</th>
            <th width="160px">Action</th>
        </tr>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->date }}</td>
            <td>{{ $event->name }}</td>
            <td><a class="btn-sm btn-info" href="{{ route('location.show', $event->location->id )}}">{{ $event->location->name}}</a></td>

            <td>
              @if(!empty($event->forum_link))
                <a class="btn-sm btn-primary" href="{{ $event->forum_link }}">Forum</a>
              @endif

            </td>
            <td>
              <a class="btn-sm btn-primary" href="{{ route('event.show',$event->id) }}">View</a>
              @can('Edit Events')
              <a class="btn-sm btn-info" href="{{ route('admin.events.edit',$event->id) }}">Edit</a>
              @endcan
            </td>
        </tr>
        @endforeach
    </table>

    {!! $events->links() !!}

@endsection
