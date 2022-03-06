@extends('layouts.app')
@section('content')
<div class="build-section">
  <div class="container-fluid">
    <div class="row db-mb-2">
      <div class="col-12 col-lg-12 build-section d-block">
        <div class="droid-view-col db-mb-2">
          <div class="droid-name">
            <h4>{{ $droid->name }}</h4>
          </div>

          <div class="profile-toggle">
            {{ $droid->club->name }}
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="publicToggle" value="{{$droid->public}}"
              {{ $droid->public === 1 ? 'checked' : '' }}>
              <label class="custom-control-label" for="publicToggle">Public Profile</label>
            </div>
          </div>
        </div>

        <h5 class="text-center db-mb-1">Droid Images</h5>
        <div class="row images-row">
            @include('partials.image', ['photo_name' => 'photo_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
            @include('partials.image', ['photo_name' => 'photo_side', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
            @include('partials.image', ['photo_name' => 'photo_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
        </div>
      </div>
    </div>

    <div class="row build-section db-my-2">
      <div class="col-12">
      <h4 class="text-uppercase text-center">Droid Details</h4>
        <div class="table-responsive">
          <table class="table table-striped table-sm table-hover table-dark">
            <tbody>
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
              <tr><th>Approx Weight</th><td>{{ $droid->weight }}</td></tr>
              <tr><th>Battery Type</th><td>{{ $droid->battery }}</td></tr>
              <tr><th>Drive Voltage</th><td>{{ $droid->drive_voltage }}</td></tr>
              <tr><th>Drive Type</th><td>{{ $droid->drive_type }}</td></tr>
              <tr><th>Top Speed</th><td>{{ $droid->top_speed }}</td></tr>
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
            </tbody>
          </table>
        </div>

        <div class="droid-buttons-wrapper d-flex justify-content-between">
          @if(Auth::user()->isAdminOf($droid->club) && Auth::user()->can('Edit Droids'))
            <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
          @else
            <a class="btn btn-edit" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
          @endif

            <a class="btn btn-view" href="{{ action('DroidController@downloadPDF', $droid->id )}}" target="_blank">Info Sheet</a>
        </div>
      </div>
    </div>

    @if ($droid->club->hasOption('mot'))
    {{-- If the Droid Club has MOTs, display the MOT Table --}}
    <div class="row build-section">
      <div class="col-12">
      <h4 class="text-uppercase text-center">MOT Details</h4>
      @if(is_null($droid->mot))
        <div class="table-responsive">
          <table class="table table-striped table-hover table-dark">
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
        </div>
        @else
        <h5 class="text-center">No MOT Data Avaliable</h5>
        @endif
        {{-- @include('partials.comments', ['comments' => $data->comments, 'permission' => 'Edit Partrun', 'model_type' => 'App\PartsRunData', 'model_id' => $data->id]) --}}
      </div>
    </div>
    @endif

    <div class="row build-section db-my-2">
      <div class="col-12 col-lg-6">
        <h4 class="text-center">
          Builders Notes
        </h4>

        @if($droid->notes)
          <div class="notes-box">
            {!! nl2br(e($droid->notes)) !!}
          </div>
        @else

        <h5 class="text-center">No Builders Notes</h5>
        @endif
        @can('Edit Droids')
        @if(Auth::user()->isAdminOf($droid->club))
          <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.droids.edit',$droid->id) }}">Edit</a>
        @endif
      @else
        <a class="btn btn-edit" style="width:auto;" href="{{ route('droid.edit',$droid->id) }}">Edit</a>
      @endcan
      </div>
      <div class="col-12 col-lg-6">
        <h4 class="text-center">
          Back Story
        </h4>

        @if($droid->back_story)
        <div class="notes-box">
          {!! nl2br(e($droid->back_story)) !!}
        </div>
        @else
        <h5 class="text-center">No Back Story</h5>
        @endif
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
