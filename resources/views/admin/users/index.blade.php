@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12 mb-2">
  <table id="userTable" class="table table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>ID</th>
        <th>Forename</th>
        <th>Surname</th>
        <th>PLI</th>
        <th>Droids</th>
        <th width="280px">Action</th>
      </tr>
    </thead>
  </table>

    <!-- Script -->
    <script type="application/javascript">
    $(document).ready(function(){


      if ( $.fn.dataTable.isDataTable( '#example' ) ) {
          table = $('#userTable').DataTable();
      }
      else {
          table = $('#userTable').DataTable( {
             processing: true,
             serverSide: true,
             retrieve: true,
             order: [[ 2, "asc"]],
             ajax: "{{route('admin.users.getUsers')}}",
             columnDefs: [
                { "orderable": false, "targets": 5 }
             ],
             columns: [
                { data: 'member_uid' },
                { data: 'forename' },
                { data: 'surname' },
                { data: 'pli' },
                { data: 'droid_count' },
                { data: 'actions' }
             ]
           });
         }

    });
    </script>
  </div>
</div>

@endsection
