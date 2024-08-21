@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Fastest Course Runs</h2>
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
        @foreach ($fastestTimes as $run)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $run->run_timestamp}}</td>
          <td>{{ $run->user->forename}} {{ $run->user->surname}}</td>
          <td>{{ $run->droid->name }}</td>
          <td>{{ formatMilliseconds($run->first_half)}}</td>
          <td>{{ formatMilliseconds($run->second_half)}}</td>
          <td>{{ formatMilliseconds($run->clock_time)}}</td>
          <td>
                                        @if ($run->num_penalties == 0)
                                            <a class="btn-sm btn-success">{{ $run->num_penalties }}</a>
                                        @elseif ($run->num_penalties == 1)
                                            <a class="btn-sm btn-warning">{{ $run->num_penalties }}</a>
                                        @else
                                            <a class="btn-sm btn-danger">{{ $run->num_penalties }}</a>
                                        @endif
                                    </td>
          <td>{{ formatMilliseconds($run->final_time)}}</td>
          <td><a class="btn-sm btn-primary" href="{{ route('runs.show', $run->id) }}">View</a></td>
          @php $i++ @endphp
        </tr>
        @endforeach
    </table>

@endsection
