@extends('layouts.app')

@section('content')

<div class="row">
  <div class="heading mb-4">
    <h1 class="title text-center">{{ $droid->name }}</h1>
  </div>
</div>
<div class="row">
  <table class="table col-md-4 mb-4">
    <tr>
      <th>Owner</th><td>
        @foreach ( $droid->users as $users )
          <a href="{{ route('user.show',$users->id) }}">{{ $users->forename }} {{ $users->surname }}</a><br>
        @endforeach
      </td></tr>
      <th>Club</th><td>{{ $droid->club->name }}</td></tr>
      <th>Type</th><td>{{ $droid->type }}</td></tr>
      <th>Style</th><td>{{ $droid->style }}</td></tr>
      <th>Radio Controlled?</th><td>{{ $droid->radio_controller }}</td></tr>
      <th>Transmitter Type</th><td>{{ $droid->transmitter_type }}</td></tr>
      <th>Material</th><td>{{ $droid->material }}</td></tr>
      <th>Approx Weight</th><td>{{ $droid->weight }}</td></tr>
      <th>Battery Type</th><td>{{ $droid->battery }}</td></tr>
      <th>Drive Voltage</th><td>{{ $droid->drive_voltage }}</td></tr>
      <th>Drive Type</th><td>{{ $droid->drive_type }}</td></tr>
      <th>Top Speed</th><td>{{ $droid->top_speed }}</td></tr>
      <th>Sound System</th><td>{{ $droid->sound_system }}</td></tr>
      <th>Approx Value</th><td>{{ $droid->value }}</td></tr>
      <th>Tier 2</th><td>{{ $droid->tier_two }}</td></tr>
      <th>Topps Number</th><td>{{ $droid->topps_id }}</td></tr>
    </tr>
  </table>
  <div class="col-md-8">                      <!-- image column -->
    <div class="row">                         <!-- droid images -->
@include('partials.image', ['photo_name' => 'photo_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'photo_side', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'photo_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
    </div> <!-- end of droid images -->

@if($droid->topps_id != null)
    <div class="row">                         <!-- topps images -->
@include('partials.image', ['photo_name' => 'topps_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'topps_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
    </div> <!-- end of topps images -->
@endif

  </div> <!-- end of images column -->
</div>

<div class="row">
  @can('Edit Droids')
    <a class="btn btn-primary" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
  @else
    <a class="btn btn-primary" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
  @endcan
</div>
<div class="row">
  @if ($droid->club->hasOption('mot'))
  <div class="col-md-6">
    MOT Details
    <table class="table">
      <tr>
        <th>Date</th>
        <th>Location</th>
        <th>Officer</th>
        <th>Approved</th>
        <th>Action</th>
      </tr>
      @foreach($droid->mot as $mot)
        <tr>
          <td>{{ $mot->date }}</td>
          <td>{{ $mot->location }}</td>
          <td>{{ $mot->officer() }}</td>
          <td>{{ $mot->approved }}</td>
          <td><a class="btn btn-primary" href="{{ route('mot.show', $mot->id) }}">View</a></td>
        </tr>
      @endforeach
    </table>
    @can('Add MOT')
      <a class="btn btn-primary" href="{{ route('admin.mot.create', $droid->id) }}">Add MOT</a>
    @endcan
  </div>
  <div class="col-md-6">
    Officer Comments
    <table class="table">
      <pre>

</pre>
    </table>
  </div>
  @endif
</div>
@endsection
