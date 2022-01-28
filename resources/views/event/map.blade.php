@extends('layouts.app')

@section('content')
<div id='app' style="height: 600px;">

    <map-component
        :markerlist='@json($eventlist)'
                    />

</div>

@endsection
