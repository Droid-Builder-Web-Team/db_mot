@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.droids.create') }}"> Create New droid</a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Owner</th>
            <th>Style</th>
            <th>MOT Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($droids as $droid)
        <tr>
            <td>{{ $droid->droid_uid }}</td>
            <td>{{ $droid->name }}</td>
            <td>
              @foreach ( $droid->users as $users )
                {{ $users->forename }} {{ $users->surname }}<br>
              @endforeach
            </td>
            <td>{{ $droid->description }}</td>
            <td>
              @if ( $droid->club->hasOption('mot') )
                <div class="pli-text">@include('partials.motstatus', $droid->displayMOT())</div>
              @endif
            </td>
            <td>
                <form action="{{ route('admin.droids.destroy',$droid->droid_uid) }}" method="POST">

                    <a class="btn btn-primary" href="{{ route('admin.droids.edit',$droid->droid_uid) }}">Edit</a>
                    <a class="btn btn-primary" href="{{ route('admin.mot.create',$droid->club_uid, $droid->droid_uid) }}">New MOT</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $droids->links() !!}

@endsection
