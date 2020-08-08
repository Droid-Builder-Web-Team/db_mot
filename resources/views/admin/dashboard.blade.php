@extends('layouts.app')

@section('content')
<div class="heading mb-3">
    <h1 class="title text-center">Admin Dashboard</h1>
</div>

<div class="row mb-3">
  <div class="col-md-6 text-center"><h2>Cleared Members: </h2>
    @php($count=0)
    @foreach ($users as $user)
      @if ($user->validPLI())
        @php($count++)
      @endif
    @endforeach
    <h2>{{ $count }}</h2>
  </div>
  <div class="col-md-6 text-center"><h2>Cleared Droids: </h2>
    @php($count=0)
    @foreach ($droids as $droid)
      @if ($droid->hasMOT())
        @php($count++)
      @endif
    @endforeach
    <h2>{{ $count }}</h2>
  </div>
</div>

<div class="row">
  <div class="col-md-6 text-center"><h2>Upcoming PLI</h2>
    <table class="table">
      <tr>
        <th>Name</th>
        <th>PLI Date</th>
        <th></th>
      </tr>
    @foreach ($users as $user)
        @if ($user->expiringPLI())
            <tr>
              <td>{{$user->forename}} {{ $user->surname}}</td>
              <td>{{$user->pli_date}}</td>
              <td><a class="btn btn-primary" href="{{ route('admin.users.edit',$user->member_uid) }}">Edit</a></td>
            </tr>
        @endif
    @endforeach
    </table>
  </div>
  <div class="col-md-6 text-center"><h2>Upcoming MOT</h2>
    <table class="table">
      <tr>
        <th>Name</th>
        <th>MOT Date</th>
        <th></th>
      </tr>
    @foreach ($droids as $droid)
        @if ($droid->hasExpiringMOT())
            <tr>
              <td>{{$droid->name}}</td>
              <td>{{$droid->motDate()}}</td>
              <td><a class="btn btn-primary" href="{{ route('admin.droids.edit',$droid->droid_uid) }}">Edit</a></td>
            </tr>
        @endif
    @endforeach
    </table>
  </div>
</div>

<div class="row">
  <h2>Upcoming Events:</h2>
    <table class="table">
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Location</th>
        <th></th>
      </tr>
  @foreach ($events as $event)
    <tr>
      <td>{{ $event->name }}</td>
      <td>{{ $event->date }}</td>
      <td>{{ $event->location }}</td>
      <td><a class="btn btn-primary" href="{{ route('admin.events.edit',$event->event_uid) }}">Edit</a></td>
    </tr>
  @endforeach
</table>
</div>


@endsection
