@extends('layouts.app')
@section('content')
<div class="build-section">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 text-center">
        <h4 class="text-uppercase">Achievements</h4>
        <p class="db-my-2">
          Achievements are a fun way to track certain elements of being a droid builder. This page shows the current list of available achievements, and
          which you have already gained. More details for awarded achievements can be viewed on your profile page
        </p>
        <p>If you want to claim an achievement or suggest a new one, contact a committee member or MOT officer.</p>
      </div>

      <div class="table-responsive">
        <table class="table text-center table-hover">
          <tr>        
            <th>Achievement</th>
            <th>Description</th>
            <th>Awarded</th>
          </tr>
          @foreach($achievements as $achievement)
            <tr>
              <td>{{$achievement->name}}</td>
              <td>{{$achievement->description}}</td>
              <td>
                @if(Auth::user()->hasAchievement($achievement))
                <i class="fas fa-check"></i>
                @endif
              </td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
