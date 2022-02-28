@extends('layouts.app')
@section('content')
<div class="build-section">
  <div class="container-fluid">
    <div class="row db-mb-2">
      <div class="col-12 col-lg-12 build-section d-block">
        <div class="droid-view-col db-mb-2">
          <div class="droid-name">
            <h4>{{ $droid->name }}</h4>
          </div>

          <div class="profile-toggle">
            {{ $droid->club->name }}
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="publicToggle" value="{{$droid->public}}"
              {{ $droid->public === 1 ? 'checked' : '' }}>
              <label class="custom-control-label" for="publicToggle">Public Profile</label>
            </div>
          </div>
        </div>

        <h5 class="text-center db-mb-1">Droid Images</h5>
        <div class="row images-row">
            @include('partials.image', ['photo_name' => 'photo_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
            @include('partials.image', ['photo_name' => 'photo_side', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
            @include('partials.image', ['photo_name' => 'photo_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
        </div>
      </div>
    </div>

    <div class="row build-section">
      <div class="col-12">
        <div class="table-responsive">
          <table class="table table-striped table-sm table-hover table-dark">
            <tr>
              <th>Owner</th>
              <td>
                @foreach ( $droid->users as $users )
                  <a href="{{ route('user.show',$users->id) }}">{{ $users->forename }} {{ $users->surname }}</a><br>
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
            <tr><th>Approx Value</th><td>{{ $droid->value }}</td></tr>
            <tr><th>Build Log</th><td><a target="_blank" href="{{ $droid->build_log }}">{{ $droid->build_log }}</a></td></tr>
            @if ($droid->club->hasOption('tier_two'))
              <tr><th>Tier 2</th><td>{{ $droid->tier_two }}</td></tr>
            @endif
            @if ($droid->club->hasOption('topps'))
              @if ($droid->topps_id != null)
                <tr><th>Topps Number</th><td>{{ $droid->topps_id }}</td></tr>
                @endif
            @endif
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
