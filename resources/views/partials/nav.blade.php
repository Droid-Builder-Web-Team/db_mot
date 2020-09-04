<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
  <div class="c-sidebar-brand d-md-down-none">
    {{ config('app.name', 'Laravel') }}
  </div>
  <ul class="c-sidebar-nav">
@guest
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
    </li>
  @if (Route::has('register'))
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
    </li>
  @endif
@else

    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('user.show', Auth::user()->id ) }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-user-circle fa-fw"></i>
        </svg><span class="ml-1">Your Profile</span>
      </a>
    </li>
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('event.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-calendar fa-fw"></i>
        </svg><span class="ml-1">Upcoming Events</span>
      </a>
    </li>
  @hasanyrole('Super Admin|Org Admin|Events Officer|MOT Officer')
    <li class="c-sidebar-nav-title">Admin</li>


    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('admin.dashboard.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-tachometer-alt fa-fw"></i>
        </svg><span class="ml-1">Dashboard</span>
      </a>
    </li>
    @endhasanyrole

    @can('View Members')
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-users fa-fw"></i>
        </svg><span class="ml-1">Members</span>
      </a>
    </li>
    @endcan
    @can('View Droids')
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('admin.droids.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-robot fa-fw"></i>
        </svg><span class="ml-1">Droids</span>
      </a>
    </li>
    @endcan
    @can('Edit Events')
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('admin.events.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-calendar fa-fw"></i>
        </svg><span class="ml-1">Events</span>
      </a>
    </li>
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('admin.locations.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-map-marker fa-fw"></i>
        </svg><span class="ml-1">Locations</span>
      </a>
    </li>
    @endcan
    @can('Edit Achievements')
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('admin.achievements.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-trophy fa-fw"></i>
        </svg><span class="ml-1">Achievements</span>
      </a>
    </li>
    @endcan
    @can('Edit Clubs')
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('admin.clubs.index') }}">
        <svg class="c-sidebar-nav-icon">
          <i class="fas fa-cubes fa-fw"></i>
        </svg><span class="ml-1">Clubs</span>
      </a>
    </li>
    <li class="c-sidebar-nav-item"></li>
    @endcan
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <svg class="c-sidebar-nav-icon">
            <i class="fas fa-sign-out-alt fa-fw"></i>
          </svg><span class="ml-1">{{ __('Logout') }}</span>
      </a>
    </li>
@endguest
  </ul>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
</div>
