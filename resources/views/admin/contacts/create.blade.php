@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-center title">Create A Venue Contact</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.contacts.store') }}" method="POST">
                @csrf

                <div class="form-group row">
                        <label for="name" class="col-4 col-form-label"><strong>Name</strong></label>
                        <div class="col-12">
                            <input type="text" name="name" class="form-control" placeholder="Contact Name">
                        </div>
                </div>

                <div class="form-group row">
                        <label for="email" class="col-4 col-form-label"><strong>Email</strong></label>
                        <div class="col-12">
                            <input type="text" name="email" class="form-control" placeholder="Contact Email">
                        </div>
                </div>

                <div class="form-group row">
                        <label for="phone" class="col-4 col-form-label"><strong>Contact Number</strong></label>
                        <div class="col-12">
                            <input type="text" name="phone" class="form-control" placeholder="Contact Number">
                        </div>
                </div>

                <div class="form-group row">
                        <label for="notes" class="col-4 col-form-label"><strong>Notes</strong></label>
                        <div class="col-12">
                            <textarea name="notes" class="form-control"></textarea>
                        </div>
                </div>

                <div class="text-center form-group">
                    <button type="submit" class="btn btn-transparent-outline-blue">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
