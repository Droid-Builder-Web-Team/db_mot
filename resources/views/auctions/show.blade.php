@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
            <div class="col-sm-2 text-left">
                @can('Edit Auction')
                <a class="btn btn-primary" href={{ route('auctions.edit', $auction->id) }}>Edit Auction</a>
                @endcan
            </div>
            <div class="col-sm-8 text-center">
                <h4 class="text-center title">{{$auction->title}}</h4>
            </div>
            <div class="col-sm-2 text-right">
              <a class="btn btn-primary" href="{{ route('auctions.index') }}">Back</a>
            </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div id="event_description">{!! $auction->description !!}</div>
          </div>
        </div>
      
        @if ($auction->secondsLeft() < 0)
          <div class="row">
            <div class="col-md-12">
              <h2>Auction Has Finished</h2>
            </div>
          </div>
        @else
          <div class="row">
            <div class="col-md-12">
              <b>Auction Finishes at:</b> {{ Carbon\Carbon::parse($auction->finish_time) }} (Timezone: {{$auction->timezone}})
              <br />
              <b>Time Left:</b> {{ $auction->timeLeft() }}
            </div>
          </div>
        @endif

        <div class="row">
          <div class="col-md-12">
            @if ($auction->type == "silent")
              This is a <b>Silent</b> Auction. Current Winning Bid is not shown. 
              @can('Edit Auction')
                <br />
                <br />
                Admin eyes only: <b>Current Winning Bid:</b> {{ $auction->highest()['highest'] }} ({{ strtoupper($auction->currency) }}) 
              @endcan
            @else
              <b>Current Winning Bid:</b> {{ $auction->highest()['highest'] }} ({{ strtoupper($auction->currency) }})
            @endif

            @can('Edit Auction')
              <br />
              @if ($auction->highest()['highest'] != 0)
                Admin eyes only: Current winner is ({{$auction->highest()['user']->forename}} {{$auction->highest()['user']->surname}})
              @endif
            @endcan
          </div>
        </div>

        @if ($auction->secondsLeft() > 0)
        <div class="row">
          <div class="col-md-12">
            <br />
            <br />
            <form action="{{ route('auctions.bid', $auction->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type=hidden name="user_id" value="{{ Auth::user()->id }}">
              <div class="form-group">
                  <strong>Bid:</strong>
                  @if ($auction->type != "silent")
                    <input type="number" name="amount" size=6 min="{{$auction->highest()['highest'] + 1 }}" value="{{$auction->highest()['highest'] + 1 }}" max=999999>
                  @else
                    <input type="number" name="amount" size=6 min="{{Auth::user()->highestBid($auction) + 1 }}" value="{{Auth::user()->highestBid($auction) + 1 }}" max=999999>
                  @endif
                  <input type="submit" name="submit" value="Place Your Bid!">
                  (Current Bid: {{ Auth::user()->highestBid($auction)}})
              </div>

            </form>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
<div id='app'>
    @include('partials.comments', ['comments' => $auction->comments, 'permission' => 'Edit Auction', 'model_type' => 'App\Models\Auction', 'model_id' => $auction->id])
</div>

@endsection