@extends('layouts.app')

@section('content')
<div class="heading mb-3">
    <h1 class="title text-center">Global Settings</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-primary">
            <div class="card-header text-center title">PLI Cover Details</div>
            <div class="card-body text-center">
                <p>Manage the text, limits, policy numbers and contact information displayed on the PLI Cover Note PDFs that are downloaded by users.</p>
                <a href="{{ route('admin.covernote.edit') }}" class="btn btn-mot">Edit PLI Cover Details</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-primary">
            <div class="card-header text-center title">PLI Classes / Levels</div>
            <div class="card-body text-center">
                <p>Manage the available classes of PLI that members can hold (e.g. Static, Driving). These appear as options when editing a member.</p>
                <a href="{{ route('admin.plilevels.edit') }}" class="btn btn-mot">Edit PLI Classes</a>
            </div>
        </div>
    </div>
</div>
@endsection
