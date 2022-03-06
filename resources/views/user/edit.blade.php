@extends('layouts.app')
@section('content')
<div class="build-section">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 text-center">
          <h4 class="db-my-1">Edit Member</h4>
          <div class="buttons">
            <a class="btn btn-back" href="{{ url()->previous() }}">Back</a>
          </div>
      </div>

      <div class="col-12">
        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
          </div>
        @endif
      </div>
  </div>

  <div class="row build-section">
    <div class="col-12">
      <form action="{{ route('user.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row form-group db-mb-2">
          <div class="col-12 col-lg-4">
            <label for="forename">Forename</label>
            <input type="text" id="surname" name="forename" value="{{ $user->forename }}" class="form-control" placeholder="Forename">
          </div>

          <div class="col-12 col-lg-4">
            <label for="surname">Surname</label>
            <input type="text" id="surname" name="surname" value="{{ $user->surname }}" class="form-control" placeholder="Surname">
          </div>

          <div class="col-12 col-lg-4">
            <label for="username">Forum Username</label>
            <input type="text" id="username" name="username" value="{{ $user->username }}" class="form-control" placeholder="Username">
          </div>
        </div>

        <div class="row form-group db-mb-2">
          <div class="col-12 col-lg-4">
            <label for="county">County</label>
            <input type="text" id="county" name="county" value="{{ $user->county }}" class="form-control" placeholder="County">
          </div>
          <div class="col-12 col-lg-4">
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode" value="{{ $user->postcode }}" class="form-control" placeholder="Postcode">
          </div>
          <div class="col-12 col-lg-4">
            <label for="country">Country</label>
            <input type="text" id="country" name="country" value="{{ $user->country }}" class="form-control" placeholder="Country">
          </div>
        </div>

        <div class="row form-group db-mb-2">
          <div class="col-12 col-lg-6">
            <label for="email">Email <span>(If you require your email changing, please <a href="admin@droidbuilders.uk">contact us)</a></span></label>
            <input type="text" id="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email" disabled>
          </div>

          <div class="col-12 col-lg-6">
            <label for="join_date">Join Date</label>
            <input type="date" id="join_date" name="join_date" value="{{ $user->join_date }}" class="form-control">
          </div>
        </div>

        <div class="row form-group">
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
