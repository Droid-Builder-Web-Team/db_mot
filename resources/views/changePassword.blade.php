@extends('layouts.app')

@section('content')
<div class="build-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="text-center db-mb-2">Change Password</h4>
            </div>
        </div>
        <div class="row w-100 d-flex justify-content-center">
            <div class="col-12 col-lg-6">
                <form method="POST" action="{{ route('change.password') }}">
                    @csrf
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach

                    <div class="col-12 db-my-2">
                        <label for="password">Current Password</label>
                        <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                    </div>

                    <div class="col-12 db-my-2">
                        <label for="password">New Password</label>
                        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                    </div>

                    <div class="col-12 db-my-2">
                        <label for="password">New Confirm Password</label>
                        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                    </div>

                    <div class="col-12 db-my-2">
                        <button type="submit" class="btn btn-submit">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
