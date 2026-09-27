@extends('layouts.app')

@section('page_title', 'Droid Share Invitation - ' . ($droid->name ?? 'Droid Builders'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card bg-dark text-white shadow">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-robot mr-2"></i>
                        <h5 class="mb-0">Droid Sharing Invitation</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center my-3">
                            <h2 class="font-weight-bold">{{ $droid->name }}</h2>
                            <p class="text-muted mb-3">{{ $droid->type }} &bull;
                                {{ $droid->club->name ?? 'Droid Builders' }}
                            </p>
                        </div>

                        <div class="alert alert-info text-dark">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>{{ $invite->inviter->forename ?? 'A member' }}
                                {{ $invite->inviter->surname ?? '' }}</strong> has invited you to share ownership of
                            <strong>{{ $droid->name }}</strong>.
                        </div>

                        <p class="text-light">
                            Sharing a droid allows multiple builders (such as partners, spouses, or co-builders) to
                            co-manage the droid, register attendance for events, and display it on your builder profile.
                        </p>

                        @auth
                            @if($droid->users->contains(Auth::user()))
                                <div class="alert alert-warning text-dark">
                                    <i class="fas fa-check-circle mr-1"></i> You are already an owner of this droid.
                                </div>
                                <div class="text-center mt-4">
                                    <a href="{{ route('droid.show', $droid->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> View Droid
                                    </a>
                                </div>
                            @else
                                <div class="card bg-secondary text-white p-3 mb-4">
                                    <div><strong>Logged in as:</strong> {{ Auth::user()->forename }} {{ Auth::user()->surname }}
                                        ({{ Auth::user()->email }})</div>
                                    @if(strtolower(Auth::user()->email) !== strtolower($invite->email))
                                        <small class="text-warning mt-2 d-block">
                                            <i class="fas fa-exclamation-triangle"></i> Note: This invite was sent to
                                            <strong>{{ $invite->recipient ? ($invite->recipient->forename . ' ' . $invite->recipient->surname . ' (' . $invite->email . ')') : $invite->email }}</strong>.
                                            Accepting will link this droid to your current
                                            account (<strong>{{ Auth::user()->email }}</strong>).
                                        </small>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <form action="{{ route('droid.invite.decline', $invite->token) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Decline
                                        </button>
                                    </form>

                                    <form action="{{ route('droid.invite.confirm', $invite->token) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-check"></i> Accept Invitation
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning text-dark">
                                <i class="fas fa-user-lock mr-1"></i>
                                Please log in or register an account to accept this invitation.
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg mr-2">
                                    <i class="fas fa-sign-in-alt"></i> Log In to Accept
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection