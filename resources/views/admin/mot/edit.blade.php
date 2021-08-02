@extends('layouts.app')

@section('content')
<form action="{{ route('admin.motdesign.update',$club->id) }}" method="POST">
  @csrf
  @method('PUT')

<h2>MOT Edit</h2>
        @foreach ($sections as $section)
        <table class="table table-bordered">
        <tbody>
        <tr class="table-danger">
            <td>{{ $section->section_description }}</td>
            <td>{{ $section->section_long_description }}</td>
            <td width=75px><i class="fas fa-edit"> <i class="fas fa-trash"></td>
          </tr>
            @foreach($lines[$section->id] as $line)
            <tr>
              <td>{{ $line->test_description }}</td>
              <td>{{ $line->test_long_description }}</td>
              <td width=75px><i class="fas fa-edit"> <i class="fas fa-trash"></td>
            </tr>
            @endforeach
            <tr>
              <td colspan=3><button>Add row</button></td>
            </tr>
      </tbody>
    </table>
    <button>Add section</button>
        @endforeach

<input type='submit'>
</form>

@endsection
