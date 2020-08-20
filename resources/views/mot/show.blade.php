@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-4 mb-1">
    <a class="btn btn-primary" href="{{ route('droid.show', $mot->droid_uid ) }}">Back</a>
  </div>
</div>
<div class="row">
  <div class="col-md-4 mb-1">
    <table>
      <tr><th>Date:</th><td>{{ $mot->date }}</td></tr>
      <tr><th>Location:</th><td>{{ $mot->location }}</td></tr>
      <tr><th>Officer:</th><td>{{ $mot->officer() }}</td></tr>
      <tr><th>Type:</th><td>{{ $mot->mot_type }}</td></tr>
      <tr><th>Overall:</th><td>{{ $mot->approved }}</td></tr>
    </table>
  </div>
</div>
<div class="row">
  @foreach($mot->sections() as $section)
    <div class="row">
      <h4>{{$section->section_description }}</h2>
    </div>
    @foreach($mot->lines($section->section_name) as $line)
    <div class="row">
      <div class="col-md-3 offset-md-1">
        {{ $line->test_description}}
      </div>
      <div class="col-md-1 mb-1">
        @if ($mot->line($line->line_uid)->mot_test_result == "Pass")
          <button type="button" class="btn btn-success">Pass</button>
        @elseif ($mot->line($line->line_uid)->mot_test_result == "Fail")
          <button type="button" class="btn btn-danger">Fail</button>
        @elseif ($mot->line($line->line_uid)->mot_test_result == "NA")
          <button type="button" class="btn btn-secondary">NA</button>
        @endif
      </div>
    </div>
    @endforeach
  @endforeach
</div>
@endsection
