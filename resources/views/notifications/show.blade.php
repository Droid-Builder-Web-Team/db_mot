@extends('layouts.app')

@section('content')

<div class="container">
  <ul>
    @foreach($notifications as $notification)
      <li>{{ $notification->created_at }} - <a href="{{ $notification->data['link'] }}">{{ $notification->data['title'] }}</a></li>
    @endforeach
  </ul>
</div>


@endsection
