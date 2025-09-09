@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right pb-3">
                        <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('droid.show', $droid->id) }}">Back</a>
                    </div>
                    <div class="pull-left">
                        <h2>Edit Droid</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.droids.update', $droid->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-row">
                    <div class="col-xs-9 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>Droid Name:</strong>
                            <input type="text" name="name" class="form-control" value="{{ $droid->name }}">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Club:</strong><br>
                            <select class="js-example-basic-single" name=club_id>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->id }}" @if ($droid->club_id == $club->id) selected @endif>{{ $club->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xs-9 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>Style:</strong> (eg, ANH, Custom, etc.)
                            <input type="text" name="style" class="form-control" value="{{ $droid->style }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xs-9 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>Control System:</strong> (eg, Padawan, Shadow, Custom)
                            <input type="text" name="transmitter_type" class="form-control" value="{{ $droid->transmitter_type }}">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>RC?</strong>
                            <select class="form-control form-control-light" name="radio_controlled">
                                <option value="No" <?php echo $droid->radio_controlled == 'No' ? 'selected' : ''; ?>>No</option>
                                <option value="Yes" <?php echo $droid->radio_controlled == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Sound System:</strong>
                            <input type="text" name="sound_system" class="form-control" value="{{ $droid->sound_system }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Build Material:</strong>
                            <input type="text" name="material" class="form-control" value="{{ $droid->material }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Battery Type:</strong> (eg, LiPo, LiFePo, SLA.)
                            <input type="text" name="battery" class="form-control" value="{{ $droid->battery }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Drive Type:</strong> (eg, Warp drives, scavenger.)
                            <input type="text" name="drive_type" class="form-control" value="{{ $droid->drive_type }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Voltage</strong>
                            <input type="text" name="drive_voltage" class="form-control" value="{{ $droid->drive_voltage }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Approx Value:</strong>
                            <input type="text" name="value" class="form-control" value="{{ $droid->value }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Approx Weight</strong> (in kg)
                            <input type="text" name="weight" class="form-control" value="{{ $droid->weight }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Top Speed</strong> (in m/s)
                            <input type="text" name="top_speed" class="form-control" value="{{ $droid->top_speed }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Build Log:</strong>
                            <input type="text" name="build_log" class="form-control" value="{{ $droid->build_log }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-1 mb-3">
                            {{ Form::hidden('active', 'off') }}
                            <label>Active</label>
                            <input type="checkbox" name="active" {{ $droid->active == 'on' ? 'checked' : '' }} class="form-control">
                        </div>
                        @if ($droid->club->hasOption('topps'))
                            <div class="col-md-2 mb-3">
                                <label>Topps Run</label>
                                <input type="text" name="topps_run" class="form-control" value="{{ $droid->topps_run }}">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label>Topps ID</label>
                                <input type="text" name="topps_id" class="form-control" value="{{ $droid->topps_id }}">
                            </div>
                        @endif
                        @if ($droid->club->hasOption('tier_two'))
                            {{ Form::hidden('tier_two', 'No') }}
                            <div class="col-md-1 mb-3">
                                <label>Tier 2?</label>
                                <input type="checkbox" name="tier_two" {{ $droid->tier_two == 'Yes' ? 'checked="Yes"' : 'value=Yes' }} class="form-control">
                            </div>
                        @endif
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Created On: </label>
                            {{ $droid->date_added }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Updated On: </label>
                            {{ $droid->last_updated }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            Builders Notes
                            <div class="form-group">
                                <textarea type="text" class="form-control" name="notes">{{ $droid->notes }}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            Back Story
                            <div class="form-group">
                                <textarea type="text" class="form-control" name="back_story">{{ $droid->back_story }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-mot">Submit</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
