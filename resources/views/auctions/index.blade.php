@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
            <div class="col-sm-2 text-left">
                @can('Edit Auction')
                <a class="btn btn-primary" href={{ route('auctions.create') }}>Create Auction</a>
                @endcan
            </div>
            <div class="col-sm-8 text-center">
                <h4 class="text-center title">Charity Auctions</h4>
            </div>
            <div class="col-sm-2 text-right"></div>
        </div>
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
            <thead>
                <tr>
                    <th>Auction</th>
                    <th scope="col" class="d-none d-md-table-cell">Country</th>
                    <th scope="col" class="d-none d-sm-table-cell">Current</th>
                    <th>Time Left</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auctions as $auction)
                    <tr>
                        <td><a href={{ route('auctions.show', $auction->id) }}>{{ $auction->title }}</a></td>
                        <td scope="col" class="d-none d-md-table-cell">{{ ucwords($auction->country) }}</td>
                        <td scope="col" class="d-none d-sm-table-cell">
                            @if($auction->type == "silent")
                                Silent Auction
                            @else
                                {{ $auction->highest()['highest'] }} ({{ strtoupper($auction->currency) }})
                            @endif
                        </td>
                        <td>
                            @if ($auction->secondsLeft() < 0 )
                                Finished
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


@endsection