@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
            <div class="col-sm-2 text-left">
                @can('Edit Auction')
                <a class="btn btn-primary" href={{ route('auctions.create') }}>{{ __('Create Auction') }}</a>
                @endcan
            </div>
            <div class="col-sm-8 text-center">
                <h4 class="text-center title">{{ __('Charity Auctions') }}</h4>
            </div>
            <div class="col-sm-2 text-right"></div>
        </div>
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Auction') }}</th>
                    <th scope="col" class="d-none d-md-table-cell">{{ __('Country') }}</th>
                    <th scope="col" class="d-none d-sm-table-cell">{{ __('Current') }}</th>
                    <th>{{ __('Time Left') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auctions as $auction)
                    <tr>
                        <td><a href={{ route('auctions.show', $auction->id) }}>{{ $auction->title }}</a></td>
                        <td scope="col" class="d-none d-md-table-cell">{{ ucwords($auction->country) }}</td>
                        <td scope="col" class="d-none d-sm-table-cell">
                            @if($auction->type == "silent")
                                {{ __('Silent Auction') }}
                            @else
                                {{ $auction->highest()['highest'] }} ({{ strtoupper($auction->currency) }})
                            @endif
                        </td>
                        <td>
                            @if ($auction->secondsLeft() < 0 )
                                {{ __('Finished') }}
                            @else
                                {{$auction->timeLeft()}}
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-view" href={{ route('auctions.show', $auction->id) }}><div class="d-block d-sm-none"><i class="fas fa-eye"></i></div><span class="d-none d-sm-block">View</span></a>
                                @if(Gate::check('Edit Auction') && (Auth()->user()->id == $auction->user_id ))
                                    <a class="btn btn-edit" href={{ route('auctions.edit', $auction->id) }}><div class="d-block d-sm-none"><i class="fas fa-edit"></i></div><span class="d-none d-sm-block">Edit</span></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                These auctions are for charity only. Unless otherwise specified in the auction, the proceeds will go to the current Droidbuilders charity which can be found here: <a target="_default" href="https://droidbuilders.uk/charity">https://droidbuilders.uk/charity</a>
            </div>
        </div>
    </div>
</div>


@endsection