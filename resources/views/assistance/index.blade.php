@extends('layouts.app')

@section('content')

<div class="card">
  <div class="card-header">
    <h4 class="title text-center">Assistance Requests</h4>
  </div>
  <div class="card-body">
    <div class="row text-center">
        <div class="col-6">
            <button type="button" class="btn btn-default">Request Assistance</button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-default">Offer Assistance</button>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped table-sm table-hover table-dark">
            <tr>
              <th>Requester</th>
              <th>Title</th>
              <th>Type</th>
              <th>Material</th>
            </tr>
            @foreach($assistances as $assistance)
              <tr>
                <td>{{$assistance->user->forename}} {{$assistance->user->surname}}</td>
                <td>{{$assistance->title}}</td>
                <td>{{$assistance->type->name}}</td>
                <td>{{$assistance->material->name}}</td>
              </tr>
            @endforeach
          </table>
    </div>
    <div class="row">
        Please note, this service is not for requesting a full droid build or anything like that. It is if you have a random request for a part or two that you are unable to get
        hold of via part runs, etc. It is also not for people to run a business producing parts. It is purely a match making system to help builders out with their droid.
    </div>
  </div>
</div>
@endsection
