@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.clubs.create') }}"> Create New Club</a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Links</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($clubs as $club)
        <tr>
            <td>{{ $club->id }}</td>
            <td>{{ $club->name }}</td>
            <td>
              @if(isset($club->facebook))
                <a class="btn btn-primary" href="{{$club->facebook}}">Facebook</a>
              @endif
              @if(isset($club->website))
                <a class="btn btn-primary" href="{{$club->website}}">Website</a>
              @endif
              @if(isset($club->forum))
                <a class="btn btn-primary" href="{{$club->forum}}">Forum</a>
              @endif
            </td>
            <td>
                <form action="{{ route('admin.clubs.destroy',$club->id) }}" method="POST">

                    <a class="btn btn-primary" href="{{ route('admin.clubs.edit',$club->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $clubs->links() !!}
@endsection
