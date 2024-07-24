@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row d-flex ">
            <div class="text-left col-3">
                <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('event.index') }}">{{ __('Back') }}</a>
            </div>
            <div class="text-center col-6">
                <h2 class="justify-content-center">{{ __('Create Event') }}</h2>
            </div>
            <div class="text-right col-3"></div>
        </div>
    </div>
    <div class="card-body">

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-sm-12">
                <p>
            This form is to allow members to submit events that they have heard about and are interested in going. A member of the admin team will then approve it. Please enter 
            as much detail as you can, and make sure the address is correct.
                </p>
                <p>
            Also, please check that the location doesn't already exist using the drop down. This will allow us to rate and comment about
            venues for future events.
                </p>
            </div>
        </div>

        <form action="{{ route('event.store') }}" method="POST">
            @csrf

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    <label for="name"><strong>{{ __('Name') }}</strong></label>
                </div>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Event Name" value={{ old('name') }}>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    <label for="location_id"><strong>{{ __('Location') }}</strong></label>
                </div>

                <div class="col-sm-5">
                    <select class="form-control location-dropdown @error('location_id') is-invalid @enderror" name="location_id" id="location_id">
                        <option value="---">---</option>
                        <option value="new">{{ __('New Location') }}</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-5">
                    <a class="btn btn-info" id="new-location-btn" href=#>{{ __('New Location') }}</a>
                </div>
            </div>

<div id="new-location" style="display:none">
    <div class="card">
        <div class="card-header">
            {{ __('New Location') }}
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name"><strong>{{ __('Name') }}</strong></label>
                <input type="text" name="location_name" class="form-control @error('location_name') is-invalid @enderror" placeholder="Name" value={{ old('location_name') }}>
                @error('location_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="street"><strong>{{ __('Street') }}</strong></label>
                <input type="text" name="street" class="form-control" placeholder="Street" value={{ old('street') }}>
            </div>

            <div class="form-group">
                <label for="town"><strong>{{ __('Town') }}</strong></label>
                <input type="text" name="town" class="form-control @error('town') is-invalid @enderror" placeholder="Town" value={{ old('town') }}>
                @error('town')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="county"><strong>{{ __('County') }}</strong></label>
                <input type="text" name="county" class="form-control" placeholder="County" value={{ old('county') }}>
            </div>

            <div class="form-group">
                <label for="country"><strong>{{ __('Country') }}</strong></label>
                <select name="country" class="form-control" placeholder="Country">
                    <option disabled value>Please Select</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option disabled value>----</option>
                    @foreach($countries as $code => $country)
                    <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="postcode"><strong>{{ __('Postcode') }}</strong></label>
                <input type="text" name="postcode" class="form-control @error('postcode') is-invalid @enderror" placeholder="Postcode" value={{ old('postcode') }}>
                @error('postcode')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    <label for="date"><strong>{{ __('Parking Details') }}</strong></label>
                </div>

                <div class="col-sm-10">
                    <input type="text" name="parking_details" id="parking_details" class="form-control" placeholder="Event Parking Details" value={{ old('parking_details') }}>
                </div>
            </div>



            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    <label for="description"><strong>{{ __('Description') }}</strong></label>
                </div>

                <div class="col-sm-10">
                    <textarea class="form-control @error('description') is-invalid @enderror" style="height:150px" id="description" name="description" placeholder="Event Description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    <label for="date"><strong>{{ __('Date') }}</strong></label>
                </div>

                <div class="col-sm-3">
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" placeholder="Date" value={{ old('date') }}>
                    @error('date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-1">
                    <label for="days"><strong>{{ __('Days') }}</strong></label>
                </div>

                <div class="col-sm-2">
                    <input type="number" name="days" value="1" class="form-control" placeholder="Number of Days" required  value={{ old('days') }}>
                </div>

                <div class="col-sm-2">
                    <label for="days"><strong>{{ __('Droid Limit') }}</strong></label>
                </div>

                <div class="col-sm-2">
                    <input type="number" name="quantity" value="0" class="form-control" placeholder="Droid Limit" required value={{ old('quantity') }}>
                </div>
            </div>

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    <label for="date"><strong>{{ __('Event Options') }}</strong></label>
                </div>

                <div class="col-sm-10">
                    <div class="form-check">
                        {{ Form::hidden('public', '0') }}
                        <input type="checkbox" id="public" name="public" class="form-check-input" value="1">
                        <label class="form-check-label" for="public">{{ __('Display publicly on droidbuilders.uk if anyone is attending') }}</label>
                    </div>
                    <div class="form-check">
                        {{ Form::hidden('sw_only', '0') }}
                        <input type="checkbox" id="sw_only" name="sw_only" class="form-check-input" value="1">
                        <label class="form-check-label" for="sw_only">{{ __('Star Wars Only event') }}</label>
                    </div>
                </div>
            </div>

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    <label for="date"><strong>{{ __('URL') }}</strong></label>
                </div>

                <div class="col-sm-10">
                    <input type="text" name="url" class="form-control" placeholder="URL">
                </div>
            </div>

            <div class="text-center form-group">
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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

<script type="text/javascript">
    $(document).ready(function () {
        $("#new-location-btn").click(function () {
            $("#location_id option[value='new']").attr("selected", true);
            $("#location_id option[value='new']").prop("selected", "selected");
            $("#new-location").toggle();
        });
    });
    </script>
@endsection