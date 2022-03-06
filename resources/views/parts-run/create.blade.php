@extends('layouts.app')

@section('content')
<div class="build-section d-flex">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="db-my-1">Create a Part Run</h4>
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

                <form action="{{ route('parts-run.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row form-group">
                        <div class="col-12 col-lg-6">
                            <label for="club_id">Club</label>
                            <select id="club_id" name="club_id" class="custom-select"  required>
                                <option value="null">Select a club</option>
                                @foreach($clubs as $club)
                                    <option value={{ $club->id }}>{{ $club->name }}</option>
                                @endforeach
                            </select>
                            <small id="clubHelp" class="form-text text-muted">What club does this part run belong to?</small>
                        </div>                       
                        <div class="col-12 col-lg-6">
                            <label for="user_id">Member</label>
                            <select id="user_id" name="user_id" class="custom-select" required>
                                <option value="null">Select a member</option>
                                @foreach($runners as $runner)
                                    <option value={{ $runner->id }}>{{ $runner->forename }} {{ $runner->surname }}</option>
                                @endforeach
                            </select>
                            <small id="userHelp" class="form-text text-muted">Which member is running this run?</small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="buttons">
                            <button type="submit" class="btn btn-submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
