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
                    <input type="text" name="name" class="form-control" placeholder="Event Name">
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
                    <a class="btn btn-info" href={{ route('admin.locations.create') }}>New Location</a>
                </div>

                <div class="form-group">
                    <label for="description"><strong>Description</strong></label>
                    <textarea class="form-control" style="height:150px" id="eventdescription" name="eventdescription" placeholder="Event Description"></textarea>
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
                    <div class="form-check">
                        {{ Form::hidden('wip_allowed', '0') }}
                        <input type="checkbox" id="wip_allowed" name="wip_allowed" class="form-check-input" value="1">
                        <label class="form-check-label" for="wip_allowed">WIP Allowed</label>
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

<script src="https://cdn.tiny.cloud/1/alel9md8kmx7v6ege8dws2rr5uu4cpyhr3z0j809x1099rfk/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#eventdescription',
        plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
        toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter permanentpen table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
    });
</script>
@endsection
