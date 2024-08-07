@extends('layouts.app')

@section('content')
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <div class="float-left mb-4">
                <a class="btn btn-mot-invert" style="color:White;" href="{{ route('user.show', Auth::user()->id) }}">{{ __('Back') }}</a>
              </div>
              <h4 class="title text-center">{{ __('Edit Details') }}</h4>
            </div>

              <form action="{{ route('user.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label>{{ __('Forename') }}</label>
                      <input type="text" name="forename" value="{{ $user->forename }}" class="form-control" placeholder="Forename">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label>{{ __('Surname') }}</label>
                      <input type="text" name="surname" value="{{ $user->surname }}" class="form-control" placeholder="Surname">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label>{{ __('Forum Username') }}</label>
                      <input type="text" name="username" value="{{ $user->username }}" class="form-control" placeholder="Username">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12 mb-3">
                      {{ __('Email') }}:
                      <b>{{ $user->email }}</b> <i>(If you need your email changing, please contact an admin.)</i>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <label>{{ __('County') }}</label>
                      <input type="text" name="county" value="{{ $user->county }}" class="form-control" placeholder="County">
                    </div>
                    <div class="col-md-3 mb-3">
                      <label>{{ __('Postcode') }}</label>
                      <input type="text" name="postcode" value="{{ $user->postcode }}" class="form-control" placeholder="Postcode">
                    </div>
                    <div class="col-md-3 mb-3">
                      <label>{{ __('Country') }}</label>
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
                    <div class="col-md-3 mb-3">
                      <label>{{ __('Join Date') }}</label>
                      <input type="date" name="join_date" value="{{ $user->join_date }}" class="form-control" placeholder="">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                      <button type="submit" class="btn btn-mot">{{ __('Submit') }}</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection
