@extends('layouts.app')

@section('content')

<div class="card">
  <div class="card-header">
    <h4 class="title text-center">{{ __('Achievements') }}</h4>
  </div>
  <div class="card-body">
    <div>
      <p>Achievements are a fun way to track certain elements of being a droid builder. This page shows the current list of available achievements, and
        which you have already gained. More details for awarded achievements can be viewed on your profile page</p>
      <p>If you want to claim an achievement or suggest a new one, contact a committee member or MOT officer.</p>
    </div class="table-responsive">
    <table class="table table-striped table-sm table-hover table-dark">
      <tr>
        <th>{{ __('Achievement') }}</th>
        <th>{{ __('Description') }}</th>
        <th>{{ __('Awarded') }}</th>
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
@endsection
