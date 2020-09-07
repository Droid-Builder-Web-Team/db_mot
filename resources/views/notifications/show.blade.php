@extends('layouts.app')

@section('content')

<div class="container">
  <ul>
    @foreach($notifications as $notification)
      <li>{{ $notification->type }}</li>
    @endforeach
  </ul>
</div>


@endsection
