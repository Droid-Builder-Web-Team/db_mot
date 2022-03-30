@extends('layouts.app')

@section('content')
@can('Edit Partrun')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
          <div class="col-sm-2 text-left">
            @can('Create Partrun')
              <a class="btn btn-primary" href={{ route('parts-run.create') }}>Create Run</a>
            @endcan
          </div>
          <div class="col-sm-8 text-center">
            <h4 class="text-center title">Your Part Runs</h4>
          </div>
          <div class="col-sm-2 text-right"></div>
        </div>
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
            <thead>
                <tr>
                    <th>Part</th>
                    <th scope="col" class="d-none d-md-table-cell">Club</th>
                    <th>Status</th>
                    <th>Interest</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partsRunData as $data)
                @if($data->user->id == Auth()->user()->id || $data->bc_rep_id == Auth()->user()->id)
                <tr>
                    <td>{{ $data->partsRunAd->title }}</td>
                    <td scope="col" class="d-none d-md-table-cell">{{ $data->club->name }}</td>

                    <th class="status-class">
                      <div class="status-box d-flex align-items-center">
                       @if($data->status == "Active")
                          <div class="pr-active"></div><div class="d-none d-sm-block">&nbsp {{ $data->status }}</div>


                        @elseif($data->status == "Gathering_Interest")
                          <div class="pr-interest"></div><div class="d-none d-sm-block">&nbsp Gathering Interest</div>

                        @else
                          <div class="pr-inactive"></div><div class="d-none d-sm-block">&nbsp {{ $data->status }}</div>
                      </div>
                      @endif
                    </th>

                    <td>{{ $data->interestQuantity() }} /
                      @if ($data->partsRunAd->quantity == 0)
                        unlimited
                      @else
                        {{ $data->partsRunAd->quantity }}
                      @endif
                    </td>
                    <td>
                      <div class="d-flex">
                        <a class="btn btn-view" href={{ route('parts-run.show', $data->id) }}><div class="d-block d-sm-none"><i class="fas fa-eye"></i></div><span class="d-none d-sm-block">View</span></a>
                        @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                          <a class="btn btn-edit" href={{ route('parts-run.edit', $data->id) }}><div class="d-block d-sm-none"><i class="fas fa-edit"></i></div><span class="d-none d-sm-block">Edit</span></a>
                        @endif
                      </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endcan

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
          <div class="col-sm-12 text-center">
            <h4 class="text-center title">Part Runs</h4>
          </div>
        </div>
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
            <thead>
                <tr>
                    <th>Part</th>
                    <th scope="col" class="d-none d-md-table-cell">Club</th>
                    <th scope="col" class="d-none d-sm-table-cell">Seller</th>
                    <th>Status</th>
                    @role("Super Admin")
                        <th scope="col" class="d-none d-md-table-cell">Quantity</th>
                    @endrole
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partsRunData as $data)
                @if($data->status != "Initial" && $data->status != "Inactive")
                <tr>
                    <td>{{ $data->partsRunAd->title }}</td>
                    <td scope="col" class="d-none d-md-table-cell">{{ $data->club->name }}</td>
                    <td scope="col" class="d-none d-sm-table-cell">{{ $data->user->forename }} {{ $data->user->surname }}</td>

                    <th class="status-class">
                      <div class="status-box d-flex align-items-center">
                       @if($data->status == "Active")
                          <div class="pr-active"></div><div class="d-none d-sm-block">&nbsp{{ $data->status }}</div>


                        @else($data->status == "Gathering_Interest")
                          <div class="pr-interest"></div><div class="d-none d-sm-block">&nbsp Gathering Interest</div>
                      </div>
                      @endif
                    </th>
                    @role("Super Admin")
                    <td>{{ $data->interestQuantity() }} /
                        @if ($data->partsRunAd->quantity == 0)
                          unlimited
                        @else
                          {{ $data->partsRunAd->quantity }}
                        @endif
                      </td>
                        @endrole
                        <td>
                      <div class="d-flex">
                        <a class="btn btn-view" href={{ route('parts-run.show', $data->id) }}><div class="d-block d-sm-none"><i class="fas fa-eye"></i></div><span class="d-none d-sm-block">View</span></a>
                        @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                          <a class="btn btn-edit" href={{ route('parts-run.edit', $data->id) }}><div class="d-block d-sm-none"><i class="fas fa-edit"></i></div><span class="d-none d-sm-block">Edit</span></a>
                        @endif
                      </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
