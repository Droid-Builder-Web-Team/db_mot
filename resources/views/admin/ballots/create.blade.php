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
          <div class="row">

                <form action="{{ route('admin.ballots.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="title">Ballot Title:</label>
                        <input type="text" name="title" id="title" required>
                    </div>
                    <div>
                        <label for="start_date">Start Date:</label>
                        <input type="datetime-local" name="start_date" id="start_date" required>
                    </div>
                    <div>
                        <label for="end_date">End Date:</label>
                        <input type="datetime-local" name="end_date" id="end_date" required>
                    </div>
                    <div>
                        <label for="candidate_ids">Select Candidates:</label>
                        {{-- Add a unique ID for Select2 to target --}}
                        <select name="candidate_ids[]" id="select-candidates" multiple required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->forename }} {{  $user->surname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-info" type="submit">Create Ballot</button>
                </form>

                </div>
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
@endpush