<html>
 <head>
  <title>UK R2 Builders MOT Database</title>
  <link href="{{ asset('css/topps.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 </head>


 <body>
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
 </body>
 </html>
