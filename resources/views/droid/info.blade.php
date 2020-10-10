<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.page td img { max-width: none; width: 100%; text-align: center; padding: 25px;}
table { table-layout:fixed; width:100%; border-spacing: 5px;}

</style>
  <title>{{ $droid->name }} Information Sheet</title>
 </head>
 <body>


<table>
  <tr>
    <td colspan=2 align="center"><font size=26>{{ $droid->name }} Information Sheet</font></td>
  </tr>
  <tr>
    <td align="center"><img src="../storage/app/droids/{{ $droid->id }}/240-photo_front.png" alt="{{ $droid->name }}" class="rounded"></td>
    <td align="center"><img src="../storage/app/members/{{ $user->id }}/240-mug_shot.jpg" alt="{{ $user->forename }} {{ $user->surname }}" class="rounded"></td>
  </tr>
  <tr>
    <td align="center">{{ $droid->name }}</td>
    <td align="center">{{ $user->forename }} {{ $user->surname }}</td>
  </tr>
  <tr><td><hr></td><td><hr></td></tr>
  <tr>
    <td style="align:center;" colspan=2>
      <table padding=10 style="align:center;">
        <tr><th>Build Material</th><td style="align:center;" align="center">{{ $droid->material }}</td></tr>
        <tr><th>Control System</th><td style="align:center;" align="center">{{ $droid->transmitter_type }}</td></tr>
        <tr><th>Battery Type</th><td style="align:center;" align="center">{{ $droid->battery }}</td></tr>
        <tr><th>Voltage</th><td style="align:center;" align="center">{{ $droid->drive_voltage }}</td></tr>
        <tr><th>Drive System</th><td style="align:center;" align="center">{{ $droid->drive_type }}</td></tr>
        <tr><th>Sound System</th><td style="align:center;" align="center">{{ $droid->sound_system }}</td></tr>
        <tr><th>Weight</th><td style="align:center;" align="center">{{ $droid->weight }}</td></tr>
        <tr><th>Top Speed</th><td style="align:center;" align="center">{{ $droid->top_speed }}</td></tr>
      </table>
    </td>
  </tr>
  <tr><td><hr></td><td><hr></td></tr>
  <tr>
    <th align="center">Builder Notes</th>
    <th align="center">Back Story</th>
  </tr>
  <tr>
    <td>{!! nl2br(e($droid->notes)) !!}</td>
    <td>{!! nl2br(e($droid->back_story)) !!}</td>
</table>





 </body>
 </html>
