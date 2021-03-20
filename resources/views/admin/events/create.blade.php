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

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
              <strong>Location</strong><br>
              <select class="form-select" name=location_id>
                @foreach($locations as $location)
                  <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
              </select>
              <a class="btn-sm btn-info" href={{ route('admin.locations.create')}}>New location</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Date:</strong>
                <input type="date" name="date" class="form-control" placeholder="Date">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
          <div class="form-group">
            <div class="form-check-inline">
            {{Form::hidden('mot','0')}}
            <input type="checkbox" id="mot" name="mot" class="form-check-input" value="1">
            <label class="form-check-label" for="mot">MOTs can be done at this event</label>
          </div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>URL:</strong>
                <input type="text" name="url" class="form-control" placeholder="URL">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>
</div>
</div>
<div id="newLocation" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Add a location</p>
  </div>

</div>


<script>
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

// Get the modal
var modal = document.getElementById("newLocation");

// Get the button that opens the modal
var btn = document.getElementById("addLocation");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
@endsection
