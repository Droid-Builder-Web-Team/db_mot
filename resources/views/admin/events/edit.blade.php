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


                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="name"><strong>Name</strong></label>
                    </div>
    
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="Event Name" value="{{ $event->name }}">
                    </div>
                </div>
    
                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="location_id"><strong>Location</strong></label>
                    </div>
    
                    <div class="col-sm-5">
                        <select class="form-control location-dropdown" name="location_id" id="location_id">
                            <option value="new">New Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @if ($event->location_id == $location->id) selected @endif>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="col-sm-5">
                        <a class="btn btn-info" id="new-location-btn" href=#>New Location</a>
                    </div>
                </div>

                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="date"><strong>Parking Details</strong></label>
                    </div>
    
                    <div class="col-sm-10">
                        <input type="text" name="parking_details" id="parking_details" class="form-control" placeholder="Event Parking Details" value="{{ $event->parking_details }}">
                    </div>
                </div>
    
    
    
                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="description"><strong>Description</strong></label>
                    </div>
    
                    <div class="col-sm-10">
                        <textarea class="form-control" style="height:150px" id="description" name="description" placeholder="Event Description">{{ $event->description }}</textarea>
                    </div>
                </div>
    
                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="date"><strong>Date</strong></label>
                    </div>
    
                    <div class="col-sm-3">
                        <input type="date" name="date" class="form-control" placeholder="Date" value="{{ $event->date }}">
                    </div>
    
                    <div class="col-sm-2">
                        <label for="days"><strong>Droid Limit</strong></label>
                    </div>
    
                    <div class="col-sm-2">
                        <input type="number" name="quantity" value="{{ $event->quantity }}" class="form-control" placeholder="Droid Limit" required>
                    </div>

                    <div class="col-sm-3">
                    </div>
                </div>


                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="date"><strong>Event Options</strong></label>
                    </div>

                    <div class="col-sm-10">
                        <div class="form-check">
                            {{ Form::hidden('mot', '0') }}
                            <input type="checkbox" id="mot" name="mot" class="form-check-input" {{ $event->mot ? 'checked=1 value=1' : 'value=1' }}>
                            <label class="form-check-label" for="mot">MOTs can be done at this event</label>
                        </div>

                        <div class="form-check">
                            {{ Form::hidden('public', '0') }}
                            <input type="checkbox" id="public" name="public" class="form-check-input" {{ $event->public ? 'checked=1 value=1' : 'value=1' }}>
                            <label class="form-check-label" for="public">Display publicly on droidbuilders.uk if anyone is attending</label>
                        </div>

                        <div class="form-check">
                            {{ Form::hidden('wip_allowed', '0') }}
                            <input type="checkbox" id="wip_allowed" name="wip_allowed" class="form-check-input" {{ $event->wip_allowed ? 'checked=1 value=1' : 'value=1' }}>
                            <label class="form-check-label" for="wip_allowed">WIP Allowed</label>
                        </div>
                    </div>
                </div>


                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <label for="date"><strong>Approval</strong></label>
                    </div>

                    <div class="col-sm-10">
                        <div class="form-check">
                            {{ Form::hidden('approved', '0') }}
                            <input type="checkbox" id="approved" name="approved" class="form-check-input" {{ $event->approved ? 'checked=1 value=1' : 'value=1' }}>
                            <label class="form-check-label" for="approved">Approve event (User submitted)</label>
                        </div>
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

    <script>
        $(document).ready(function() {
            $('.location-dropdown').select2();
        });
    </script>
@endsection
