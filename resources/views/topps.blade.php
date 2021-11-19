@extends('layouts.topps')
@section('content')

<div class="topps">
  @foreach($droids as $droid)
  <div class="flip-card">
    <div class="flip-card-inner">
      <div class="flip-card-front">
        <img class="lazy" width=240 src="{{ route('image.displayToppsImage', [$droid->id , 'topps_front', 240]) }}" alt="topps_front">
      </div>
      <div class="flip-card-back">
        <img class="lazy" width=240 src="{{ route('image.displayToppsImage', [$droid->id , 'topps_rear', 240]) }}" alt="topps_rear">
      </div>
    </div>
  </div>

  @endforeach
</div>
{{ $droids->links() }}

@endsection