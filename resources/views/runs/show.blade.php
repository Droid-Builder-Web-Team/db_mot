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
              <table class="table table-dark table-striped table-sm">
                <tr><th>Droid Name:</th><td>{{ $run->droid->name }}</td></tr>
                <tr><th>First Half Time:</th><td>{{ formatMilliseconds($run->first_half)}}</td></tr>
                <tr><th>Second Half Time:</th><td>{{ formatMilliseconds($run->second_half)}}</td></tr>
                <tr><th>Total Time:</th><td>{{ formatMilliseconds($run->clock_time)}}</td></tr>
                <tr><th>Penalties:</th><td>
                                        @if ($run->num_penalties == 0)
                                            <a class="btn-sm btn-success">{{ $run->num_penalties }}</a>
                                        @elseif ($run->num_penalties == 1)
                                            <a class="btn-sm btn-warning">{{ $run->num_penalties }}</a>
                                        @else
                                            <a class="btn-sm btn-danger">{{ $run->num_penalties }}</a>
                                        @endif
                                    </td></tr>
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

  <div id='app'>
    @include('partials.comments', ['comments' => $run->comments, 'permission' => 'Edit Members', 'model_type' => 'App\CourseRun', 'model_id' => $run->id])
</div>

@endsection
