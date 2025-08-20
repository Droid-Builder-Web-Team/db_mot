@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
            <div class="col-sm-2 text-left">
                <a class="btn btn-primary" href={{ route('nominations.create') }}>{{ __('Create Nomination') }}</a>
            </div>
            <div class="col-sm-8 text-center">
                <h4 class="text-center title">{{ __('Nominations') }}</h4>
            </div>
            <div class="col-sm-2 text-right"></div>
        </div>
      </div>
      <div class="table text-center card-body table-striped table-hover table-dark">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Nominee') }}</th>
                    <th>{{ __('Nominated By') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nominations as $nomination)
                    <tr>
                        <td><a href={{ route('nominations.show', $nomination->id) }}>{{ $nomination->nominee->forename }} {{ $nomination->nominee->surname }}</a></td>
                        @if($nomination->nominee->id == Auth()->user()->id)
                            <td colspan=2>Cannot see your own nominations</td>
                        @else
                            <td><a href={{ route('user.show', $nomination->user->id) }}>{{ $nomination->user->forename }} {{ $nomination->user->surname }}</a></td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-view" href={{ route('nominations.show', $nomination->id) }}><div class="d-block d-sm-none"><i class="fas fa-eye"></i></div><span class="d-none d-sm-block">View</span></a>
                                    {{ html()->form('DELETE', route('nominations.destroy', $nomination))->id('delete-form-' . $nomination->id)->open() }}
                                    {{ html()->button('Delete')->type('submit')->class('btn btn-danger delete-button') }}
                                    {{ html()->form()->close() }}
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Prevent the form from submitting immediately
                event.preventDefault();

                // Show the confirmation dialog
                if (confirm('Are you sure you want to delete this user?')) {
                    // If the user confirms, submit the parent form
                    this.closest('form').submit();
                }
            });
        });
    });
</script>

@endsection