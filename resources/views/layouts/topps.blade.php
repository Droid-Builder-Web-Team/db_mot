<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link href="{{ asset('css/datatables.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/dark.css') }}" rel="stylesheet">
    <link href="{{ asset('css/topps.css') }}" rel="stylesheet">
    <link href="{{ asset(mix('css/app.css'), true) }}" rel="stylesheet">
    <link href="{{ asset('css/media.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">

    <!-- Scripts -->


    @laravelPWA

    <title>@yield('page_title', config('app.name', 'Laravel'))</title>
</head>

<body class="c-app c-dark-theme">
    <div class="c-wrapper">
        <header class="c-header c-header-light c-header-fixed">
            <div class="col-10 d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
            </div>
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
                    @include('partials.notification')
                    @include('partials.account')

                @endguest
            </ul>
            @yield('breadcrumbs')
        </header>

        <div class="c-body">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>
