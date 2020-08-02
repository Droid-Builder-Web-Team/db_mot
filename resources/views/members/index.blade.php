@extends('members.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 7 CRUD Example from scratch - ItSolutionStuff.com</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('members.create') }}"> Create New Member</a>
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
            <th>Forename</th>
            <th>Surname</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($members as $member)
        <tr>
            <td>{{ $member->member_uid }}</td>
            <td>{{ $member->forename }}</td>
            <td>{{ $member->surname }}</td>
            <td>
                <form action="{{ route('members.destroy',$member->member_uid) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('members.show',$member->member_uid) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('members.edit',$member->member_uid) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $members->links() !!}
      
@endsection