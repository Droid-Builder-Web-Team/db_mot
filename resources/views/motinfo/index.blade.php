@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">MOT Info</h4>
      </div>
      <div class="card-body">
        <ul>
          @foreach($clubs as $club)
            @if($club->hasOption('mot'))
              <li><a href="{{ route('motinfo.show',$club->id) }}">{{ $club->name }}</a></li>
            @endif
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
