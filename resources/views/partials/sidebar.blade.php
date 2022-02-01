<div class="db-sidebar wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        <a class="p-link" href="{{ route('about') }}">
            <h4 class="large-menu-title logo">{{ config('app.name', 'Laravel') }}</h4>
            <h4 class="small-menu-title logo">DB Portal</h4>
        </a>

        <ul class="sidebar-nav">
            @guest
                <li class="sidebar-nav-item">
                    <a class="sidebar-nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="sidebar-nav-item">
                        <a class="sidebar-nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
            {{-- Club Functions --}}
            <li class="sidebar-nav-title" data-toggle="collapse" data-target="#club-functions">Club Functions</li>
            <div class="nav-group collapse" id="club-functions">
                <li class="sidebar-nav-item">
                    <a class="sidebar-nav-link" href="{{ route('user.show', Auth::user()->id) }}">
                        <span class="fas fa-user-circle fa-fw"></span>
                            Profile
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a class="sidebar-nav-link" href="{{ route('event.index') }}">
                        <span class="fas fa-calendar fa-fw"></span>
                        Upcoming Events
                    </a>
                </li>

                @if(config('features.partrun', FALSE))
                    <li class="sidebar-nav-item">
                        <a class="sidebar-nav-link" href="{{ route('parts-run.index') }}">
                            <span class="fas fa-wrench fa-fw"></span>
                            Part Runs
                        </a>
                    </li>
                @endif
            </div>

            <div class="divider"></div>
                
                {{-- Info --}}
                <li class="sidebar-nav-title" data-toggle="collapse" data-target="#info">Info</li>
                    <div class="nav-group collapse" id="info">
                        <li class="sidebar-nav-item">
                            <a class="sidebar-nav-link" href="{{ route('motinfo.index') }}">
                                <span class="fas fa-info-circle fa-fw"></span>
                                MOT Info
                            </a>
                        </li>
            
                        <li class="sidebar-nav-item">
                            <a class="sidebar-nav-link" target="_blank" href="https://robsrobots.co.uk/guides.php">
                                <span class="fas fa-tools fa-fw"></span>
                                Builders Guides
                            </a>
                        </li>
            
                        <li class="sidebar-nav-item">
                            <a class="sidebar-nav-link" target="_blank" href="https://wiki.droidbuilders.net/">
                                <span class="fab fa-wikipedia-w fa-fw"></span>
                                Droidbuilders Wiki
                            </a>
                        </li>
                        @if(config('features.partrun', TRUE))
                            <li class="sidebar-nav-item">
                                <a class="sidebar-nav-link" href="{{ route('partsRunInfo') }}">
                                    <span class="fas fa-list fa-fw"></span>
                                    Parts Runs
                                </a>
                            </li>
                        @endif
            
                        <li class="sidebar-nav-item">
                            <a class="sidebar-nav-link" href="{{ route('topps') }}">
                                <span class="fas fa-grip-horizontal fa-fw"></span>
                                Topps Cards
                            </a>
                        </li>
            
                        <li class="sidebar-nav-item">
                            <a class="sidebar-nav-link" href="{{ route('about') }}">
                                <span class="fas fa-info fa-fw"></span>
                                About Us
                            </a>
                        </li>
                    </div>
                <div class="divider"></div>

                {{-- Admin --}}
                @hasanyrole('Super Admin|Org Admin|Events Officer|MOT Officer')
                    <li class="sidebar-nav-title" data-toggle="collapse" data-target="#admin" aria-expanded="false">Admin</li>
                        <div class="nav-group collapse" id="admin">
                            <li class="sidebar-nav-item">
                                <a class="sidebar-nav-link" href="{{ route('admin.dashboard.index') }}">
                                    <span class="fas fa-tachometer-alt fa-fw"></span>
                                    Dashboard
                                </a>
                            </li>

                            @can('View Members')
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.users.index') }}">
                                        <span class="fas fa-users fa-fw"></span>
                                        Members
                                    </a>
                                </li>
                            @endcan

                            @can('View Droids')
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.droids.index') }}">
                                        <span class="fas fa-robot fa-fw"></span>
                                        Droids
                                    </a>
                                </li>
                            @endcan

                            @can('Edit Members')
                            <li class="sidebar-nav-item">
                                <a class="sidebar-nav-link" href="{{ route('admin.map.index') }}">
                                    <span class="fas fa-map-marked-alt fa-fw"></span>
                                    Members Map
                                </a>
                            </li>
                            @endcan

                            @can('Edit Events')
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.events.index') }}">
                                        <span class="fas fa-calendar fa-fw"></span>
                                        Events
                                    </a>
                                </li>
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.locations.index') }}">
                                        <span class="fas fa-map-marker fa-fw"></span>
                                        Locations
                                    </a>
                                </li>
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.contacts.index') }}">
                                        <span class="fas fa-user fa-fw"></span>
                                        Contacts
                                    </a>
                                </li>
                            @endcan

                            @can('Edit Achievements')
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.achievements.index') }}">
                                        <span class="fas fa-trophy fa-fw"></span>
                                            Achievements
                                    </a>
                                </li>
                            @endcan

                            @can('Edit Clubs')
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.clubs.index') }}">
                                        <span class="fas fa-cubes fa-fw"></span>
                                        Clubs
                                    </a>
                                </li>
                            @endcan

                            @hasanyrole('Super Admin|Org Admin')
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.audits.index') }}">
                                        <span class="fas fa-file-contract fa-fw"></span>
                                        Audit
                                    </a>
                                </li>
                            @endhasanyrole

                            @hasanyrole('Super Admin')
                                <li class="sidebar-nav-item">
                                    <a class="sidebar-nav-link" href="{{ route('admin.logs.index') }}">
                                        <span class="fas fa-truck fa-fw"></span>
                                        Laravel Logs
                                    </a>
                                </li>
                            @endhasanyrole
                        </div>
                    <div class="divider"></div>
                @endhasanyrole

            @endguest
        </ul>

        <div class="footer">
            <p>
                {{ config('app.name', 'Laravel') }} <?php echo date('Y'); ?> Created and Maintained by Droid Builder Web Team
            </p>
            <ul class="social-icons">
                <li class="social-list-item"><a class="facebook" target="_blank" href="https://www.facebook.com/groups/droidbuildersuk"><i class="fab fa-facebook"></i></a></li>
                <li class="social-list-item"><a class="dribbble" target="_blank" href="https://discord.gg/5D4QE4"><i class="fab fa-discord"></i></a></li>
                <li class="social-list-item"><a class="youtube" target="_blank" href="https://www.youtube.com/c/DroidbuildersUK"><i class="fab fa-youtube"></i></a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Content  -->
    <div class="db-wrapper" id="content">
        <nav class="db-navbar navbar navbar-expand">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>

                {{-- Top Navigation --}}
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto top-nav">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="/Droid Builders Portal User Guide.pdf" target="_blank"><i class="far fa-question-circle fa-2x" title="User Guide"></i></a>
                            </li>
                            @include('partials.notification')
                            @include('partials.account')
                        @endguest
                    </ul>
                    @yield('breadcrumbs')
                </div>
            </div>
        </nav>

        <div class="db-content-wrapper padding-container pt pb">
            @yield('content')
            @include('cookieConsent::index')
        </div>
    </div>
</div>
