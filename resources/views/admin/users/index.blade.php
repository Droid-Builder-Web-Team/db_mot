@extends('layouts.app')

@section('content')
<div class="form-row">
  <form id="search" action="">
    <div class="col-md-10 mb-3">
      <input type="text" name="q" placeholder="Search..." class="form-control"/>
    </div>
    <div class="col-md-2 mb-3">
      <input type="submit" class="btn btn-primary" value="Search"/>
    </div>
  </form>
</div>
<div class="row">
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
        <td><a href="{{ route('user.show',$user->member_uid) }}">{{ $user->forename }} {{ $user->surname }}</a></td>
        <td>
        @if ($user->validPLI())
          Valid ( {{ $user->pli_date }} )
        @else
          Invalid PLI
        @endif
        </td>
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
</div>

@endsection
