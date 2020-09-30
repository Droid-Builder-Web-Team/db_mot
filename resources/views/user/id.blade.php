<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&display=swap" rel="stylesheet">

    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <link href="{{ asset('css/mot.css') }}" rel="stylesheet">

</head>
<body>
  <div id="app">
    <main class="py-4">
      <div class="container">
        <div class="row justify-content-md-center">
          <div class="col col-lg-4">
            <div class="card border-primary text-center" style="width: 300px;">
              <div class="card-header">
                <strong>Droid Builders Pass</strong>
              </div>
              <div class="card-body">
                <h1>{{ $badge_data['name'] }}</h1>
                <img src="data:image/png;base64, @php echo $file; @endphp">
              </div>
              <div class="card-footer">
                @if ($badge_data['mot'])
                  <button type="button" class="btn-lg btn-success">Active</button>
                @else
                  <button type="button" class="btn-lg btn-danger">Inactive</button>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>
  </div>
</body>
