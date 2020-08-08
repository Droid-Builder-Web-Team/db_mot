@extends('layouts.app')

@section('content')
<div class="heading mb-5">
    <h1 class="title text-center">{{ $droid->name }}</h1>
</div>


@if ($droid->hasValidMOT())
  Valid MOT
  @else
  No valid MOT
@endif
<ul>
    @foreach($droid->users as $user)
    <li>{{ $user->forename }}</li>
    @endforeach
  </ul>

<ul>
    @foreach($droid->mot as $mot)
    <li>{{ $mot->location }} - {{ $mot->date }}</li>
    @endforeach
  </ul>
@endsection
