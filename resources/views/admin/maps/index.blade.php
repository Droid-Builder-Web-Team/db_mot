@extends('layouts.app')

@section('content')
<div id='app' style="height: 600px;">

    <members-map
        :markerlist='@json($userlist)'
                    />

</div>

@endsection
