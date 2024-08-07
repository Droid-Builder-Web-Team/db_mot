<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/dark.css') }}" rel="stylesheet">
    <link href="{{ asset(mix('css/app.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/buttons.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/cards.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/sidebar.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/partsrun.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/select2.css'), true) }}" rel="stylesheet">
    <link href="{{ asset('css/mot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/media.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/vendor/flasher/flasher.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" rel="stylesheet" />



    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js" integrity="sha512-yUNtg0k40IvRQNR20bJ4oH6QeQ/mgs9Lsa6V+3qxTj58u2r+JiAYOhOW0o+ijuMmqCtCEg7LZRA+T4t84/ayVA==" crossorigin="anonymous"></script>
    <script src="{{ asset(mix('js/app.js'), true) }}" defer></script>
    <script src="https://portal.droidbuilders.uk/vendor/datatables/buttons.server-side.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>



    <!-- <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">-->

    <!-- Scripts -->


    @laravelPWA

    <title>@yield('page_title', config('app.name', 'Laravel'))</title>
</head>

<body class="c-app c-dark-theme">
    @include('partials.nav')

    <div class="c-wrapper">
        <header class="c-header c-header-light c-header-fixed">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <i class="fa fa-bars cil-menu"></i>
            </button>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <i class="fa fa-bars cil-menu"></i>
            </button>
            <ul class="c-header-nav mfs-auto">
                @guest
                    <li class="mr-2 c-header-nav-item">
                        <a class="btn btn-header-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="mr-2 c-header-nav-item">
                            <a class="btn btn-header-secondary" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="c-header-nav-item">
                        <a href="/Droid Builders Portal User Guide.pdf" target="_blank"><i class="far fa-question-circle fa-2x" title="User Guide"></i></a>
                    </li>
                    @include('partials.language_switcher')
                    @include('partials.notification')
                    @include('partials.account')

                @endguest
            </ul>
            @yield('breadcrumbs')
        </header>

        @yield('scripts')
        <div class="c-body" >
            <main class="c-main">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
        </div>
        @include('cookie-consent::index')
    </div>
    <!-- Optional JavaScript -->
    <!-- Popper.js first, then CoreUI JS -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.0.0/dist/js/coreui.min.js"></script>
    <script src="/vendor/flasher/flasher.min.js" defer></script>
    @stack('scripts')
</body>

</html>
