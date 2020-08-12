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
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th width="120px">Date</th>
            <th width="160px">Links</th>
            <th width="160px">Action</th>
        </tr>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->event_uid }}</td>
            <td>{{ $event->name }}</td>
            <td>{{ $event->description }}</td>
            <td>{{ $event->date }}</td>
            <td>
              @if(!empty($event->forum_link))
                <a class="btn btn-primary" href="{{ $event->forum_link }}">Forum</a>
              @endif
            </td>
            <td>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $events->links() !!}

@endsection
