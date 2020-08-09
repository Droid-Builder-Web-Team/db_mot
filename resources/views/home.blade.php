@extends('layouts.app')

@section('content')
<div class="heading mb-5">
    <h1 class="title text-center">Welcome</h1>
</div>


@can('View Members')
<div class="heading mb-5">
  <a href="/admin/"><h5 class="title text-center">Admin Dashboard</h1></a>
</div>
@endcan


@endsection
