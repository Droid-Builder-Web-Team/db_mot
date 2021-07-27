<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Droidbuilders MOT Info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>
    <h1>{{ $club->name }} - MOT Test Sheet</h1>
    <table class="table table-bordered">
      <tr><td>Name</td><td width=75%></td></tr>
      <tr><td>Droid Name</td><td></td></tr>
      <tr><td>Droid Type</td><td></td></tr>
      <tr><td>Build Material</td><td></td></tr>
      <tr><td>Voltage</td><td></td></tr>
      <tr><td>Drive System</td><td></td></tr>
      <tr><td>Control System</td><td></td></tr>
    </table>
    <hr>
    <h2>Notes</h2>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <table class="table table-bordered">
      <tbody>
        @foreach ($sections as $section)
        <tr class="table-danger">
            <td>{{ $section->section_description }}</td>
            <td>Pass</td>
            <td>N/A</td>
            <td>Fail</td>
            <td width=50%>Notes</td>
            @foreach($lines[$section->id] as $line)
            <tr>
              <td>{{ $line->test_description }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
