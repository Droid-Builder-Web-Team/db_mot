@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Add New Droid</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('user.show', auth()->user()->id) }}">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('droid.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-xs-9 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>{{ __('Droid Name') }}:</strong>
                            <input type="text" name="name" class="form-control" placeholder="Name" value='{{ old('name') }}'>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>{{ __('Club') }}</strong><br>
                            <select name=club_id>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->id }}">{{ $club->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-9 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>{{ __('Style') }}:</strong> (eg, ANH, custom, etc.)
                            <input type="text" name="style" class="form-control" placeholder="Style" value='{{ old('style') }}'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-9 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>{{ __('Control System') }}:</strong> (eg, Padawan, shadow, custom.)
                            <input type="text" name="transmitter_type" class="form-control" placeholder="Controller" value='{{ old('transmitter_type') }}'>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>RC?</strong>
                            <select class="form-control" name="radio_controlled">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Sound System') }}:</strong>
                            <input type="text" name="sound_system" class="form-control" placeholder="Sound System" value='{{ old('sound_system') }}'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Build Material') }}:</strong>
                            <input type="text" name="material" class="form-control" placeholder="Material" value='{{ old('material') }}'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('Battery Type') }}:</strong> (eg, LiPo, LiFePo, SLA.)
                            <input type="text" name="battery" class="form-control" placeholder="Battery" value='{{ old('battery') }}'>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('Drive Type') }}:</strong> (eg, Warp drives, scavenger.)
                            <input type="text" name="drive_type" class="form-control" placeholder="Drive Type" value='{{ old('drive_type') }}'>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('Drive Voltage') }}</strong>
                            <input type="text" name="drive_voltage" class="form-control" placeholder="" value='{{ old('drive_voltage') }}'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('Approx Value') }}:</strong>
                            <input type="text" name="value" class="form-control" placeholder="" value='{{ old('value') }}'>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('Approx Weight') }}</strong> (in kg)
                            <input type="text" name="weight" class="form-control" placeholder="" value='{{ old('weight') }}'>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('Top Speed') }}</strong> (in m/s)
                            <input type="text" name="top_speed" class="form-control" value="{{ old('top_speed') }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Build Log') }}:</strong>
                            <input type="text" name="build_log" class="form-control" value='{{ old('build_log') }}'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
