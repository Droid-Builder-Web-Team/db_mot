      <li class="c-header-nav-item dropdown mx-2">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="far fa-bell fa-2x"></i><span class="badge badge-primary badge-pill">
            {{ Auth::user()->unreadNotifications->count() }}
          </span>
        </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg  d-md-down-none pt-0">
      <div class="dropdown-header bg-light">
        <strong>You have {{ Auth::user()->unreadNotifications->count() }} unread notifications</strong>
      </div>

@foreach(Auth::user()->unreadNotifications as $notification)
      <a class="dropdown-item" href="{{ $notification->data['link'] }}">
        <div class="message">
          <div>
            <small class="text-muted float-right mt-1">{{ $notification->created_at }}</small>
          </div>
          <div class="font-weight-bold">
            {{ $notification->data['title'] }}
          </div>
          <div class="small text-muted">
            {{ $notification->data['text'] }}
          </div>
        </div>
      </a>
@endforeach
