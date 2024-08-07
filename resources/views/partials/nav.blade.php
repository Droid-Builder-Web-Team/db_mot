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

            <li class="c-sidebar-nav-title">{{ __('Club Functions') }}</li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('user.show', Auth::user()->id) }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-user-circle fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Your Profile') }}</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('event.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-calendar fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Upcoming Events') }}</span>
                </a>
            </li>
            @if(config('features.partrun', FALSE))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('parts-run.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-wrench fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Part Runs') }}</span>
                </a>
            </li>
            @endif

            @if(config('features.marketplace', FALSE))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('ware.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-shop fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Marketplace') }}</span>
                </a>
            </li>
            @endif

            @if(config('features.database', FALSE))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('database.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-database fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Droid Database') }}</span>
                </a>
            </li>
            @endif

            @if(config('features.assistance', FALSE))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('assistance.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-hands-helping fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Assistance Requests') }}</span>
                </a>
            </li>
            @endif

            @if(config('features.auction', FALSE))
            <li class="c-sidebar-nav-item disabled">
                <a class="c-sidebar-nav-link disabled" href="{{ route('auctions.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-hand-holding-heart fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Charity Auctions') }}</span>
                </a>
            </li>
            @endif
            
            @if(config('features.assets', FALSE))
            @hasanyrole('Super Admin|Org Admin')
            <li class="c-sidebar-nav-item disabled">
                <a class="c-sidebar-nav-link disabled" href="{{ route('asset.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-boxes-stacked fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Club Assets') }}</span>
                </a>
            </li>
            @endhasanyrole
            @endif


            @if(config('features.friendica', FALSE))
            <li class="c-sidebar-nav-item" data-toggle="tooltip" data-placement="top" title="Set a username first in your profile">
                @if(Auth::user()->username != "")
                    <a class="c-sidebar-nav-link" target="_blank" href="https://fr.droidbuilders.uk">
                @else
                    <a class="c-sidebar-nav-link" href="{{ route('user.edit', Auth::user()->id) }}">
                @endif
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-share-nodes fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Friendica') }}</span>
                </a>
            </li>
            @endif
            <li class="c-sidebar-nav-title">Info</li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('portalnews.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-newspaper fa-fw"></i>
                    </svg><span class="ml-1">{{ __('News and Updates') }}</span>
                    @if(Auth::user()->newnews)
                     &nbsp;<span class="dot"></span>
                    @endif
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('motinfo.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-info-circle fa-fw"></i>
                    </svg><span class="ml-1">{{ __('MOT Info') }}</span>
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" target="_blank" href="https://robsrobots.co.uk/guides.php">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-tools fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Builders Guides') }}</span>
                </a>
            </li>

            @if(config('features.partrun', TRUE))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" target="_blank" href="{{ route('partsRunInfo') }}">
                    <svg class="c-sidebar-nav-icon">
                    <i class="fas fa-list fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Part Runs') }}</span>
                </a>
            </li>
            @endif

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('topps') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-grip-horizontal fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Topps Cards') }}</span>
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('runs.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-flag-checkered fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Driving Course') }}</span>
                </a>
            </li>           

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('about') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-info fa-fw"></i>
                    </svg><span class="ml-1">{{ __('About Us') }}</span>
                </a>
            </li>

            @hasanyrole('Super Admin|Org Admin|Events Officer|MOT Officer')
            <li class="c-sidebar-nav-title">{{ __('Admin') }}</li>


            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.dashboard.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-tachometer-alt fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Dashboard') }}</span>
                </a>
            </li>
            @endhasanyrole

            @can('View Members')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <i class="fas fa-users fa-fw"></i>
                        </svg><span class="ml-1">{{ __('Members') }}</span>
                    </a>
                </li>
            @endcan
            @can('View Droids')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.droids.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <i class="fas fa-robot fa-fw"></i>
                        </svg><span class="ml-1">{{ __('Droids') }}</span>
                    </a>
                </li>
            @endcan
            @can('Edit Members')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.map.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-map-marked-alt fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Members Map') }}</span>
                </a>
            </li>
            @endcan
            @can('Edit Events')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.events.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <i class="fas fa-calendar fa-fw"></i>
                        </svg><span class="ml-1">{{ __('Events') }}</span>
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.locations.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <i class="fas fa-map-marker fa-fw"></i>
                        </svg><span class="ml-1">{{ __('Locations') }}</span>
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.contacts.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <i class="fas fa-user fa-fw"></i>
                        </svg><span class="ml-1">{{ __('Contacts') }}</span>
                    </a>
                </li>
            @endcan
            @can('Edit Achievements')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.achievements.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <i class="fas fa-trophy fa-fw"></i>
                        </svg><span class="ml-1">{{ __('Achievements') }}</span>
                    </a>
                </li>
            @endcan
            @can('Edit Clubs')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.clubs.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <i class="fas fa-cubes fa-fw"></i>
                        </svg><span class="ml-1">{{ __('Clubs') }}</span>
                    </a>
                </li>
                <li class="c-sidebar-nav-item"></li>
            @endcan
            @hasanyrole('Super Admin|Org Admin')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.audits.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-file-contract fa-fw"></i>
                    </svg><span class="ml-1">{{ __('Audit') }}</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item"></li>
            @endhasanyrole

            @hasanyrole('Super Admin')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.logs.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <i class="fas fa-truck fa-fw"></i>
                    </svg><span class="ml-1">Laravel Logs</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item"></li>
            @endhasanyrole
        @endguest
        <hr class="divider">

    </ul>

    @include('partials.sidebar_footer')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
