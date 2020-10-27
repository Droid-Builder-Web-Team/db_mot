@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Event</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.events.index') }}"> Back</a>
        </div>
    </div>
</div>

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
              <select class="js-example-basic-single" name=location_id>
                @foreach($locations as $location)
                  <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
              </select>
              <button id="addLocation">Add Location</button>
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

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>

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
