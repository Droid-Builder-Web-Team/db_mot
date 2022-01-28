<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link href="{{ asset('css/dark.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset(mix('css/app.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/buttons.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/cards.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/sidebar.css'), true) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/partsrun.css'), true) }}" rel="stylesheet">
    <link href="{{ asset('css/mot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/media.css') }}" rel="stylesheet">

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js" integrity="sha512-yUNtg0k40IvRQNR20bJ4oH6QeQ/mgs9Lsa6V+3qxTj58u2r+JiAYOhOW0o+ijuMmqCtCEg7LZRA+T4t84/ayVA==" crossorigin="anonymous"></script>
    <script src="{{ asset(mix('js/app.js'), true) }}" defer></script>
    <script src="https://portal.droidbuilders.uk/vendor/datatables/buttons.server-side.js"></script>


    {{-- <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css"> --}}

    <!-- Scripts -->
    @laravelPWA

    <title>@yield('page_title', config('app.name', 'Laravel'))</title>
</head>

<body class="db-dark-theme">
    @include('partials.sidebar')
    <div class="db-wrapper">
        @yield('scripts')
    </div>
    <!-- Optional JavaScript -->
    <!-- Popper.js first, then CoreUI JS -->
    {{-- <script src="https://unpkg.com/@popperjs/core@2"></script> --}}
    {{-- <script src="https://unpkg.com/@coreui/coreui@3.0.0/dist/js/coreui.min.js"></script> --}}
    @stack('scripts')
    @toastr_render
</body>

</html>
