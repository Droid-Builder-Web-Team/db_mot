@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <span class="float-left">{{ $run->user->forename}} {{ $run->user->surname}}</span>
          <span class="float-right">Final Time: {{ formatMilliseconds($run->final_time)}}</span>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <table class="table table-striped table-sm">
                <tr><th>Droid Name:</th><td>{{ $run->droid->name }}</td></tr>
                <tr><th>First Half Time:</th><td>{{ formatMilliseconds($run->first_half)}}</td></tr>
                <tr><th>Second Half Time:</th><td>{{ formatMilliseconds($run->second_half)}}</td></tr>
                <tr><th>Total Time:</th><td>{{ formatMilliseconds($run->clock_time)}}</td></tr>
                <tr><th>Penalties:</th><td>{{ $run->num_penalties }}</td></tr>
              </table>
            </div>
            <div class="col-md-4">
          	   <img src="{{ route('image.displayMugShot',[$run->user->id, '240']) }}" alt="mug_shot" class="img-fluid mb-1 rounded">
            </div>
            <div class="col-md-4">
              <img src="{{ route('image.displayDroidImage',[$run->droid->id, 'photo_front', '240']) }}" alt="droid_front" class="img-fluid mb-1 rounded">
            </div>
          </div>
          <a class="btn-sm btn-primary" href="{{ route('runs.index') }}">Back</a>
        </div>
      </div>
    </div>
  </div>

@endsection
