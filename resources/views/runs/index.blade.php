@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Course Runs</h2>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-sm">
        <tr>
          <th>Position</th>
          <th>Run Date</th>
          <th>Driver Name</th>
          <th>Droid Name</th>
          <th>First Half</th>
          <th>Second Half</th>
          <th>Clock Time</th>
          <th>Penalties</th>
          <th>Final Time</th>
          <th></th>
        </tr>
        @php $i = 1 @endphp
        @foreach ($runs as $run)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $run->run_timestamp}}</td>
          <td>{{ $run->user->forename}} {{ $run->user->surname}}</td>
          <td>{{ $run->droid->name }}</td>
          <td>{{ formatMilliseconds($run->first_half)}}</td>
          <td>{{ formatMilliseconds($run->second_half)}}</td>
          <td>{{ formatMilliseconds($run->clock_time)}}</td>
          <td>{{ $run->num_penalties }}</td>
          <td>{{ formatMilliseconds($run->final_time)}}</td>
          <td><a class="btn-sm btn-primary" href="{{ route('runs.show', $run->id) }}">View</a></td>
          @php $i++ @endphp
        </tr>
        @endforeach
    </table>

@endsection
