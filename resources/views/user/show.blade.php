@extends('layouts.app')

@section('content')

<div class="row">
  <table class="table col-md-9 table-striped">
    <tr><th>Name</th><td>{{ $user->forename }} {{ $user->surname }}</td></tr>
    <tr><th>email</th><td>{{ $user->email }}</td></tr>
    <tr><th>County</th><td>{{ $user->county }}</td></tr>
    <tr><th>Postcode</th><td>{{ $user->postcode }}</td></tr>
    <tr><th>Forum Username</th><td>{{ $user->username }}</td></tr>
    <tr><th>Created On</th><td>{{ $user->created_on }}</td></tr>
    @php
      $uses_pli = 0;
      $has_mot = 0;
    @endphp
    @foreach($user->droids as $droid)
      @if($droid->club->hasOption('mot'))
        @php
          $uses_pli = 1
        @endphp
        @if($droid->hasMOT() && !$droid->hasExpiringMOT())
          @php
            $has_mot = 1
          @endphp
        @endif
      @endif
    @endforeach
    @if ($uses_pli)
    <tr><th>PLI Last Payed</th>
      <td>{{ $user->pli_date }}
        @if($user->validPLI())
            <a class="btn-sm btn-info" href="{{ action('UserController@downloadPDF', $user->id )}}" target="_blank">Cover Note</a>
        @endif
        @if($has_mot && !$user->validPLI() || $user->expiringPLI())
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="2NC9NZLY3CK58">
            <input type="hidden" name="custom" value="{{ $user->id }}">
            <input type="hidden" name="on0" value="MOT Type">
            <input type="hidden" name="os0" value="Initial/Renewal">
            <input type="hidden" name="currency_code" value="GBP">
            <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_paynow_SM.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
          </form>
        @endif
      </td>
    </tr>
    @endif
    <tr><th>ID Link</th>
      <td><a href="{{ url('/')."/id.php?id=".$user->badge_id }}">{{ url('/')."/id.php?id=".$user->badge_id }}</a></td>
    </tr>
    <tr><th>QR Code:</th>
      <td><img src="{{ route('image.displayQRCode',$user->id) }}" alt="qr_code" class="img-fluid mb-1 rounded" style="height:150px;"></td>
    </tr>
  </table>
  <div class="col-md-3">
    <div class="droid-card-content">
      <div style="text-align:center">
				<img src="{{ route('image.displayMugShot',$user->id) }}" alt="mug_shot" class="img-fluid mb-1 rounded" style="height:300px;">
			</div>
			<div class="droid-card-table" style="z-index:2">
				<div class="droid-card-row">
					<div class="droid-card-center noclick">
            <form action="{{ route('image') }}" method="GET">
              @csrf
              <input type="hidden" name="user" value="{{ $user->id }}">
              <input type="hidden" name="droid" value=0>
              <input type="hidden" name="photo_name" value="mug_shot">
              <button type="submit" class="btn btn-primary">Change</button>
            </form>
					</div>
				</div>
			</div>
    </div>
  </div>
</div>
<div class="row">
  @can('Edit Members')
    <a class="btn btn-primary" href="{{ route('admin.users.edit',$user->id) }}">Edit</a>
  @else
    <a class="btn btn-primary" href="{{ route('user.edit',$user->id) }}">Edit</a>
  @endcan
</div>
<div class="row">
  <div class="heading mb-4">
    <h5 class="title text-center">Your Droids</h5>
  </div>
</div>
<div class="row">
@foreach($user->droids as $droid)
  <div class="col-md-3 mb-5 droid-card" onclick="document.location='{{ route('droid.show', $droid->id) }}'">
    <div class="droid-card-content">
      <div style="text-align:center">
				<img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_front']) }}" alt="{{ $droid->name }}" class="img-fluid mb-1 rounded" style="height:300px;">
			</div>

			<div class="droid-card-table" style="z-index:2">
				<div class="droid-card-row">
					<div class="droid-card-left">
						<form action="" >
							<input type="image" src="/img/share.png">
						</form>
					</div>
					<div class="droid-card-center noclick">
						<h2 style="margin-bottom:0px">{{ $droid->name }}</h2>
					</div>
					<div class="droid-card-right">
						<form action="{{ route('droid.destroy', $droid->id) }}" method="POST">
							@csrf
							{{ method_field('DELETE') }}
							<input type="image" src="/img/trash.png">
						</form>
					</div>
				</div>
			</div>
      @if ($droid->club->hasOption('mot'))
    	<div class="pli-container noclick">
				<h5 class="pli-text">@include('partials.motstatus', $droid->displayMOT())</h5>
			</div>
      @endif
    </div>
  </div>
@endforeach
  @can('Edit Droids')
    <div class="col-md-3 mb-5 droid-card" onclick="document.location='{{ route('admin.droids.create', [$user->id]) }}'">
  @else
    <div class="col-md-3 mb-5 droid-card" onclick="document.location='{{ route('droid.create') }}'">
  @endcan
    <div class="droid-card-content">

      <div style="text-align:center">
				<img src="/img/add.png" alt="Add Droid" class="img-fluid mb-1 rounded" style="height:300px, width:300px;">
			</div>
			<div class="droid-card-table" style="z-index:2">
				<div class="droid-card-row">
					<div class="droid-card-center noclick">
						<h2 style="margin-bottom:0px">Add a Droid</h2>
					</div>
				</div>
			</div>
    </div>
  </div>
</div>


<div class="row mb-5">
  <h4 class="sub-title">Achievements</h4>
  <div class="col-md-12 mb-2">
      <table class="table">
        <tr>
          <th>Name</th>
          <th>Notes</th>
          <th>Date Added</th>
          <th></th>
        </tr>
        @foreach($user->achievements as $achievement)
          <tr>
            <td>{{ $achievement->name }}</td>
            <td>{!! $achievement->pivot->notes !!}</td>
            <td>{{ $achievement->pivot->date_added }}</td>
            <td></td>
          </tr>
        @endforeach
      </table>
  </div>
</div>

<div class="row mb-5">
  <h4 class="sub-title">Events</h4>
  <div class="col-md-12 mb-2">
      <table class="table">
        <tr>
          <th>Date</th>
          <th>Details</th>
          <th>Spotter?</th>
          <th>Charity Raised</th>
          <th>Links</th>
          <th>Actions</th>
        </tr>
        @foreach($user->events as $event)
          <tr>
            <td>{{ $event->date }}</td>
            <td>{{ $event->name }}</td>
            <td>{{ $event->spotter }}</td>
            <td>{{ $event->charity_raised }}</td>
            <td>
              @if(!empty($event->forum_link))
                <a class="btn-sm btn-info" href="{{ $event->forum_link }}">Forum</a>
              @endif
              @if(!empty($event->report_link))
                <a class="btn-sm btn-info" href="{{ $event->report_link }}">Report</a>
              @endif
            </td>
            <td><a class="btn-sm btn-primary" href="{{ route('event.show', $event->id) }}">View</a></td>
          </tr>
        @endforeach
      </table>
  </div>
</div>

@endsection
