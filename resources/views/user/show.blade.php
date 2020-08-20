@extends('layouts.app')

@section('content')

<div class="row">
  <table class="table col-md-6 table-striped">
    <tr><th>email</th><td>{{ $user->email }}</td></tr>
    <tr><th>County</th><td>{{ $user->county }}</td></tr>
    <tr><th>Postcode</th><td>{{ $user->postcode }}</td></tr>
    <tr><th>Forum Username</th><td>{{ $user->username }}</td></tr>
    <tr><th>Created On</th><td>{{ $user->created_on }}</td></tr>
    <tr><th>PLI Last Payed</th><td>{{ $user->pli_date }}</td></tr>
    <tr><th>ID Link</th>
      <td><a href="{{ url('/')."/id.php?id=".$user->badge_id }}">{{ url('/')."/id.php?id=".$user->badge_id }}</a></td>
    </tr>
    <tr><th>QR Code:</th>
      <td><img src="{{ route('image.displayQRCode',$user->member_uid) }}" alt="qr_code" class="img-fluid mb-1 rounded" style="height:150px;"></td>
    </tr>
  </table>
  <div class="col-md-6">
    <div class="droid-card-content">
      <div style="text-align:center">
				<img src="{{ route('image.displayMugShot',$user->member_uid) }}" alt="mug_shot" class="img-fluid mb-1 rounded" style="height:300px;">
			</div>
			<div class="droid-card-table" style="z-index:2">
				<div class="droid-card-row">
					<div class="droid-card-center noclick">
						<h2 style="margin-bottom:0px">Mug Shot</h2>
					</div>
				</div>
			</div>
    </div>
  </div>
  @can('Edit Members')
    <a class="btn btn-primary" href="{{ route('admin.users.edit',$user->member_uid) }}">Edit</a>
  @else
    <a class="btn btn-primary" href="{{ route('user.edit',$user->member_uid) }}">Edit</a>
  @endcan
</div>
<div class="row">
  <div class="heading mb-4">
    <h5 class="title text-center">Your Droids</h5>
  </div>

@foreach($user->droids as $droid)
  <div class="col-md-3 mb-5 droid-card" onclick="document.location='{{ route('droid.show', $droid->droid_uid) }}'">
    <div class="droid-card-content">
      <div style="text-align:center">
				<img src="{{ route('image.displayDroidImage', [$droid->droid_uid, 'photo_front']) }}" alt="{{ $droid->name }}" class="img-fluid mb-1 rounded" style="height:300px;">
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
						<form action="{{ route('droid.destroy', $droid->droid_uid) }}" method="POST">
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

  <div class="col-md-3 mb-5 droid-card" onclick="document.location='{{ route('droid.create') }}'">
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
        </tr>
        @foreach($user->events as $event)
          <tr>
            <td>{{ $event->date }}</td>
            <td>{{ $event->name }}</td>
            <td>{{ $event->spotter }}</td>
            <td>{{ $event->charity_raised }}</td>
            <td>
              @if(!empty($event->forum_link))
                <a class="btn btn-primary" href="{{ $event->forum_link }}">Forum</a>
              @endif
              @if(!empty($event->report_link))
                <a class="btn btn-primary" href="{{ $event->report_link }}">Report</a>
              @endif
            </td>
          </tr>
        @endforeach
      </table>
  </div>
</div>
@endsection
