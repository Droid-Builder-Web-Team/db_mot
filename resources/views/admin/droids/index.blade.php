@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.droids.create') }}"> Create New droid</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Style</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($droids as $droid)
        <tr>
            <td>{{ $droid->droid_uid }}</td>
            <td>{{ $droid->name }}</td>
            <td>{{ $droid->description }}</td>
            <td>
                <form action="{{ route('admin.droids.destroy',$droid->droid_uid) }}" method="POST">

                    <a class="btn btn-primary" href="{{ route('admin.droids.edit',$droid->droid_uid) }}">Edit</a>

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
