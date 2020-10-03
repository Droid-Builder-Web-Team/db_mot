@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right pb-3">
                    <a class="btn btn-mot" style="width:auto; color:white; border-color:white;" href="{{ route('admin.achievements.index') }}"> Back</a>
                </div>
                <div class="pull-left">
                    <h2>Add New Achievement</h2>
                </div>

            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.achievements.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Name">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Description:</strong>
                        <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-mot">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
