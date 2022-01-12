@extends('layouts.app')

@section('breadcrumbs')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Events</a></li>
        <li class="breadcrumb-item active">Map</li>
    </ol>
</div>
@endsection

@section('content')
<div id='app' style="height: 600px;">

    <members-map
        :markerlist='@json($eventlist)'
                    />

</div>

@endsection
