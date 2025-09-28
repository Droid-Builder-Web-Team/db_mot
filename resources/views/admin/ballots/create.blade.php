@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row d-flex align-items-center">
              <div class="col-sm-8 text-center">
                  <h4 class="text-center title">Create New Ballot</h4>
              </div>
              <div class="col-sm-2 text-right">
                <a class="btn btn-primary" href="{{ route('ballots.index') }}">{{ __('Back') }}</a>
              </div>
          </div>
        </div>
  
        <div class="card-body">


                <form action="{{ route('admin.ballots.store') }}" method="POST">
                    @csrf

                    <div class="form-group row d-flex justify-content-center align-items-center">
                        <div class="col-sm-2">
                            <label for="title">Ballot Title:</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="title" id="title" required>
                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-center align-items-center">
                        <div class="col-sm-2">
                            <label for="description"><strong>Description</strong></label>
                        </div>
                        <div class="col-sm-10">
                            <textarea class="form-control" style="height:150px" id="description" name="description" placeholder="Ballot Description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-center align-items-center">
                        <div class="col-sm-2">
                            <label for="start_date">Start Date:</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="start_date" id="start_date" required>
                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-center align-items-center">
                        <div class="col-sm-2">
                            <label for="end_date">End Date:</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="end_date" id="end_date" required>
                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-center align-items-center">
                        <div class="col-sm-2">
                            <label for="candidate_ids">Select Candidates:</label>
                        </div>
                        {{-- Add a unique ID for Select2 to target --}}
                        <div class="col-sm-10">
                            <select name="candidate_ids[]" id="select-candidates" multiple required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->forename }} {{  $user->surname }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-info" type="submit">Create Ballot</button>
                </form>

                </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#select-candidates').select2({
            placeholder: "Search for a candidate...",
            allowClear: true
        });
    });
</script>

<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'autolink lists table link hr autoresize',
        toolbar: 'table numlist bullist link hr',
        toolbar_mode: 'floating',
    });
</script>

<script>
    $(document).ready(function() {
        $('.location-dropdown').select2();
    });
</script>

@endpush