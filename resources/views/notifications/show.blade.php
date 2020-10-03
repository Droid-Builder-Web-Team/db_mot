@extends('layouts.app')

@section('content')

    @foreach($notifications as $notification)
    <a href="{{ $notification->data['link'] }}">
    <div class="row no-gutters align-items-center">
      <div class="col-md-1">
          <i class="fas fa-{{ $notification->data['icon'] ?? "clock" }} fa-fw"></i>
      </div>
      <div class="col-md-11">
    <div class="message">
      <div class="row no-gutters">
          <div class="col-auto mr-auto">
              {{ $notification->data['title'] }}
          </div>
          <div class="auto">
              <small class="text-muted mt-1 text-right text-truncate">{{ $notification->created_at->diffForHumans() }}</small>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12 text-muted" style="overflow: hidden;">
              {{ $notification->data['text'] }}
          </div>
      </div>
    </div>
  </div>
</div>
</a>
    @endforeach


@endsection
