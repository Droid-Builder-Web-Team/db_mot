@extends('layouts.app')

@section('content')
<div class="row">
    <div class="page-heading-text">
        
    </div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
          <div class="col-sm-12 text-center">
            <a class="btn-sm btn-primary" href="{{ url()->previous() }}">Back</a>
            <h4 class="text-center title">Inactive Part Runs</h4>
          </div>
        </div>
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
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
                      <div class="d-flex">
                        <a class="btn btn-view" href={{ route('parts-run.show', $data->id) }}>View</a>
                        @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                          <a class="btn btn-edit" href={{ route('parts-run.edit', $data->id) }}>Edit</a>
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
