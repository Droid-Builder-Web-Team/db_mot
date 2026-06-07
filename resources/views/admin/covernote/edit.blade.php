@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-4">
                    <h2>Edit PLI Cover Note Settings</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.covernote.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Provider Name</label>
                <input type="text" name="pli_provider" class="form-control" value="{{ $settings['pli_provider'] }}" required>
            </div>

            <div class="form-group">
                <label>Policy Number</label>
                <input type="text" name="pli_policy_number" class="form-control" value="{{ $settings['pli_policy_number'] }}" required>
            </div>

            <div class="form-group">
                <label>Wording</label>
                <input type="text" name="pli_wording" class="form-control" value="{{ $settings['pli_wording'] }}" required>
            </div>

            <div class="form-group">
                <label>People Covered</label>
                <input type="text" name="pli_people_covered" class="form-control" value="{{ $settings['pli_people_covered'] }}" required>
            </div>

            <div class="form-group">
                <label>Public Liability</label>
                <input type="text" name="pli_public_liability" class="form-control" value="{{ $settings['pli_public_liability'] }}" required>
            </div>

            <div class="form-group">
                <label>Property Liability</label>
                <input type="text" name="pli_property_liability" class="form-control" value="{{ $settings['pli_property_liability'] }}" required>
            </div>

            <div class="form-group">
                <label>Excess</label>
                <input type="text" name="pli_excess" class="form-control" value="{{ $settings['pli_excess'] }}" required>
            </div>

            <div class="form-group">
                <label>Chairman Contact</label>
                <input type="text" name="pli_chairman" class="form-control" value="{{ $settings['pli_chairman'] }}" required>
            </div>

            <div class="form-group">
                <label>Admin Contact</label>
                <input type="text" name="pli_admin" class="form-control" value="{{ $settings['pli_admin'] }}" required>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
