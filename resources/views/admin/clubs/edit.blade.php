@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right pb-3">
                    <a class="btn btn-mot" style="width:auto;" href="{{ route('admin.clubs.index') }}"> Back</a>
                </div>
                <div class="pull-left">
                    <h2>Edit Club</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-mot" style="width:auto;" href="{{ route('admin.clubs.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.clubs.update',$club->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" value="{{ $club->name }}" class="form-control" placeholder="Name">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Website:</strong>
                        <input type="text" name="website" value="{{ $club->website }}" class="form-control" placeholder="Website">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Facebook:</strong>
                        <input type="text" name="facebook" value="{{ $club->facebook }}" class="form-control" placeholder="Facebook">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Forum:</strong>
                        <input type="text" name="forum" value="{{ $club->forum }}" class="form-control" placeholder="Forum">
                    </div>
                </div>

                <div class="form-row">
                    <label>Options</label>
                    <div class="col-md-4">
                    @foreach(['topps', 'mot', 'tier_two'] as $option)
                        <div class="form-check">
                            <input type="checkbox" name="options[]" value="{{ $option }}"
                            @if($club->hasOption($option)) checked @endif >
                            <label>{{ $option }}</label>
                        </div>
                    @endforeach
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
