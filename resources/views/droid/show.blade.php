@extends('layouts.app')

@section('content')

<div class="row">
  <div class="heading mb-4">
    <h1 class="title text-center">{{ $droid->name }}</h1>
  </div>
</div>
<div class="row">
  <table class="table col-md-4 mb-4">
    <tr>
      <th>Owner</th><td>
        @foreach ( $droid->users as $users )
          <a href="{{ route('user.show',$users->id) }}">{{ $users->forename }} {{ $users->surname }}</a><br>
        @endforeach
      </td></tr>
      <th>Club</th><td>{{ $droid->club->name }}</td></tr>
      <th>Type</th><td>{{ $droid->type }}</td></tr>
      <th>Style</th><td>{{ $droid->style }}</td></tr>
      <th>Radio Controlled?</th><td>{{ $droid->radio_controller }}</td></tr>
      <th>Transmitter Type</th><td>{{ $droid->transmitter_type }}</td></tr>
      <th>Material</th><td>{{ $droid->material }}</td></tr>
      <th>Approx Weight</th><td>{{ $droid->weight }}</td></tr>
      <th>Battery Type</th><td>{{ $droid->battery }}</td></tr>
      <th>Drive Voltage</th><td>{{ $droid->drive_voltage }}</td></tr>
      <th>Drive Type</th><td>{{ $droid->drive_type }}</td></tr>
      <th>Top Speed</th><td>{{ $droid->top_speed }}</td></tr>
      <th>Sound System</th><td>{{ $droid->sound_system }}</td></tr>
      <th>Approx Value</th><td>{{ $droid->value }}</td></tr>
      <th>Tier 2</th><td>{{ $droid->tier_two }}</td></tr>
      <th>Topps Number</th><td>{{ $droid->topps_id }}</td></tr>
      <th>Active</th><td>{{ $droid->active }}</td></tr>
    </tr>
  </table>
  <div class="col-md-8">                      <!-- image column -->
    <div class="row">                         <!-- droid images -->
      <div class="col-md-3 droid-card">       <!-- droid front -->
        <div class="droid-card-content">
          <div style="text-align:center">
				        <img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_front']) }}" alt="droid_front" class="img-fluid mb-1 rounded" style="height:300px;">
			    </div>
			    <div class="droid-card-table" style="z-index:2">
				    <div class="droid-card-row">
					    <div class="droid-card-center noclick">
						    <h2 style="margin-bottom:0px">Front</h2>
                <form action="{{ route('image') }}" method="GET">
                  @csrf
                  <input type="hidden" name="user" value="{{ $droid->users->first()->id }}">
                  <input type="hidden" name="droid" value="{{ $droid->id }}">
                  <input type="hidden" name="photo_name" value="photo_front">
                  <button type="submit" class="btn btn-primary">Change</button>
                </form>
					    </div>
				    </div>
			    </div>
        </div>
      </div>
      <div class="col-md-3 droid-card">       <!-- droid side -->
        <div class="droid-card-content">
          <div style="text-align:center">
			     	<img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_side']) }}" alt="droid_side" class="img-fluid mb-1 rounded" style="height:300px;">
			    </div>
			    <div class="droid-card-table" style="z-index:2">
				    <div class="droid-card-row">
					    <div class="droid-card-center noclick">
						    <h2 style="margin-bottom:0px">Side</h2>
                <form action="{{ route('image') }}" method="GET">
                  @csrf
                  <input type="hidden" name="user" value="{{ $droid->users->first()->id }}">
                  <input type="hidden" name="droid" value="{{ $droid->id }}">
                  <input type="hidden" name="photo_name" value="photo_side">
                  <button type="submit" class="btn btn-primary">Change</button>
                </form>
					    </div>
				    </div>
			    </div>
        </div>
      </div>
      <div class="col-md-3 droid-card">       <!-- droid rear -->
        <div class="droid-card-content">
          <div style="text-align:center">
				    <img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_rear']) }}" alt="droid_rear" class="img-fluid mb-1 rounded" style="height:300px;">
    			</div>
		    	<div class="droid-card-table" style="z-index:2">
				    <div class="droid-card-row">
					    <div class="droid-card-center noclick">
						    <h2 style="margin-bottom:0px">Rear</h2>
                <form action="{{ route('image') }}" method="GET">
                  @csrf
                  <input type="hidden" name="user" value="{{ $droid->users->first()->id }}">
                  <input type="hidden" name="droid" value="{{ $droid->id }}">
                  <input type="hidden" name="photo_name" value="photo_rear">
                 <button type="submit" class="btn btn-primary">Change</button>
               </form>
		   			 </div>
				   </div>
			   </div>
       </div>
     </div>
   </div> <!-- end of droid images -->

@if($droid->topps_id != null)
<div class="row">                         <!-- topps images -->
  <div class="col-md-3 droid-card">       <!-- topps front -->
    <div class="droid-card-content">
      <div style="text-align:center">
            <img src="{{ route('image.displayDroidImage', [$droid->id, 'topps_front']) }}" alt="topps_front" class="img-fluid mb-1 rounded" style="height:300px;">
      </div>
      <div class="droid-card-table" style="z-index:2">
        <div class="droid-card-row">
          <div class="droid-card-center noclick">
            <h2 style="margin-bottom:0px">Front</h2>
            <form action="{{ route('image') }}" method="GET">
              @csrf
              <input type="hidden" name="user" value="{{ $droid->users->first()->id }}">
              <input type="hidden" name="droid" value="{{ $droid->id }}">
              <input type="hidden" name="photo_name" value="topps_front">
              <button type="submit" class="btn btn-primary">Change</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="col-md-3 droid-card">           <!-- topps rear -->
<div class="droid-card-content">
  <div style="text-align:center">
    <img src="{{ route('image.displayDroidImage', [$droid->id, 'topps_rear']) }}" alt="topps_rear" class="img-fluid mb-1 rounded" style="height:300px;">
  </div>
  <div class="droid-card-table" style="z-index:2">
    <div class="droid-card-row">
      <div class="droid-card-center noclick">
        <h2 style="margin-bottom:0px">Rear</h2>
        <form action="{{ route('image') }}" method="GET">
          @csrf
          <input type="hidden" name="user" value="{{ $droid->users->first()->id }}">
          <input type="hidden" name="droid" value="{{ $droid->id }}">
          <input type="hidden" name="photo_name" value="topps_rear">
          <button type="submit" class="btn btn-primary">Change</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div> <!-- end of topps images -->
@endif
</div> <!-- end of images column -->
</div>
<div class="row">
  @if ($droid->club->hasOption('mot'))
  <div class="col-md-6">
    MOT Details
    <table class="table">
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
          <td><a class="btn btn-primary" href="{{ route('mot.show', $mot->id) }}">View</a></td>
        </tr>
      @endforeach
    </table>
  </div>
  <div class="col-md-6">
    Officer Comments
    <table class="table">
      <pre>

</pre>
    </table>
  </div>
  @endif
</div>
@endsection
