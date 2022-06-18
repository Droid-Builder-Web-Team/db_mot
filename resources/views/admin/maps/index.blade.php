@extends('layouts.app')

@section('content')
<div id='app' style="height: 1000px;">

    <map-component
        :markerlist='@json($userlist)'
                    />

</div>

@endsection
