@extends('layouts.app')

@section('content')
<div class="heading mb-5">
    <h1 class="title text-center">Welcome</h1>
</div>

<div class="heading mb-5">
  <a href="{{ route('user.show', Auth::user()->member_uid) }}"><h5 class="title text-center">Your Profile</h1></a>
</div>

@can('View Members')
<div class="heading mb-5">
  <a href="/admin/"><h5 class="title text-center">Admin Dashboard</h1></a>
</div>
@endcan


@endsection
