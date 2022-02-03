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
      <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
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
          <div class="col-12 col-lg-4">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
          </div>

          <div class="col-12 col-lg-4">
            <label for="pli_date">PLI Date</label>
            <input type="date" id="pli_date" name="pli_date" value="{{ $user->pli_date }}" class="form-control">
          </div>

          <div class="col-12 col-lg-4">
            <label for="join_date">Join Date</label>
            <input type="date" id="join_date" name="join_date" value="{{ $user->join_date }}" class="form-control">
          </div>
        </div>

        <div class="row form-group db-mb-2 text-center">
          <div class="col-12 col-lg-4">
            {{Form::hidden('active','off')}}
            <label for="active">Active</label>
            <input type="checkbox" id="active" name="active" {{ $user->active == 'on' ? 'checked' : '' }} class="form-control">
          </div>

          <div class="col-12 col-lg-4"></div>

          <div class="col-12 col-lg-4">
            {{Form::hidden('accepted_gdpr','0')}}
            <label for="gdrp">GDPR</label>
            <input type="checkbox" id="gdrp" name="accepted_gdpr" {{ $user->accepted_gdpr ? 'checked=1 value=1' : 'value=1' }} class="form-control">
          </div>
        </div>

        <div class="row form-group db-mb-2 text-center">
          <div class="col-12 col-lg-4">
            <label for="created_at">Account Created:</label>
            <p>{{ $user->created_on }}</p>
          </div>

          <div class="col-12 col-lg-4">
            <label for="created_at">Account Updated:</label>
            <p>{{ $user->last_updated }}</p>
          </div>

          <div class="col-12 col-lg-4">
            <label for="created_at">Last Login:</label>
            <p>{{ $user->last_login }}</p>
          </div>
        </div>

        <div class="row form-group db-mb-2">
          <div class="col-12 col-lg-4">
            <h6 class="text-uppercase">User Roles</h6>
              @foreach($roles as $role)
                <div class="input-group">
                    <div class="form-check">
                      <input type="checkbox" name="roles[]" value="{{  $role->name }}"
                      @if($user->roles->pluck('id')->contains($role->id)) checked @endif />
                      <label>{{ $role->name }}</label>
                    </div>
                </div>
              @endforeach
          </div>

          <div class="col-12 col-lg-4"></div>

          <div class="col-12 col-lg-4">
            <h6 class="text-uppercase">Clubs</h6>
            @foreach($clubs as $club)
              <div class="input-group">
                  <div class="form-check">
                    <input type="checkbox" name="clubs[]" value="{{  $club->id }}"
                    @if($user->isAdminOf($club)) checked @endif >
                    <label>{{ $club->name }}</label>
                  </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row form-group">
          <div class="col-12 text-center">
            <button type="button" class="btn btn-submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
