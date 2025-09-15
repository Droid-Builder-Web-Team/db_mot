@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row d-flex align-items-center">
            <div class="col-sm-2 text-left">
            </div>
              <div class="col-sm-8 text-center">
                  <h4 class="text-center title">{{ __('Ballot Results') }}</h4>
              </div>
              <div class="col-sm-2 text-right">
                <a class="btn btn-primary" href="{{ route('ballots.index') }}">{{ __('Back') }}</a>
            </div>
          </div>
        </div>

        <div class="card-body">

        <h1>Results for: {{ $ballot->title }}</h1>
        <p>This ballot concluded on: {{ $ballot->end_date->format('F j, Y H:i') }}</p>

        @if ($results->isEmpty())
            <p>No votes were cast for this ballot.</p>
        @else
            <table class="table text-center table-striped table-hover table-dark">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Candidate</th>
                        <th>Total Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $index => $result)
                        <tr @if($index === 0) class="winner" @endif>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $candidates[$result->candidate_id]->name }}</td>
                            <td>{{ $result->total_score }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>
    </div>
</div>
</div>


@endsection