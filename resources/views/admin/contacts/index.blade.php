@extends('layouts.app')

@section('content')

<style>
@media only screen and (max-width: 800px) {
  td:nth-child(2) {
    display:none;
  }

  th:nth-child(2) {
    display:none;
  }

  td:nth-child(3) {
    display:none;
  }

  th:nth-child(3) {
    display:none;
  }

}
</style>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
          <div class="text-left col-sm-2">
          </div>
          <div class="text-center col-sm-8">
            <h4 class="text-center title">Venue Contacts</h4>
          </div>
          <div class="text-right col-sm-2"></div>
        </div>
      </div>
      <div class="table text-center card-body table-striped table-sm table-hover table-dark">
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
