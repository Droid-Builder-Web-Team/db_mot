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
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="publicToggle" value="{{$droid->public}}"
            {{ $droid->public == 'Yes' ? 'checked' : '' }}>
            <label class="custom-control-label" for="publicToggle">Public Profile</label>
          </div>

        </span>
      </div>
      <div class="card-body">
        <table class="table table-striped table-sm table-hover table-dark">
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
          <tr><th>Radio Controlled?</th><td>{{ $droid->radio_controlled }}</td></tr>
          <tr><th>Transmitter Type</th><td>{{ $droid->transmitter_type }}</td></tr>
          <tr><th>Material</th><td>{{ $droid->material }}</td></tr>
          <tr><th>Approx Weight</th><td>{{ $droid->weight }} (kg)</td></tr>
          <tr><th>Battery Type</th><td>{{ $droid->battery }}</td></tr>
          <tr><th>Drive Voltage</th><td>{{ $droid->drive_voltage }}</td></tr>
          <tr><th>Drive Type</th><td>{{ $droid->drive_type }}</td></tr>
          <tr><th>Top Speed</th><td>{{ $droid->top_speed }} (m/s)</td></tr>
          <tr><th>Sound System</th><td>{{ $droid->sound_system }}</td></tr>
          <tr><th>Approx Value</th><td>{{ $droid->value }}</td></tr>
          <tr><th>Build Log</th><td><a target="_blank" href="{{ $droid->build_log }}">{{ $droid->build_log }}</a></td></tr>
          @if ($droid->club->hasOption('tier_two'))
            <tr><th>Tier 2</th><td>{{ $droid->tier_two }}</td></tr>
          @endif
          @if ($droid->club->hasOption('topps'))
            @if ($droid->topps_id != null)
              <tr><th>Topps Number</th><td>{{ $droid->topps_id }}</td></tr>
              @endif
          @endif
        </table>
        <span class="float-left">
@if(Auth::user()->isAdminOf($droid->club) && Auth::user()->can('Edit Droids'))
          <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
@else
          <a class="btn btn-edit" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
@endif
        </span>
        <span class="float-right">
          <a class="btn-sm btn-details" style="color:#2586e7;" href="{{ action('DroidController@downloadPDF', $droid->id )}}" target="_blank">Info Sheet</a>
        </span>
      </div>
    </div>
@if ($droid->club->hasOption('mot'))
    <div class="card">
      <div class="card-header">
        MOT Details
      </div>
      <div class="card-body">
        <table class="table table-striped table-sm table-hover table-dark">
          <tr>
            <th>Date</th>
            <th>Location</th>
            <th>Officer</th>
            <th>Approved</th>
            <th>Action</th>
          </tr>
          @foreach($droid->mot as $mot)
            <tr>
              <td>{{ Carbon\Carbon::parse($mot->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
              <td>{{ $mot->location }}</td>
              <td>{{ $mot->officer() }}</td>
              <td>{{ $mot->approved }}</td>
              <td><a class="btn btn-view btn-sm" href="{{ route('mot.show', $mot->id) }}">View</a></td>
            </tr>
          @endforeach
        </table>
          @if(Auth::user()->isAdminOf($droid->club) && Auth::user()->can('Add MOT'))
          <a class="btn btn-mot" href="{{ route('admin.mot.create', $droid->id) }}">Add MOT</a>
          @endif
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

@if($droid->topps_id != null && $droid->topps_id != 0)
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
              {{ Carbon\Carbon::parse($comment->created_at, Auth::user()->settings()->get('timezone'))->isoFormat(Auth::user()->settings()->get('date_format').' - '.Auth::user()->settings()->get('time_format')) }}
          </span>
        </div>
        <div class="card-body">
          {!! nl2br(e($comment->body)) !!}
          @can('Add MOT')
          <span class="float-right">
            <a href="{{ route('comment.delete', $comment->id )}}" class="btn-sm btn-danger">Delete</a>
          </span>
          @endcan
        </div>
      </div>
@endforeach

  @if(Auth::user()->isAdminOf($droid->club) && Auth::user()->can('Add MOT'))
      <div class="card border-primary">
        <div class="card-header">
          <strong>Add Comment</strong>
        </div>
        <div class="card-body">
          <form action="{{ route('comment.add', [ 'id' => $droid->id]) }}" method="POST">
              @csrf
              <input type="hidden" name="model" value="App\Droid">
            <div class="form-group">
              <textarea type="text" class="form-control" name="body"></textarea>
            </div>
            <input type="submit" class="btn-sm btn-primary" name="comment" value="Add Comment"
                    onclick="this.disabled=true;this.form.submit();">
          </form>
        </div>
      </div>
  @endif
    </div>
  </div>
</div>
</div>
  @endif
<div class="row mb-5">
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
            @if(Auth::user()->isAdminOf($droid->club))
              <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
            @endif
          @else
            <a class="btn btn-edit" style="width:auto;" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
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
            @if(Auth::user()->isAdminOf($droid->club))
              <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
            @endif
          @else
            <a class="btn btn-edit" style="width:auto;" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
          @endcan
      </div>
    </div>
  </div>
</div>

<script>
$('#publicToggle').change(function(){
   var mode= $(this).prop('checked');
   var id=$( this ).val();
       var droid = {};
       droid.mode = $(this).prop('checked');
       droid.publicstatus = $( this ).val();
       droid._token = '{{csrf_token()}}';
       droid.id = '{{ $droid->id }}';
   $.ajax({
     type:"POST",
     dataType:"JSON",
     url:"{{ route('droid.togglePublic') }}",
     data:droid,
     success:function(data)
     {
     }
   });
  });
</script>
@endsection
