@extends('layouts.app')

@section('content')

<nav class="nav nav-pills nav-justified">
  @foreach($clubs as $club)
    <a class="nav-item nav-link" href="#">{{$club->name}}</a>
  @endforeach
</nav>


@endsection
