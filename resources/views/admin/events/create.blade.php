@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right mb-4">
                        <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('admin.events.index') }}">Back</a>
                    </div>
                    <div class="pull-left mb-4">
                        <h2>Create Event</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.events.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>

                <div class="form-group row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="location_id"><strong>Location</strong></label>
                        <select class="form-control" name="location_id">
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <a class="btn btn-info" href={{ route('admin.locations.create') }}>New location</a>
                </div>

                <div class="form-group">
                    <label for="description"><strong>Description</strong></label>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
                </div>

                <div class="form-group row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="date"><strong>Date</strong></label>
                        <input type="date" name="date" class="form-control" placeholder="Date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        {{ Form::hidden('mot', '0') }}
                        <input type="checkbox" id="mot" name="mot" class="form-check-input" value="1">
                        <label class="form-check-label" for="mot">MOTs can be done at this event</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        {{ Form::hidden('public', '0') }}
                        <input type="checkbox" id="public" name="public" class="form-check-input" value="1">
                        <label class="form-check-label" for="public">Display publicly</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="url"><strong>URL</strong></label>
                    <input type="text" name="url" class="form-control" placeholder="URL">
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
