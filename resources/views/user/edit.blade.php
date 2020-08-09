@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-right mb-4">
            <a class="btn btn-primary" href="{{ route('user.show', Auth::user()->member_uid) }}">Back</a>
          </div>
          <div class="pull-left mb-4">
            <h2>Edit Details</h2>
          </div>
        </div>
    </div>

    <form action="{{ route('user.update',$user->member_uid) }}" method="POST">
        @csrf
        @method('PUT')

      <div class="form-row">
          <div class="col-md-4 mb-3">
            <label>Forename</label>
            <input type="text" name="forename" value="{{ $user->forename }}" class="form-control" placeholder="Forename">
          </div>
          <div class="col-md-4 mb-3">
            <label>Surname</label>
            <input type="text" name="surname" value="{{ $user->surname }}" class="form-control" placeholder="Surname">
          </div>
          <div class="col-md-4 mb-3">
            <label>Forum Username</label>
            <input type="text" name="username" value="{{ $user->username }}" class="form-control" placeholder="Username">
          </div>
      </div>
      <div class="form-row">
          <div class="col-md-12 mb-3">
            <label>Email</label>
            <input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
          </div>
      </div>
      <div class="form-row">
          <div class="col-md-6 mb-3">
            <label>County</label>
            <input type="text" name="county" value="{{ $user->county }}" class="form-control" placeholder="County">
          </div>
          <div class="col-md-6 mb-3">
            <label>Postcode</label>
            <input type="text" name="postcode" value="{{ $user->postcode }}" class="form-control" placeholder="Postcode">
          </div>
      </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
@endsection
