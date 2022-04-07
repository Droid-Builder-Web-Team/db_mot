@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col md-6">
    <div class="card">
      <div class="card-header">
        <span class="float-left">
          <h2>{{ $droid->name }}</h2>
        </span>
      </div>
      <div class="card-body">
        <table class="table table-striped table-sm table-hover table-dark">
          <tr>
            <th>Owner</th>
            <td>
              @foreach ( $droid->users as $users )
                {{ $users->forename }} {{ $users->surname }}<br>
              @endforeach
            </td>
          </tr>
          <tr><th>Type</th><td>{{ $droid->type }}</td></tr>
          <tr><th>Style</th><td>{{ $droid->style }}</td></tr>
          <tr><th>Radio Controlled?</th><td>{{ $droid->radio_controlled }}</td></tr>
          <tr><th>Transmitter Type</th><td>{{ $droid->transmitter_type }}</td></tr>
          <tr><th>Material</th><td>{{ $droid->material }}</td></tr>
          <tr><th>Approx Weight</th><td>{{ $droid->weight }}</td></tr>
          <tr><th>Battery Type</th><td>{{ $droid->battery }}</td></tr>
          <tr><th>Drive Voltage</th><td>{{ $droid->drive_voltage }}</td></tr>
          <tr><th>Drive Type</th><td>{{ $droid->drive_type }}</td></tr>
          <tr><th>Top Speed</th><td>{{ $droid->top_speed }}</td></tr>
          <tr><th>Sound System</th><td>{{ $droid->sound_system }}</td></tr>
          <tr><th>Build Log</th><td><a target="_blank" href="{{ $droid->build_log }}">{{ $droid->build_log }}</a></td></tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">                      <!-- image column -->
    <div class="card">
      <div class="card-header">
        <span class="float-left">
          Images
        </span>
      </div>
      <div class="card-body">
        <div class="row">                         <!-- droid images -->
@include('partials.image', ['photo_name' => 'photo_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'photo_side', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'photo_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
        </div> <!-- end of droid images -->
      </div>
    </div>
  </div> <!-- end of images column -->
</div>

<div class="row mb-5">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        Builders Notes
      </div>
      <div class="card-body">
        <div>
          {!! nl2br(e($droid->notes)) !!}
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        Back Story
      </div>
      <div class="card-body">
        <div>
          {!! nl2br(e($droid->back_story)) !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
