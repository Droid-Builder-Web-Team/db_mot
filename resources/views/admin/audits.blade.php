@extends('layouts.app')

@section('content')
{{ $audits->links() }}
<div class="table-responsive">
    <table class="table table-striped table-sm table-hover table-dark text-center" >
      <thead class="thead-dark">
        <tr>
          <th scope="col">Time</th>
          <th scope="col">Model</th>
          <th scope="col">Action</th>
          <th scope="col">User</th>
          <th scope="col">Old Values</th>
          <th scope="col">New Values</th>
        </tr>
      </thead>
      <tbody id="audits">
        @foreach($audits as $audit)
          <tr>
            <td>{{ $audit->created_at }}</td>
            <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
            <td>{{ $audit->event }}</td>
            @if($audit->user)
              <td><a href="{{ route('user.show',$audit->user->id) }}">{{ $audit->user->forename }} {{ $audit->user->surname }}</a></td>
            @else
              <td></td>
            @endif
            <td>
              <table class="table">
                @foreach($audit->old_values as $attribute => $value)
                  <tr>
                    <td><b>{{ $attribute }}</b></td>
                    <td>{{ $value }}</td>
                  </tr>
                @endforeach
              </table>
            </td>
            <td>
              <table class="table">
                @foreach($audit->new_values as $attribute => $value)
                  <tr>
                    <td><b>{{ $attribute }}</b></td>
                    <td>{{ $value }}</td>
                  </tr>
                @endforeach
              </table>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

</div>
@endsection
