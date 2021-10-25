@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
          <div class="col-sm-2 text-left">
            @role('Super Admin')
              <a class="btn btn-primary" href={{ route('part-runs.create') }}>Create Run</a>
            @endrole
          </div>
          <div class="col-sm-8 text-center">
            <h4 class="text-center title">Part Runs</h4>
          </div>
          <div class="col-sm-2 text-right"></div>
        </div>
        
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
            <thead>
                <tr>
                    <th>Part</th>
                    <th>Club</th>
                    <th>Seller</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partsRunData as $data)
                <tr>
                    <td>{{ $data->partsRunAd->title }}</td>
                    <td>{{ $data->club->name }}</td>
                    <td>{{ $data->user->username }}</td>

                    <th class="status-class">
                      <div class="status-box d-flex align-items-center">
                       @if($data->status == "Active")
                          <div class="pr-active"></div>
                        <p>{{ $data->status }}</p>
                      

                        @elseif($data->status == "Gathering_Interest")
                          <div class="pr-interest"></div>
                        <p>{{ $data->status }}</p>

                        @else
                          <div class="pr-inactive"></div>
                        <p>{{ $data->status }}</p>
                      </div>
                      @endif
                    </th>

                    <td>
                      <div class="d-flex">
                        <a class="btn btn-view" href={{ route('part-runs.show', $data->id) }}>View</a>
                        <a class="btn btn-edit" href={{ route('part-runs.edit', $data->id) }}>Edit</a>
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
