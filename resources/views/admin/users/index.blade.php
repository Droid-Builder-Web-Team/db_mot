@extends('layouts.app')

@section('content')


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>PLI</th>
            <th>Primary MOT</th>
            <th>Droids</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->member_uid }}</td>
            <td>{{ $user->forename }} {{ $user->surname }}</td>
            <td>{{ $user->pli_date }}</td>
            <td></td>
            <td></td>
            <td>
                <form action="{{ route('admin.users.destroy',$user->member_uid) }}" method="POST">

                    <a class="btn btn-primary" href="{{ route('admin.users.edit',$user->member_uid) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $users->links() !!}

@endsection
