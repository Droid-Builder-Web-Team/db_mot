
<li class="nav-item dropdown">
  <a class="header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <div class="avatar">
      {{-- <img class="avatar-img" src="{{ route('image.displayMugShot',[Auth::user()->id, '240']) }}" alt="{{Auth::user()->email }}"> --}}
      <i class="far fa-user"></i>
    </div>
  </a>
  <div class="dropdown-menu dropdown-menu-right pt-0">
    <div class="dropdown-header bg-light py-2">
      <strong>{{ Auth::user()->forename }} {{Auth::user()->surname }}</strong>
    </div>
    <a class="dropdown-item" href="{{ route('settings.edit', Auth::user()->id) }}">
      <i class="fas fa-cog fa-fw"></i> Preferences
    </a>
    <a class="dropdown-item" href="{{ route('change.password') }}">
      <i class="fas fa-key fa-fw"></i> Change Password
    </a>
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
      <i class="fas fa-sign-out-alt fa-fw"></i> Logout
    </a>
  </div>
</li>
