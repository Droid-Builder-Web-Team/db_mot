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
                        <h2>Edit Event</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $event->name }}">
                </div>

                <div class="form-group row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="location_id"><strong>Location</strong></label>
                        <select class="form-control" name="location_id">
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @if ($event->location_id == $location->id) selected @endif>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <a class="btn btn-info" href={{ route('admin.locations.create') }}>New location</a>
                </div>

                <div class="form-group">
                    <label for="description"><strong>Description</strong></label>
                    <textarea class="form-control" style="height:150px" id="description" name="description" placeholder="Description">{{ $event->description }}</textarea>
                </div>

                <div class="form-group row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="date"><strong>Date</strong></label>
                        <input type="date" name="date" class="form-control" placeholder="Date" value="{{ $event->date }}">
                    </div>


                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="quantity"><strong>Droid Limit</strong> (0 = no limit)</label>
                        <input type="number" name="quantity" value="{{ $event->quantity }}" class="form-control" placeholder="Droid Limit" required>
                    </div>

                </div>

                <div class="form-group">
                    <div class="form-check">
                        {{ Form::hidden('mot', '0') }}
                        <input type="checkbox" id="mot" name="mot" class="form-check-input" {{ $event->mot ? 'checked=1 value=1' : 'value=1' }}>
                        <label class="form-check-label" for="mot">MOTs can be done at this event</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        {{ Form::hidden('public', '0') }}
                        <input type="checkbox" id="public" name="public" class="form-check-input" {{ $event->public ? 'checked=1 value=1' : 'value=1' }}>
                        <label class="form-check-label" for="public">Display publicly</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        {{ Form::hidden('wip_allowed', '0') }}
                        <input type="checkbox" id="wip_allowed" name="wip_allowed" class="form-check-input" {{ $event->wip_allowed ? 'checked=1 value=1' : 'value=1' }}>
                        <label class="form-check-label" for="wip_allowed">WIP are allowed</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="url"><strong>URL</strong></label>
                    <input type="text" name="url" class="form-control" placeholder="URL" value="{{ $event->url }}">
                </div>

                <div class="form-group">
                    <label for="charity_raised"><strong>Charity Raised</strong></label>
                    <input type="text" name="charity_raised" value="{{ $event->charity_raised }}" class="form-control" placeholder="Charity Amount">
                </div>

                <div class="form-group">
                    <label for="forum_link"><strong>Forum Link</strong></label>
                    <input type="text" name="forum_link" value="{{ $event->forum_link }}" class="form-control" placeholder="Forum Link">
                </div>

                <div class="form-group">
                    <label for="report_link"><strong>Event Report</strong></label>
                    <input type="text" name="report_link" value="{{ $event->report_link }}" class="form-control" placeholder="Report Link">
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
