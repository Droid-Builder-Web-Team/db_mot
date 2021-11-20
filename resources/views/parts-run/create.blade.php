@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center title">Create A Parts Run</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('parts-run.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="form-group row">
                            <div class="col-md-6 col-12">
                                <label for="select" class="col-4 col-form-label">Club</label>
                                <div class="col-12">
                                    <select id="club_id" name="club_id" class="custom-select"  required>
                                        <option value="null">Select a club</option>
                                        @foreach($clubs as $club)
                                            <option value={{ $club->id }}>{{ $club->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="select1" class="col-4 col-form-label">Member</label>
                                <div class="col-12">
                                    <select id="user_id" name="user_id" class="custom-select" required>
                                        <option value="null">Select a member</option>
                                        @foreach($runners as $runner)
                                            <option value={{ $runner->id }}>{{ $runner->forename }} {{ $runner->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    <div class="form-group row">
                        <div class="mt-3 text-center col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" style="width:auto;" class="btn btn-transparent-outline-blue">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
</div>

@endsection
