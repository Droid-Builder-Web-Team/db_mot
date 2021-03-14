@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 margin-tb">
            <div class="pull-right mb-4">
                <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('admin.locations.index') }}">Back</a>
            </div>
            <div class="pull-left mb-4">
                <h2>Create Location</h2>
            </div>
            </div>
        </div>
    </div>
<div class="card-body">
<form action="{{ route('admin.locations.update', $location->id) }}" method="POST">
    @csrf
    @method('PUT')

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{ $location->name }}" class="form-control" placeholder="Name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Street:</strong>
                <input type="text" name="street" value="{{ $location->street }}" class="form-control" placeholder="Street">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Town:</strong>
                <input type="text" name="town" value="{{ $location->town }}" class="form-control" placeholder="Town">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>County:</strong>
                <input type="text" name="county" value="{{ $location->county }}" class="form-control" placeholder="County">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Postcode:</strong>
                <input type="text" name="postcode" value="{{ $location->postcode }}" class="form-control" placeholder="Postcode">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Other Details:</strong>
                <textarea class="form-control" style="height:150px" name="other_details" placeholder="Other Details">{{ $location->other_details }}</textarea>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>
</div>
</div>

@endsection
