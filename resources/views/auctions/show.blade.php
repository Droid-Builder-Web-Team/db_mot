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
            <div class="col-sm-2 text-right"></div>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div id="event_description">{!! $auction->description !!}</div>
          </div>
        </div>
      
        <div class="row">
          <div class="col-md-12">
            <b>Auction Finishes at:</b> {{$auction->finish_time}} (Timezone: {{$auction->timezone}})
          </div>
        </div>

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
              Admin eyes only: Current winner is ({{$auction->highest()['user']->forename}} {{$auction->highest()['user']->surname}})
            @endcan
          </div>
        </div>

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
                  <input type="number" name="amount" size=10>
                  <input type="submit" name="submit" value="Place Your Bid!">
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection