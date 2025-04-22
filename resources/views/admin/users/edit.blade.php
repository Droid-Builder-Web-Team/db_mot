@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 margin-tb">
            <div class="pull-right mb-4">
                <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('admin.users.index') }}">Back</a>
            </div>
            <div class="pull-left mb-4">
                <h2>Edit Member</h2>
            </div>
            </div>
        </div>
    </div>
<div class="card-body">
    <form action="{{ route('admin.users.update',$user->id) }}" method="POST">
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
          <div class="col-md-4 mb-3">
            <label>County</label>
            <input type="text" name="county" value="{{ $user->county }}" class="form-control" placeholder="County">
          </div>
          <div class="col-md-4 mb-3">
            <label>Postcode</label>
            <input type="text" name="postcode" value="{{ $user->postcode }}" class="form-control" placeholder="Postcode">
          </div>
          <div class="col-md-3 mb-3">
            <label>Country</label>
            <select name="country" class="form-control" placeholder="Country">
              <option disabled value>Please Select</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="United States">United States</option>
              <option disabled value>----</option>
              @foreach($countries as $code => $country)
                <option value="{{ $country }}"
                @if($country == $user->country)
                  selected
                @endif
                >{{ $country }}</option>
              @endforeach
            </select>
          </div>
      </div>

      <div class="form-row">
          <div class="col-md-4 mb-3">
            <label>PLI Date</label>
            <input type="date" name="pli_date" value="{{ $user->pli_date }}" class="form-control" placeholder="">
          </div>
          <div class="col-md-1 mb-3">
            {{Form::hidden('active','off')}}
            <label>Active</label>
            <input type="checkbox" name="active" {{ $user->active == 'on' ? 'checked' : '' }} class="form-control">
          </div>
          <div class="col-md-1 mb-3">
            {{Form::hidden('accepted_gdpr','0')}}
            <label>GDPR</label>
            <input type="checkbox" name="accepted_gdpr" {{ $user->accepted_gdpr ? 'checked=1 value=1' : 'value=1' }} class="form-control">
          </div>
          <div class="col-md-4 mb-3">
            <label>Join Date</label>
            <input type="date" name="join_date" value="{{ $user->join_date }}" class="form-control" placeholder="">
          </div>
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>PLI Type</label>
          <input type="integer" name="pli_type" value="{{ $user->pli_type }}" class="form-control" placeholder="">
        </div>
    </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Created On: </label>
          {{ $user->created_on }}
        </div>
        <div class="col-md-4 mb-3">
          <label>Updated On: </label>
          {{ $user->last_updated }}
        </div>
        <div class="col-md-4 mb-3">
          <label>Last Login: </label>
          {{ $user->last_login }}
        </div>
      </div>
      <div class="form-row">
          <label>Roles</label>
          <div class="col-md-4">
            @foreach($roles as $role)
              <div class="form-check">
                <input type="checkbox" name="roles[]" value="{{  $role->name }}"
                @if($user->roles->pluck('id')->contains($role->id)) checked @endif >
                <label>{{ $role->name }}</label>
              </div>
            @endforeach
          </div>
          <label>Clubs</label>
          <div class="col-md-4">
            @foreach($clubs as $club)
              <div class="form-check">
                <input type="checkbox" name="clubs[]" value="{{  $club->id }}"
                @if($user->isAdminOf($club)) checked @endif >
                <label>{{ $club->name }}</label>
              </div>
            @endforeach
          </div>
      </div>



      <div class="form-row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-3">
          <button type="submit" style="width:auto;" class="btn btn-mot">Submit</button>
        </div>
      </div>

  </form>
</div>
</div>
@endsection
