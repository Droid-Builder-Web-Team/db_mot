@extends('layouts.app')
@section('content')
  <div class="build-section text-center page-heading-text d-flex flex-column db-mb-2">
    <div class="container fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="text-uppercase db-mb-1 d-flex align-items-center justify-content-center">Inactive Parts Run</h4>
          <p>These runs are not currently active however hey may become active in the future.</p>
        </div>

        <div class="col-12">
          <div class="buttons">
            <a class="btn btn-back" href="{{ url()->previous() }}">Back</a>
          </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive ">
          <table class="table text-center table-hover">
            <thead>
              <tr>
                  <th>Part</th>
                  <th>Club</th>
                  <th>Seller</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($inactivePartsRunData as $data)
                @if($data->status != "Initial")
                <tr>
                    <td>{{ $data->partsRunAd->title }}</td>
                    <td>{{ $data->club->name }}</td>
                    <td>{{ $data->user->forename }} {{ $data->user->surname }}</td>

                    <td>
                      <div class="d-flex action-buttons">
                        <a class="btn btn-view" href={{ route('parts-run.show', $data->id) }}>
                          <i class="fas fa-eye"></i>
                        </a>
                          @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                            <a class="btn btn-edit" href={{ route('parts-run.edit', $data->id) }}>
                              <i class="fas fa-edit"></i>
                            </a>
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
