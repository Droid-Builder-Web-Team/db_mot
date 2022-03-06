@extends('layouts.app')
@section('content')
  @can('Create Partrun')
  <div class="build-section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Your Part Runs</h4>
          <small id="nameHelp" class="form-text text-muted text-center">Part Runs where you are the seller</small>
        </div>
        
          <div class="col-12">
            <div class="buttons">
              <a class="btn btn-create" href={{ route('parts-run.create') }}>Create Run</a>
            </div>
          </div>

        {{-- Table --}}
        <div class="table-responsive">
          <table class="table text-center table-hover">
              <thead>
                  <tr>
                      <th>Part</th>
                      <th class="d-none d-lg-table-cell">Club</th>
                      <th>Status</th>
                      <th>Interest</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($yourPartsRunData as $yourData)
                    @if($yourData->user->id == Auth()->user()->id)
                    <tr>
                        <td>{{ $yourData->partsRunAd->title }}</td>
                        <td class="d-none d-lg-table-cell">{{ $yourData->club->name }}</td>
  
                        <th class="status-class">
                          <div class="status-box">
                          @if($yourData->status == "Active")
                              <div class="pr-circle active"></div><span>&nbsp {{ $yourData->status }}</span>
  
                            @elseif($yourData->status == "Gathering_Interest")
                              <div class="pr-circle interest"></div><span>&nbsp Gathering Interest</span>
  
                            @else
                              <div class="pr-circle inactive"></div><span>&nbsp {{ $yourData->status }}</span>
                          </div>
                          @endif
                        </th>
  
                        <td>{{ $yourData->interest_quantity() }} /
                          @if ($yourData->partsRunAd->quantity == 0)
                            ∞
                          @else
                            {{ $yourData->partsRunAd->quantity }}
                          @endif
                        </td>
                        <td>
                          <div class="d-flex action-buttons">
                            <a class="btn btn-view nm" href={{ route('parts-run.show', $yourData->id) }}></a>
                              @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $yourData->user_id || Auth()->user()->id == $yourData->bc_rep_id))
                                <a class="btn btn-edit nm" href={{ route('parts-run.edit', $yourData->id) }}></a>
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

  <div class="build-section db-mt-2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Active Part Runs</h4>
        </div>
        {{-- Table --}}
        <div class="table-responsive">
          <table class="table text-center table-hover">
              <thead>
                  <tr>
                      <th>Part</th>
                      <th class="d-none d-lg-table-cell">Club</th>
                      <th>Status</th>
                      <th>Interest</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($partsRunData as $data)
                    @if($data->user->id == Auth()->user()->id || Auth::user()->hasRole('BC Rep'))
                    <tr>
                        <td>{{ $data->partsRunAd->title }}</td>
                        <td class="d-none d-lg-table-cell">{{ $data->club->name }}</td>
  
                        <th class="status-class">
                          <div class="status-box">
                          @if($data->status == "Active")
                              <div class="pr-circle active"></div><span>&nbsp {{ $data->status }}</span>
                          @elseif($data->status == "Gathering_Interest")
                              <div class="pr-circle interest"></div><span>&nbsp Gathering Interest</span>
                          @elseif($data->status == "Initial")
                              <div class="pr-circle inactive"></div><span>&nbsp {{ $data->status }}</span>
                          @else
                              <div class="pr-circle inactive"></div><span>&nbsp  $data->status }}</span>
                          </div>
                          @endif
                        </th>
  
                        <td>{{ $data->interest_quantity() }} /
                          @if ($data->partsRunAd->quantity == 0)
                            ∞
                          @else
                            {{ $data->partsRunAd->quantity }}
                          @endif
                        </td>
                        <td>
                          <div class="d-flex action-buttons">
                            <a class="btn btn-view nm" href={{ route('parts-run.show', $data->id) }}></a>
                              @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                                <a class="btn btn-edit nm" href={{ route('parts-run.edit', $data->id) }}></a>
                              @endif
                          </div>
                        </td>
                    </tr>
                    @else
                      @if($data->status != "Initial")
                      <tr>
                        <td>{{ $data->partsRunAd->title }}</td>
                        <td>{{ $data->club->name }}</td>

                        <th class="status-class">
                          <div class="status-box">
                          @if($data->status == "Active")
                              <div class="pr-circle active"></div><span>&nbsp {{ $data->status }}</span>
                          @elseif($data->status == "Gathering_Interest")
                              <div class="pr-circle interest"></div><span>&nbsp Gathering Interest</span>
                          @else
                              <div class="pr-circle inactive"></div><span>&nbsp {{ $data->status }}</span>
                          </div>
                          @endif
                        </th>

                        <td>{{ $data->interest_quantity() }} /
                          @if ($data->partsRunAd->quantity == 0)
                            ∞
                          @else
                            {{ $data->partsRunAd->quantity }}
                          @endif
                        </td>
                        <td>
                          <div class="d-flex action-buttons">
                            <a class="btn btn-view" href={{ route('parts-run.show', $data->id) }}>
                            </a>
                              @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                                <a class="btn btn-edit" href={{ route('parts-run.edit', $data->id) }}>
                                </a>
                              @endif
                          </div>
                        </td>
                    </tr>
                    @endif
                  @endif
                @endforeach
              </tbody>
          </table>
        </div>        
      </div>
    </div>
  </div>

  <div class="build-section text-center page-heading-text d-flex flex-column db-mt-2">
    <h4>Curious about old/ inactive runs? <a class="white-link" href="{{ route('parts-run.none-active-run') }}">Click Here</a> to view them.</h4>
  </div>
@endsection
