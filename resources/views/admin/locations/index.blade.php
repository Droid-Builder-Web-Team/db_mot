@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.locations.create') }}"> Create New Location</a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Street</th>
            <th>Town</th>
            <th>County</th>
            <th>Postcode</th>
            <th>Map</th>
            <th>Action</th>
        </tr>
        @foreach ($locations as $location)
        <tr>
            <td>{{ $location->id }}</td>
            <td>{{ $location->name }}</td>
            <td>{{ $location->street }}</td>
            <td>{{ $location->town }}</td>
            <td>{{ $location->county }}</td>
            <td>{{ $location->postcode }}</td>
            <td><a class="btn btn-primary" target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ $location->postcode }}">Map</a></td>
            <td>
                <form action="{{ route('admin.locations.destroy',$location->id) }}" method="POST">

                    <a class="btn btn-primary" href="{{ route('admin.locations.edit',$location->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $locations->links() !!}

@endsection
