@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="text-center title">Part Runs</h4>
        <a class="btn btn-primary" href={{ route('part-runs.create') }}>Create Run</a>
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
            <thead>
                <tr>
                    <th>Part</th>
                    <th>Droid</th>
                    <th>Seller</th>
                    <th>Active/ Inactive</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partsRunData as $data)
                <tr>
                    <td>{{ $data->partsRunAd->title }}</td>
                    <td>{{ $data->club->name }}</td>
                    <td>{{ $data->user->username }}</td>
                    @if($data->status = "Active")
                    <th class="status-class">
                      <div class="pr-active"></div>
                      {{ $data->status }}
                    </th>
                    @elseif($data->status = "Gathering_Interest")
                    <th class="status-class">
                      <div class="pr-interest"></div>
                      {{ $data->status }}
                    </th>
                    @else
                    <th class="status-class">
                      <div class="pr-inactive"></div>
                      {{ $data->status }}
                    </th>
                    @endif
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
