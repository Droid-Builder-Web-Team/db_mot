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
    <h1>{{ $club->name }} - MOT Information</h1>
    <table class="table table-bordered">
      <tbody>
        @foreach ($sections as $section)
        <tr class="table-danger">
            <td>{{ $section->section_description }}</td>
            <td>{{ $section->section_long_description }}</td>
            @foreach($lines[$section->id] as $line)
            <tr>
              <td>{{ $line->test_description }}</td>
              <td>{{ $line->test_long_description }}</td>
            </tr>
            @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
