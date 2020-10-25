<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <link href="{{ asset('css/mot.css') }}" rel="stylesheet">
 <link href="{{ asset('css/media.css') }}" rel="stylesheet">
 <link href="{{ asset('css/dark.css') }}" rel="stylesheet">
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">

 <title>@yield('page_title', config('app.name', 'Laravel'))</title>
 </head>

<body>

<link href="{{ asset('css/topps.css') }}" rel="stylesheet">
   <div class="topps">
@foreach($droids as $droid)
  <div class="flip-card">
    <div class="flip-card-inner">
      <div class="flip-card-front">
        <img width=240 src="{{ route('image.displayToppsImage', [$droid->id , 'topps_front', 240]) }}" alt="topps_front">
      </div>
      <div class="flip-card-back">
        <img width=240 src="{{ route('image.displayToppsImage', [$droid->id , 'topps_rear', 240]) }}" alt="topps_rear">
      </div>
    </div>
  </div>

@endforeach
  </div>
{{ $droids->links() }}

</body>
