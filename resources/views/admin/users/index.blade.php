@extends('layouts.app')

@section('content')

<style>
@media only screen and (max-width: 800px) {
  td:nth-child(3) {
    display:none;
  }

  th:nth-child(3) {
    display:none;
  }

  td:nth-child(4) {
    display:none;
  }

  th:nth-child(4) {
    display:none;
  }

  td:nth-child(5) {
    display:none;
  }

  th:nth-child(5) {
    display:none;
  }
}
</style>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">Members</h4>
      </div>
      <div class="card-body table table-striped table-sm table-hover table-dark text-center">
        {{$dataTable->table()}}
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
    {{$dataTable->scripts()}}
@endpush
