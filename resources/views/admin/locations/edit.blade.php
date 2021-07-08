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
                        <h2>Edit Location</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.locations.update', $location->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $location->name }}">
                </div>

                <div class="form-group">
                    <label for="street"><strong>Street</strong></label>
                    <input type="text" name="street" class="form-control" placeholder="Street" value="{{ $location->street }}">
                </div>

                <div class="form-group">
                    <label for="town"><strong>Town</strong></label>
                    <input type="text" name="town" class="form-control" placeholder="Town" value="{{ $location->town }}">
                </div>

                <div class="form-group">
                    <label for="county"><strong>County</strong></label>
                    <input type="text" name="county" class="form-control" placeholder="County" value="{{ $location->county }}">
                </div>

                <div class="form-group">
                    <label for="postcode"><strong>Postcode</strong></label>
                    <input type="text" name="postcode" class="form-control" placeholder="Postcode" value="{{ $location->postcode }}">
                </div>

                <div class="form-group">
                    <label for="other_details"><strong>Other Details</strong></label>
                    <textarea class="form-control" style="height:150px" name="other_details" placeholder="Other Details">{{ $location->other_details }}</textarea>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
    </div>

@endsection
