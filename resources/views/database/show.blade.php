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
            <th>{{ __('Owner') }}</th>
            <td>
              @foreach ( $droid->users as $users )
                {{ $users->forename }} {{ $users->surname }}<br>
              @endforeach
            </td>
          </tr>
          <tr><th>{{ __('Type') }}</th><td>{{ $droid->type }}</td></tr>
          <tr><th>{{ __('Style') }}</th><td>{{ $droid->style }}</td></tr>
          <tr><th>Radio Controlled?</th><td>{{ $droid->radio_controlled }}</td></tr>
          <tr><th>{{ __('Transmitter Type') }}</th><td>{{ $droid->transmitter_type }}</td></tr>
          <tr><th>{{ __('Material') }}</th><td>{{ $droid->material }}</td></tr>
          <tr><th>{{ __('Approximate Weight') }}</th><td>{{ $droid->weight }}</td></tr>
          <tr><th>{{ __('Battery Type') }}</th><td>{{ $droid->battery }}</td></tr>
          <tr><th>{{ __('Drive Voltage') }}</th><td>{{ $droid->drive_voltage }}</td></tr>
          <tr><th>{{ __('Drive Type') }}</th><td>{{ $droid->drive_type }}</td></tr>
          <tr><th>{{ __('Top Speed') }}</th><td>{{ $droid->top_speed }}</td></tr>
          <tr><th>{{ __('Sound System') }}</th><td>{{ $droid->sound_system }}</td></tr>
          <tr><th>{{ __('Build Log') }}</th><td><a target="_blank" href="{{ $droid->build_log }}">{{ $droid->build_log }}</a></td></tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">                      <!-- image column -->
    <div class="card">
      <div class="card-header">
        <span class="float-left">
          {{ __('Images') }}
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
        {{ __('Builder Notes') }}
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
        {{ __('Back Story') }}
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
