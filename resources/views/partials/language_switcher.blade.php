

<li class="c-header-nav-item dropdown mx-2">
    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fi fi-{{ $current_locale }}"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right pt-0">
    @foreach($available_locales as $locale_name => $available_locale)
      <a class="dropdown-item" href="/language/{{ $available_locale }}">
        <i class="fi fi-{{ $available_locale }}"></i>{{ $locale_name }}
      </a>
    @endforeach
    </div>
</li>