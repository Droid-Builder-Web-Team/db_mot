      <li class="c-header-nav-item dropdown mx-2">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="far fa-bell fa-2x"></i><span class="badge badge-primary badge-pill">
            {{ Auth::user()->unreadNotifications->count() }}
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
          <div class="dropdown-header bg-light">
            <strong>You have {{ Auth::user()->unreadNotifications->count() }} unread notifications</strong>
          </div>

          @foreach(Auth::user()->unreadNotifications as $notification)
            <a class="dropdown-item" href="{{ $notification->data['link'] }}">
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
          <a class="dropdown-item text-center border-top" href="{{ route('notifications')}}">
            View all notifications
          </a>
        </div>
      </li>
