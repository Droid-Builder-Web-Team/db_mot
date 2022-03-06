@extends('layouts.app')
@section('content')
<div class="build-section">
  <div class="container-fluid">
    <div class="row text-center">
      <div class="col-12">
        <h4>Club MOT Details</h4>
      </div>

      <div class="col-12">
        <ul class="blank-ul">
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
