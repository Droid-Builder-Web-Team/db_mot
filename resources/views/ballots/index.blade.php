@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row d-flex align-items-center">
              <div class="col-sm-2 text-left">
                  @can('Edit Auction')
                  <a class="btn btn-primary" href={{ route('admin.ballots.create') }}>{{ __('Create Ballot') }}</a>
                  @endcan
              </div>
              <div class="col-sm-8 text-center">
                  <h4 class="text-center title">{{ __('Ballots') }}</h4>
              </div>
              <div class="col-sm-2 text-right"></div>
          </div>
        </div>
        <div class="card-body">
        @if ($ballots->isEmpty())
            <p>There are no ballots available at this time.</p>
        @else
            <div class="table text-center table-striped table-hover table-dark">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Voting Period</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ballots as $ballot)
                            @php
                                $now = now();
                                $hasVoted = Auth::check() && $ballot->voterLogs->contains('user_id', Auth::id());
                                $isVotingActive = $now->between($ballot->start_date, $ballot->end_date) && $ballot->is_active;
                                $isVotingCompleted = $now->greaterThan($ballot->end_date) && !$isVotingActive;
                            @endphp
                            <tr>
                                <td>{{ $ballot->title }}</td>
                                <td>{{ $ballot->start_date->format('Y-m-d H:i') }} - {{ $ballot->end_date->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if ($isVotingActive)
                                        <span class="status active">Active</span>
                                    @elseif ($isVotingCompleted)
                                        <span class="status completed">Completed</span>
                                    @else
                                        <span class="status">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($isVotingActive && !$hasVoted)
                                        <a class="btn btn-success" href="{{ route('ballots.show', $ballot) }}" class="vote-link">Vote</a>
                                    @elseif ($isVotingCompleted)
                                        <a class="btn btn-info" href="{{ route('ballots.results', $ballot) }}" class="results-link">Results</a>
                                    @else
                                        <span style="color: #6c757d;">
                                            @if($hasVoted)
                                                You have voted
                                            @else
                                                Not open
                                            @endif
                                        </span>
                                    @endif
                                    @can('Edit Ballot')
                                    <form action="{{ route('admin.ballots.destroy', $ballot) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" class="delete-btn">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        </div>
      </div>
    </div>
  </div>
  

@endsection