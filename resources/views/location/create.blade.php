@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="mb-4 pull-right">
                        <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('admin.locations.index') }}">Back</a>
                    </div>
                    <div class="mb-4 pull-left">
                        <h2>Create Location</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.locations.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>

                <div class="form-group">
                    <label for="street"><strong>Street</strong></label>
                    <input type="text" name="street" class="form-control" placeholder="Street">
                </div>

                <div class="form-group">
                    <label for="town"><strong>Town</strong></label>
                    <input type="text" name="town" class="form-control" placeholder="Town">
                </div>

                <div class="form-group">
                    <label for="county"><strong>County</strong></label>
                    <input type="text" name="county" class="form-control" placeholder="County">
                </div>

                <div class="form-group">
                    <label for="country"><strong>Country</strong></label>
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
                    <label for="postcode"><strong>Postcode</strong></label>
                    <input type="text" name="postcode" class="form-control" placeholder="Postcode">
                </div>

                <div class="form-group">
                    <label for="other_details"><strong>Other Details</strong></label>
                    <textarea class="form-control" style="height:150px" name="other_details" placeholder="Other Details"></textarea>
                </div>

                <div class="text-center form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
    </div>
@endsection
