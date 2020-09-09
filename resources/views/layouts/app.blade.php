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
 <!-- <link href="{{ asset('css/dark.css') }}" rel="stylesheet"> -->
 <link href="{{ asset('css/mot.css') }}" rel="stylesheet">

 <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js" integrity="sha512-yUNtg0k40IvRQNR20bJ4oH6QeQ/mgs9Lsa6V+3qxTj58u2r+JiAYOhOW0o+ijuMmqCtCEg7LZRA+T4t84/ayVA==" crossorigin="anonymous"></script>

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




    <ul class="c-header-nav mfs-auto">
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

      <li class="c-header-nav-item dropdown mx-2">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="far fa-bell fa-2x"></i><span class="badge badge-primary badge-pill">
            {{ Auth::user()->unreadNotifications->count() }}
          </span>
        </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg  d-md-down-none pt-0">
      <div class="dropdown-header bg-light">
        <strong>You have {{ Auth::user()->unreadNotifications->count() }} unread notifications</strong>
      </div>

@foreach(Auth::user()->unreadNotifications as $notification)
      <a class="dropdown-item" href="#">
        <div class="message">
          <div>
            <small class="text-muted float-right mt-1">{{ $notification->created_at }}</small>
          </div>
          <div class="font-weight-bold">
            {{ $notification->data['title'] }}
          </div>
          <div class="small text-muted">
            {{ $notification->data['text'] }}
          </div>
        </div>
      </a>
@endforeach

          <a class="dropdown-item text-center border-top" href="{{ route('notifications')}}">
            View all notifications
          </a>
        </div>
      </li>
      <li class="c-header-nav-item mx-2">
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
 @stack('scripts')
 @toastr_render
 </body>
</html>
