@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="card">
      <div class="card-header">
        <strong>{{ $event->name }}</strong>
      </div>
      <div class="card-body">
        <h1>Add image</h1>
        <form action="{{ route('admin.events.storeimage') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="event_id" value="{{ $event->id }}">
            <div class="mb-3 col-md-12">
              <div class="mb-3 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Image</span>
                  <input type="file" name="image" class="form-control-file" id="eventImageUpload">
                </div>
              </div>
            </div>

            <div class="form-row">
                <div class="mb-3 text-center col-xs-12 col-sm-12 col-md-12">
                <button type="submit" style="width:auto;" class="btn btn-mot">Submit</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
