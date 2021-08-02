@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New MOT</h2>
            </div>
        </div>
    </div>


    <form id="motform" action="{{ route('admin.mot.store') }}" method="POST">
        @csrf

        <input type=hidden name="droid_id" value="{{ $droid->id }}">
        <input type=hidden name="club_id" value="{{ $droid->club_id }}">
        <input type=hidden name="user" value="{{ Auth::user()->id }}">

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">

                        <!-- Date -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Date</label>
                                    <input class="form-control" id="date" name="date" type="date" required>
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input class="form-control" id="location" name="location" type="text" required>
                                </div>
                            </div>
                        </div>

                        <!-- Officer -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="officer">Officer</label>
                                    <input class="form-control" id="officer" name="officer" type="text" value="{{ Auth::user()->forename }} {{ Auth::user()->surname }}" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- MOT Type -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="mot_type">Type</label>
                                    <select class="form-control" id="mot_type" name="mot_type" onchange="autoFill()">
                                        <option value=Initial>Initial</option>
                                        <option value=Renewal>Renewal</option>
                                        <option value=Retest>Retest</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Overall -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="mot_type">Overall</label>
                                    <select class="form-control" name="approved">
                                        <option value=Yes>Yes</option>
                                        <option value=No>No</option>
                                        <option value=WIP>WIP</option>
                                        <option value=Advisory>Yes (Advisory)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="mot_type">Comments</label>
                                    <textarea class="form-control" name="body" rows=10 cols=30></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>

            @foreach ($sections as $section)
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ $section->section_description }}</h2>
                    </div>
                </div>
                @foreach (App\MOT::lines($section->id) as $line)
                    <div class="row">
                        <div class="col-md-3 offset-md-1" data-toggle="tooltip" data-placement="top" title="{{ $line->test_long_description }}">
                            {{ $line->test_description }}
                        </div>
                        <div class="col-md-2 mb-1">
                            <input type=radio id="{{ $line->test_name }}_Pass" name="{{ $line->test_name }}" value="Pass">Pass
                            <input type=radio id="{{ $line->test_name }}_Fail" name="{{ $line->test_name }}" value="Fail" checked>Fail
                            <input type=radio id="{{ $line->test_name }}_NA" name="{{ $line->test_name }}" value="NA">NA
                        </div>
                    </div>
                @endforeach
            @endforeach

        </div>

        <!-- Submit -->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <button class="submit btn btn-block btn-primary" type="submit">
                        <i class="loading-icon fa-lg fas fa-spinner fa-spin invisible"></i> &nbsp;
                        <i class="czi-user mr-2 ml-n1"></i>
                        <span class="btn-txt">{{ __('Submit') }}</span></button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#motform").submit(function() {
                // Disable the submit button on a form submission
                $(this).children('input[type=submit]').prop('disabled', true);
                $(".result").text("");
                $(".loading-icon").removeClass("invisible");
                $(".submit").attr("disabled", true);
                $(".btn-txt").text("Processing ...");
            });
        });

        function autoFill() {
            var x = document.getElementById("mot_type").value
            if (x == 'Retest' || x == 'Renewal') {
                console.log('retest/renewal - {{ $droid->lastMotId() }}');
                $.getJSON('/api/mot/{{ $droid->lastMotId() }}', function(data) {
                    for (var i = 0; i < data.length; i++) {
                        var test = data[i]['mot_test'];
                        var result = data[i]['mot_test_result'];
                        var id = test + '_' + result;
                        $('#' + id).prop('checked', true);

                    }
                });
            }
        }
    </script>

@endsection
