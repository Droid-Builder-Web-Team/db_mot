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
            <h1>{{ $ballot->title }}</h1>
            <p><strong>Voting Period:</strong> {{ $ballot->start_date->format('F j, Y H:i') }} - {{ $ballot->end_date->format('F j, Y H:i') }}</p>

            @if ($hasVoted)
                <div class="message error">
                    You have already cast your vote in this ballot.
                </div>
            @elseif (!$isVotingOpen)
                <div class="message error">
                    Voting is currently closed for this ballot.
                </div>
            @else
                <div class="vote-form">
                    <form action="{{ route('ballots.vote', $ballot) }}" method="POST">
                        @csrf
                        <h3>Your Choices</h3>
                        <p>Rank your top three candidates. First choice gets 3 points, second gets 2, and third gets 1.</p>

                        @if ($errors->any())
                            <div class="message error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="first_choice">First Choice:</label>
                            <select name="first_choice" id="first_choice" required>
                                <option value="">-- Select a Candidate --</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="second_choice">Second Choice:</label>
                            <select name="second_choice" id="second_choice">
                                <option value="">-- Select a Candidate (Optional) --</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="third_choice">Third Choice:</label>
                            <select name="third_choice" id="third_choice">
                                <option value="">-- Select a Candidate (Optional) --</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="vote-button">Cast Vote</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection