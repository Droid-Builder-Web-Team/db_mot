<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin="anonymous">

 <link href="{{ asset('css/mot.css') }}" rel="stylesheet">

  <title>{{ $droid->name }} Information Sheet</title>
 </head>
 <body class="c-app c-dark-theme">
<table border=0 width=90%>
  <tr>
    <td colspan=2>{{ $droid->name }} Information Sheet</td>
  </tr>
  <tr height=480>
    <td align=center><img src="../storage/app/droids/{{ $droid->id }}/240-photo_front.jpg" alt="{{ $droid->name }}" class="img-fluid mb-1 rounded"></td>
    <td align=center><img src="../storage/app/members/{{ $user->id }}/240-mug_shot.png" alt="{{ $user->forename }} {{ $user->surname }}" class="img-fluid mb-1 rounded"></td>
  </tr>
</table>



 </body>
 </html>
