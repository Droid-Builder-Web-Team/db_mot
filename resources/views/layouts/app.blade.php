<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CoreUI CSS -->
 <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin="anonymous">
 <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
 <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
 <link href="{{ asset('css/mot.css') }}" rel="stylesheet">

 <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>

 <title>@yield('page_title', config('app.name', 'Laravel'))</title>
 </head>
 <body class="c-app c-dark-theme">
@include('partials.nav')

<div class="c-wrapper">
  <header class="c-header c-header-light c-header-fixed">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
      <svg class="c-icon c-icon-lg">
        <i class="fas fa-bars"></i>
      </svg>
    </button>
    <a class="c-header-brand d-lg-none c-header-brand-sm-up-center" href="#">
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
      <svg class="c-icon c-icon-lg">
        <i class="fas fa-bars">
        </i>
      </svg>
    </button>
    <ul class="navbar-nav ml-md-auto list-group flex-sm-row">
@guest
    <li class="nav-item pr-3 list-group-item list-group-flush">
      <a class="c-sidebar-nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
    </li>
  @if (Route::has('register'))
    <li class="nav-item pr-2 list-group-item list-group-flush">
      <a class="c-sidebar-nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
    </li>
  @endif
@else

      <li class="nav-item pr-3 list-group-item list-group-flush">
        <i class="far fa-bell fa-2x"></i><span class="badge badge-primary badge-pill">14</span>
      </li>
      <li class="nav-item pr-2 list-group-item list-group-flush">
        {{ Auth::user()->forename }} {{Auth::user()->surname }}
      </li>

@endguest
</ul>
  </header>
  <div class="c-body">
    <main class="c-main">
      <div class="container-fluid">
@yield('content')
      </div>
    </main>
  </div>
@include('partials.footer')
</div>


 <!-- Optional JavaScript -->
 <!-- Popper.js first, then CoreUI JS -->
 <script src="https://unpkg.com/@popperjs/core@2"></script>
 <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
 <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
 <script>
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif
</script>
 @stack('scripts')
 </body>
</html>
