@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-4">
                    <h2>Edit PLI Levels</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.plilevels.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>PLI Levels and Prices (Enter one per line, formatted as Name:Price)</label>
                <textarea name="pli_levels" class="form-control" rows="6" required>{{ $levelsText }}</textarea>
                <small class="form-text text-muted">Example:<br>Static:10<br>Driving:20</small>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-mot">Save PLI Levels</button>
            </div>
        </form>
    </div>
</div>
@endsection
