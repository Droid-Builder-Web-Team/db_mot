@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex ">
                <div class="col-3 text-left">
                    <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('admin.events.index') }}">Back</a>
                </div>
                <div class="col-6 text-center">
                    <h2 class="justify-content-center">Create Event</h2>
                </div>
                <div class="col-3 text-right"></div>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.events.store') }}" method="POST">
                @csrf

                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="name"><strong>Name</strong></label>
                    </div>

                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="Event Name">
                    </div>
                </div>

                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="location_id"><strong>Location</strong></label>
                    </div>

                    <div class="col-sm-5">
                        <select class="form-control" name="location_id">
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-5">
                        <a class="btn btn-info" href={{ route('admin.locations.create') }}>New Location</a>
                    </div>
                </div>

                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="description"><strong>Description</strong></label>
                    </div>

                    <div class="col-sm-10">
                        <textarea class="form-control" style="height:150px" id="description" name="description" placeholder="Event Description"></textarea>
                    </div>
                </div>

                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="date"><strong>Date</strong></label>
                    </div>

                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" placeholder="Date">
                    </div>
                </div>


                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="date"><strong>Event Options</strong></label>
                    </div>

                    <div class="col-sm-10">
                        <div class="form-check">
                            {{ Form::hidden('mot', '0') }}
                            <input type="checkbox" id="mot" name="mot" class="form-check-input" value="1">
                            <label class="form-check-label" for="mot">MOTs can be done at this event</label>
                        </div>

                        <div class="form-check">
                            {{ Form::hidden('public', '0') }}
                            <input type="checkbox" id="public" name="public" class="form-check-input" value="1">
                            <label class="form-check-label" for="public">Display publicly</label>
                        </div>

                        <div class="form-check">
                            {{ Form::hidden('wip_allowed', '0') }}
                            <input type="checkbox" id="wip_allowed" name="wip_allowed" class="form-check-input" value="1">
                            <label class="form-check-label" for="wip_allowed">WIP Allowed</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="date"><strong>URL</strong></label>
                    </div>

                    <div class="col-sm-10">
                        <input type="text" name="url" class="form-control" placeholder="URL">
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'autolink lists table link hr autoresize',
        toolbar: 'table numlist bullist link hr',
        toolbar_mode: 'floating',
    });
</script>
@endsection
