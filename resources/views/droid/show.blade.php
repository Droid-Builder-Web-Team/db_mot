@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col md-6">
    <div class="card">
      <div class="card-header">
        <span class="float-left">
          <h2>{{ $droid->name }}</h2>
        </span>
        <span class="float-right">
          {{ $droid->club->name }}
        </span>
      </div>
      <div class="card-body">
        <table class="table table-striped table-sm">
          <tr>
            <th>Owner</th>
            <td>
              @foreach ( $droid->users as $users )
                <a href="{{ route('user.show',$users->id) }}">{{ $users->forename }} {{ $users->surname }}</a><br>
              @endforeach
            </td>
          </tr>
          <tr><th>Type</th><td>{{ $droid->type }}</td></tr>
          <tr><th>Style</th><td>{{ $droid->style }}</td></tr>
          <tr><th>Radio Controlled?</th><td>{{ $droid->radio_controller }}</td></tr>
          <tr><th>Transmitter Type</th><td>{{ $droid->transmitter_type }}</td></tr>
          <tr><th>Material</th><td>{{ $droid->material }}</td></tr>
          <tr><th>Approx Weight</th><td>{{ $droid->weight }}</td></tr>
          <tr><th>Battery Type</th><td>{{ $droid->battery }}</td></tr>
          <tr><th>Drive Voltage</th><td>{{ $droid->drive_voltage }}</td></tr>
          <tr><th>Drive Type</th><td>{{ $droid->drive_type }}</td></tr>
          <tr><th>Top Speed</th><td>{{ $droid->top_speed }}</td></tr>
          <tr><th>Sound System</th><td>{{ $droid->sound_system }}</td></tr>
          <tr><th>Approx Value</th><td>{{ $droid->value }}</td></tr>
          @if ($droid->club->hasOption('tier_two'))
            <tr><th>Tier 2</th><td>{{ $droid->tier_two }}</td></tr>
          @endif
          @if ($droid->club->hasOption('mot'))
            @if ($droid->topps_id != null)
              <tr><th>Topps Number</th><td>{{ $droid->topps_id }}</td></tr>
              @endif
          @endif
        </table>
        <span class="float-left">
@can('Edit Droids')
          <a class="btn btn-primary" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
@else
          <a class="btn btn-primary" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
@endcan
        </span>
        <span class="float-right">
          <a class="btn-sm btn-info" href="{{ action('DroidController@downloadPDF', $droid->id )}}" target="_blank">Info Sheet</a>
        </span>
      </div>
    </div>
@if ($droid->club->hasOption('mot'))
    <div class="card">
      <div class="card-header">
        MOT Details
      </div>
      <div class="card-body">
        <table class="table table-striped table-sm">
          <tr>
            <th>Date</th>
            <th>Location</th>
            <th>Officer</th>
            <th>Approved</th>
            <th>Action</th>
          </tr>
          @foreach($droid->mot as $mot)
            <tr>
              <td>{{ $mot->date }}</td>
              <td>{{ $mot->location }}</td>
              <td>{{ $mot->officer() }}</td>
              <td>{{ $mot->approved }}</td>
              <td><a class="btn btn-primary btn-sm" href="{{ route('mot.show', $mot->id) }}">View</a></td>
            </tr>
          @endforeach
        </table>
        @can('Add MOT')
          <a class="btn btn-primary" href="{{ route('admin.mot.create', $droid->id) }}">Add MOT</a>
        @endcan
      </div>
    </div>
@endif
  </div>
  <div class="col-md-6">                      <!-- image column -->
    <div class="card">
      <div class="card-header">
        <span class="float-left">
          Images
        </span>
      </div>
      <div class="card-body">
        <div class="row">                         <!-- droid images -->
@include('partials.image', ['photo_name' => 'photo_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'photo_side', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'photo_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
        </div> <!-- end of droid images -->
      </div>
    </div>

@if($droid->topps_id != null)
    <div class="card">
      <div class="card-header">
        <span class="float-left">
          Topps Cards
        </span>
      </div>
      <div class="card-body">
        <div class="row">                         <!-- topps images -->
@include('partials.image', ['photo_name' => 'topps_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
@include('partials.image', ['photo_name' => 'topps_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
        </div> <!-- end of topps images -->
      </div>
    </div>
@endif

  </div> <!-- end of images column -->
</div>

@if ($droid->club->hasOption('mot'))
<div class="row">
  <div class="col-md-12">
  <div class="card">
    <div class="card-header">
      Officer Comments
    </div>
    <div class="card-body">
@foreach($droid->comments as $comment)
      <div class="card border-primary">
        <div class="card-header">
          <strong>{{ $comment->user->forename }} {{ $comment->user->surname }}</strong>
          <span class="float-right">
              {{ $comment->created_at }}
          </span>
        </div>
        <div class="card-body">
          {!! nl2br(e($comment->body)) !!}
        </div>
      </div>
@endforeach
@can('Add MOT')
      <div class="card border-primary">
        <div class="card-header">
          <strong>Add Comment</strong>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.droids.comment', $droid->id) }}" method="POST">
              @csrf
              @method('PUT')
            <div class="form-group">
              <textarea type="text" class="form-control" name="body"></textarea>
            </div>
            <input type="submit" class="btn-sm btn-primary" name="comment" value="Add Comment">
          </form>
        </div>
      </div>
@endcan
    </div>
  </div>
</div>
</div>
  @endif
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        Builders Notes
      </div>
      <div class="card-body">
        <div>
          {!! nl2br(e($droid->notes)) !!}
        </div>
          @can('Edit Droids')
            <a class="btn btn-primary" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
          @else
            <a class="btn btn-primary" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
          @endcan
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        Back Story
      </div>
      <div class="card-body">
        <div>
          {!! nl2br(e($droid->back_story)) !!}
        </div>
          @can('Edit Droids')
            <a class="btn btn-primary" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
          @else
            <a class="btn btn-primary" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
          @endcan
      </div>
    </div>
  </div>
</div>
@endsection
