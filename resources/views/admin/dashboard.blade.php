@extends('layouts.app')

@section('content')
<div class="heading mb-3">
    <h1 class="title text-center">Admin Dashboard</h1>
</div>

<div class="row mb-3">
  <div class="col-md-6 text-center">
    <div class="card border-primary">
      <div class="card-header title text-center">Cleared Members</div>
      <div class="card-body">
        @php($count=0)
        @foreach ($users as $user)
          @if ($user->validPLI())
            @php($count++)
          @endif
        @endforeach
        <h2 style="color:#000000;">{{ $count }}</h2>
      </div>
    </div>
  </div>

  <div class="col-md-6 text-center">
    <div class="card border-primary">
      <div class="card-header title text-center">Cleared Droids</div>
      <div class="card-body">
        @php($count=0)
        @foreach ($droids as $droid)
          @if ($droid->hasMOT())
            @php($count++)
          @endif
        @endforeach
        <h2 style="color:#000000;">{{ $count }}</h2>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 text-center">
    <div class="card border-primary">
      <div class="card-header title text-center">Upcoming PLI</div>
      <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped table-sm table-hover table-dark text-center">
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
                <td>
                  @can('View Members')
                    <a class="btn-sm btn-view" href="{{ route('user.show',$user->id) }}"><i class="fas fa-eye"></i></a>
                  @endcan
                  @can('Edit Members')
                    <a class="btn-sm btn-edit" href="{{ route('admin.users.edit',$user->id) }}"><i class="fas fa-edit"></i></a>
                  @endcan
                </td>
              </tr>
            @endif
          @endforeach
        </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 text-center">
    <div class="card border-primary">
      <div class="card-header title text-center">Upcoming MOT</div>
      <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped table-sm table-hover table-dark text-center">
          <tr>
            <th>Name</th>
            <th>Owner</th>
            <th>MOT Date</th>
            <th></th>
          </tr>
          @foreach ($droids as $droid)
            @if ($droid->hasExpiringMOT())
              <tr>
                <td>{{$droid->name}}</td>
                <td>
                  @foreach ( $droid->users as $users )
                    {{ $users->forename }} {{ $users->surname }}<br>
                  @endforeach
                </td>
                <td>{{$droid->motDate()}}</td>
                <td>
                  @can('View Droids')
                    <a class="btn-sm btn-view" href="{{ route('droid.show',$droid->id) }}"><i class="fas fa-eye"></i></a>
                  @endcan
                  @can('Edit Droids')
                    <a class="btn-sm btn-edit" href="{{ route('admin.droids.edit',$droid->id) }}"><i class="fas fa-edit"></i></a>
                  @endcan
                </td>
              </tr>
              @endif
        @endforeach
        </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 text-center">
  <div class="card border-primary">
    <div class="card-header title text-center">Upcoming Events</div>
    <div class="card-body">
        <div class="table-responsive">
      <table class="table table-striped table-sm table-hover table-dark text-center">
        <tr>
          <th>Date</th>
          <th>Name</th>
          <th>Location</th>
          <th><i class="fas fa-check">/<i class="fas fa-question">/<i class="fas fa-times"></i></th>
          <th>Actions</th>
        </tr>
        @foreach ($events as $event)
          <tr>
            <td>{{ $event->date }}</td>
            <td>{{ $event->name }}</td>
            <td><a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id ) }}">{{ $event->location->name }}</a></td>
            <td>{{ $event->going->count() }}/{{ $event->maybe->count() }}/{{$event->notgoing->count()}}</td>
            <td>
              <a class="btn-sm btn-view" href="{{ route('event.show', $event->id) }}"><i class="fas fa-eye"></i></a>
              @can('Edit Events')
                <a class="btn-sm btn-edit" href="{{ route('admin.events.edit',$event->id) }}"><i class="fas fa-edit"></i></a>
              @endcan
            </td>
          </tr>
        @endforeach
      </table>
    </div>
    </div>
  </div>
</div>
</div>


@endsection
