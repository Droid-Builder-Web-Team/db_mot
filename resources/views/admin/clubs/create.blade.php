@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Club</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-mot" style="width:auto;" href="{{ route('admin.clubs.index') }}"> Back</a>
        </div>
    </div>
</div>

<form action="{{ route('admin.clubs.store') }}" method="POST">
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
                <strong>Website:</strong>
                <input type="text" name="website" class="form-control" placeholder="Website">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Facebook:</strong>
                <input type="text" name="facebook" class="form-control" placeholder="Facebook">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Forum:</strong>
                <input type="text" name="forum" class="form-control" placeholder="Forum">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-mot">Submit</button>
        </div>
    </div>

</form>
@endsection
