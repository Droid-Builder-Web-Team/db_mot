@extends('layouts.app')

@section('content')
<div class="row">
  <div class="heading mb-4">
    <h1 class="title text-center">{{ $droid->name }}</h1>
  </div>
</div>
<div class="row">
  <table class="table col-md-6 mb-4">
    <tr>
      <th>Owner</th><td>
        @foreach ( $droid->users as $users )
          <a href="{{ route('user.show',$users->member_uid) }}">{{ $users->forename }} {{ $users->surname }}</a><br>
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
      <th>Active</th><td>{{ $droid->active }}</td></tr>
    </tr>
  </table>
  <div class="col-md-6">
    <div class="droid-card-content">
      <div style="text-align:center">
				<img src="{{ route('image.displayDroidImage', [$droid->droid_uid, 'photo_front']) }}" alt="droid_front" class="img-fluid mb-1 rounded" style="height:300px;">
			</div>
			<div class="droid-card-table" style="z-index:2">
				<div class="droid-card-row">
					<div class="droid-card-center noclick">
						<h2 style="margin-bottom:0px">Front</h2>
					</div>
				</div>
			</div>
      <div style="text-align:center">
				<img src="{{ route('image.displayDroidImage', [$droid->droid_uid, 'photo_side']) }}" alt="droid_side" class="img-fluid mb-1 rounded" style="height:300px;">
			</div>
			<div class="droid-card-table" style="z-index:2">
				<div class="droid-card-row">
					<div class="droid-card-center noclick">
						<h2 style="margin-bottom:0px">Front</h2>
					</div>
				</div>
			</div>
      <div style="text-align:center">
				<img src="{{ route('image.displayDroidImage', [$droid->droid_uid, 'photo_rear']) }}" alt="droid_rear" class="img-fluid mb-1 rounded" style="height:300px;">
			</div>
			<div class="droid-card-table" style="z-index:2">
				<div class="droid-card-row">
					<div class="droid-card-center noclick">
						<h2 style="margin-bottom:0px">Front</h2>
					</div>
				</div>
			</div>
    </div>
  </div>
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
      </tr>
      @foreach($droid->mot as $mot)
        <tr>
          <td>{{ $mot->date }}</td>
          <td>{{ $mot->location }}</td>
          <td></td>
          <td>{{ $mot->approved }}</td>
        </tr>
      @endforeach
    </table>
  </div>
  <div class="col-md-6">
    Officer Comments
    <table class="table">

    </table>
  </div>
  @endif
</div>
@endsection
