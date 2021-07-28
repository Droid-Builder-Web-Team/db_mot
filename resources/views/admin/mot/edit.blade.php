@extends('layouts.app')

@section('content')
<form action="{{ route('admin.motdesign.update',$club->id) }}" method="POST">
  @csrf
  @method('PUT')
    <table class="table table-bordered">
      <tbody>
        @foreach ($sections as $section)
        <tr class="table-danger">
            <td><input type='text' name=section_description[] value='{{ $section->section_description }}'></td>
            <td><input type='text' size=50 name=section_long_description[] value='{{ $section->section_long_description }}'></td>
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
<input type='submit'>
</form>

@endsection
