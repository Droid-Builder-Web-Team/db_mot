@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Droid</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('user.show', auth()->user()->member_uid) }}">Back</a>
        </div>
    </div>
</div>

<form action="{{ route('droid.store') }}" method="POST">
    @csrf

     <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Droid Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
              <strong>Club</strong>
              <select name=club_uid>
                @foreach($clubs as $club)
                  <option value="{{ $club->club_uid }}">{{ $club->name }}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>
@endsection
