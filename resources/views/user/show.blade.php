@extends('layouts.app')

@section('content')

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


<div class="row">
  <div class="col-md-12 col-lg-12 col-xl-6">
    <div class="card">
      <div class="card-header">
        <span class="float-left">
          <h2>{{ $user->forename }} {{ $user->surname }} </h2>
        </span>
        @if ($uses_pli)
          @if($user->validPLI())
            <span class="float-right">
              <a class="btn btn-cover" style="color:white;" href="{{ action('UserController@downloadPDF', $user->id )}}" target="_blank">Cover Note</a>
            </span>
          @else
            <span class="badge badge-danger float-right">
              No Valid PLI
            </span>
          @endif
          @if($has_mot && !$user->validPLI() || $user->expiringPLI())
            <span class="badge badge-warning float-right">
              <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                Pay PLI:
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="2NC9NZLY3CK58">
                <input type="hidden" name="custom" value="{{ $user->id }}">
                <input type="hidden" name="on0" value="MOT Type">
                <input type="hidden" name="os0" value="Initial/Renewal">
                <input type="hidden" name="currency_code" value="GBP">
                <input type="hidden" name="notify_url" value="{{ url('') }}/ipn/notify">
                <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_paynow_SM.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
              </form>
            </span>
          @endif
        @endif
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-sm table-hover table-dark">
                <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                <tr><th>County</th><td>{{ $user->county }}</td></tr>
                <tr><th>Postcode</th><td>{{ $user->postcode }}</td></tr>
                <tr><th>Forum Username</th><td>{{ $user->username }}</td></tr>
                <tr><th>Joined On</th><td>{{ \Carbon\Carbon::parse($user->join_date)->isoFormat($user->settings()->get('date_format'))}}</td></tr>
                @if ($uses_pli)
                    <tr><th>PLI Last Payed</th><td>{{ \Carbon\Carbon::parse($user->pli_date)->isoFormat($user->settings()->get('date_format')) }}</td></tr>
                @endif
                <tr><th>QR Code:</th>
                    <td>
                    <a href="{{ url('/')."/id/".$user->badge_id }}">
                        <img src="{{ route('image.displayQRCode',$user->id) }}" alt="qr_code" class="img-fluid mb-1 rounded" style="height:150px;">
                    </a>
                    </td>
                </tr>
            </table>
        </div>
          @can('Edit Members')
            <a class="btn btn-mot" style="color:black;" href="{{ route('admin.users.edit',$user->id) }}">Edit</a>
          @else
            <a class="btn btn-mot" style="color:black;" href="{{ route('user.edit',$user->id) }}">Edit</a>
          @endcan
      </div>
    </div>
  </div>

  <div class="col-md-6 col-sm-12 col-lg-6 col-xl-3">
    <div class="card card-mot-info">
      <div class="card-body p-3 d-flex align-items-center">
        <div class="bg-gradient-info p-3 mfe-3">
          <i class="fas fa-calendar fa-fw"></i>
        </div>
        <div>
          <div class="text-value text-info">{{ $user->attended_events->count() }}</div>
          <div class="text-muted text-uppercase font-weight-bold small">Events</div>
        </div>
      </div>
    </div>
    <div class="card card-mot-info">
      <div class="card-body p-3 d-flex">
        <div class="bg-gradient-primary p-3 mfe-3">
          <i class="fas fa-robot fa-fw"></i>
        </div>
        <div>
          <div class="text-value text-primary">{{ $user->droids->count() }}</div>
          <div class="text-muted text-uppercase font-weight-bold small">Droids</div>
        </div>
      </div>
    </div>
    @if($user->join_date != "")
      <div class="card card-mot-info">
        <div class="card-body p-3 d-flex">
          <div class="bg-gradient-success p-3 mfe-3">
            <i class="fas fa-clock fa-fw"></i>
          </div>
          <div>
            <div class="text-value text-success">{{ $user->yearsService() }}</div>
            <div class="text-muted text-uppercase font-weight-bold small">Years</div>
          </div>
        </div>
      </div>
    @else
      <div class="card card-mot-info">
        <div class="card-body p-3 d-flex">
          <div class="bg-gradient-success p-3 mfe-3">
            <i class="fas fa-clock fa-fw"></i>
          </div>
          <div>
            <div class="text-value text-success">0</div>
            <div class="text-muted text-uppercase font-weight-bold small">Years</div>
          </div>
        </div>
      </div>
    @endif
    <div class="card card-mot-info">
      <div class="card-body p-3 d-flex" >
        <div class="bg-gradient-warning p-3 mfe-3">
          <i class="fas fa-trophy fa-fw"></i>
        </div>
        <div>
          <div class="text-value text-warning">{{ $user->achievements->count()  }}</div>
          <div class="text-muted text-uppercase font-weight-bold small">Achievements</div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-6 col-lg-6 col-xl-3">
    <div class="card">
      <div class="card-header">
        <h4>ID Card Photo</h4>
      </div>
      <div class="card-body">
        <div style="text-align:center">
				  <img src="{{ route('image.displayMugShot',[$user->id, '240']) }}" alt="mug_shot" class="img-fluid mb-1 rounded">
			  </div>
			  <div class="droid-card-table" style="z-index:2">
				  <div class="droid-card-row">
					  <div class="droid-card-center noclick">
            @if( Auth::user()->can('Edit Members') || Auth::user()->id == $user->id)
            <form action="{{ route('image') }}" method="GET">
              @csrf
              <input type="hidden" name="user" value="{{ $user->id }}">
              <input type="hidden" name="droid" value=0>
              <input type="hidden" name="photo_name" value="mug_shot">
              <button type="submit" class="btn btn-mot">Change</button>
            </form>
            @endif
                </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>




<div class="row">
  <div class="col-md-12">
  <div class="card text-center">
    <div class="card-header">
      <h4 class="title text-center">Your Droids</h4>
    </div>
  <div class="card-body text-center">
    <div class="row">
@foreach($user->droids as $droid)
      <div class="col-md-3 mb-5 droid-card mx-auto mx-auto text-center" onclick="document.location='{{ route('droid.show', $droid->id) }}'">
        <div class="droid-card-content">
          <div style="text-align:center">
			      <img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_front', '240']) }}" alt="{{ $droid->name }}" class="img-fluid mb-1 rounded">
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
        <div class="col-md-3 mb-5 droid-card mx-auto" onclick="document.location='{{ route('admin.droids.create', [$user->id]) }}'">
      @else
        <div class="col-md-3 mb-5 droid-card mx-auto" onclick="document.location='{{ route('droid.create') }}'">
      @endcan
        <div class="droid-card-content">

          <div style="text-align:center">
                <i class="fas fa-plus"></i>
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
    </div>
  </div>
</div>
</div>


<div class="row">
  <div class="col-md-12 mb-2">
    <div class="card">
      <div class="card-header text-center">
        <h4 class="title text-center">Achievements</h4>
      </div>
      <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-sm table-hover table-dark text-center">
            <tr>
                <th>Name</th>
                <th>Notes</th>
                <th width=140>Date Added</th>
            </tr>
            @foreach($user->achievements as $achievement)
                <tr>
                <td>{{ $achievement->name }}</td>
                <td>{!! $achievement->pivot->notes !!}</td>
                <td>{{ Carbon\Carbon::parse($achievement->pivot->date_added)->isoFormat($user->settings()->get('date_format')) }}</td>
                </tr>
            @endforeach
          </table>
        </div>
        @can('Edit Members')
            Award Achievement
            <form action="{{ route('admin.achievements.award') }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <div class="form-row">
                <div class="col">
                  <select name="achievement_id" class="form-control">
                    @foreach($achievements as $achievement)
                      <option value="{{ $achievement->id }}">{{ $achievement->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col">
                  <input type="text" class="form-control" name="notes">
                </div>
                <div class="col">
                  <input type="date" class="form-control" name="date" value="
                  @php
                    echo date("Y-m-d");
                  @endphp
                  ">
                </div>
                <div class="col">
                  <input type="submit" class="btn-sm btn-primary" name="comment" value="Award">
                </div>
              </div>
          </form>
        @endcan
        <span class="float-right">
          <a class="btn btn-edit" href="{{ route('achievements.index')}}">View All</a>
        </span>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 mb-2">
    <div class="card">
      <div class="card-header text-center">
        <h4 class="title text-center">Events</h4>
      </div>
      <div class="card-body text-center">
        <div class="table-responsive">
            <table class="table table-striped table-sm table-hover table-dark text-center">
            <tr>
                <th>Date</th>
                <th>Details</th>
                <th>Location</th>
                <th>Charity Raised</th>
                <th></th>
            </tr>
            @foreach($user->attended_events as $event)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($event->date)->isoFormat($user->settings()->get('date_format'))}}</td>
                    <td>{{ $event->name }}</td>
                    <td><a class="btn-sm btn-link" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
                    <td>{{ $event->charity_raised }}</td>
                    <td><a class="btn-sm btn-view" href="{{ route('event.show', $event->id) }}"><i class="fas fa-eye"></a></td>
                </tr>
            @endforeach
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-5">
  <div class="col-md-12 mb-2">
    <div class="card">
      <div class="card-header text-center">
        <h4 class="title text-center">Driving Course Runs</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-sm table-hover table-dark text-center">
            <tr>
                <th>Run Date</th>
                <th>Droid Name</th>
                <th>Penalties</th>
                <th>Final Time</th>
                <th></th>
            </tr>
            @foreach($user->course_runs as $course_run)
                <tr>
                <td>{{ Carbon\Carbon::parse($course_run->run_timestamp)->isoFormat($user->settings()->get('date_format')) }}</td>
                <td>{{ $course_run->droid->name }}</td>
                <td>
                    @if ($course_run->num_penalties == 0)
                    <a class="btn-sm btn-success">{{ $course_run->num_penalties }}</a>
                    @elseif ($course_run->num_penalties == 1)
                    <a class="btn-sm btn-warning">{{ $course_run->num_penalties }}</a>
                    @else
                    <a class="btn-sm btn-danger">{{ $course_run->num_penalties }}</a>
                    @endif
                </td>
                <td>{{ formatMilliseconds($course_run->final_time)}}</td>
                <td><a class="btn-sm btn-view" href="{{ route('runs.show', $course_run->id) }}"><i class="fas fa-eye"></a></td>
                </tr>
            @endforeach
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
