@extends('layouts.app')

@section('content')
<div class="heading mb-5">
    <h1 class="title text-center">Your Profile</h1>
</div>


<ul>
    @foreach($droid->users as $user)
    <li>{{ $user->forename }}</li>
    @endforeach
  </ul>


@endsection
