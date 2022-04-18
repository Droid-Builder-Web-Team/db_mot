@extends('layouts.app')
@section('content')
  @php
  $uses_pli = 0;
  $has_mot = 0;
  @endphp
  @foreach ($user->droids as $droid)
    @if ($droid->club->hasOption('mot'))
      @php
        $uses_pli = 1;
      @endphp
      @if ($droid->hasMOT() && !$droid->hasExpiringMOT())
        @php
          $has_mot = 1;
        @endphp
      @endif
    @endif
  @endforeach

  {{-- User Information --}}
  <div class="build-section outer">
    <div class="container-fluid">
      <div class="row build-section inner">
        <div class="col-12 col-lg-6">
          <div class="profile-title">
            <h4>{{ $user->forename }} {{ $user->surname }}</h4>

            @if ($uses_pli)
              @if ($user->validPLI())
                <div class="pli-box-blank">
                  <a href="{{ action('UserController@downloadPDF', $user->id) }}" class="btn btn-view" target="_blank">
                    Cover Note
                  </a>
                </div>
              @else
                <div class="pli-box-red">
                  <span class="no-pli">
                    No Valid PLI
                  </span>
                </div>
              @endif
            @endif
          </div>

          {{-- User Table --}}
          <div class="table-responsive db-mt-2 user-table">
            <table class="table text-center table-hover">
              <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>County</th>
                <td>{{ $user->county }}</td>
              </tr>
              <tr>
                <th>Postcode</th>
                <td>{{ $user->postcode }}</td>
              </tr>
              <tr>
                <th>Country</th>
                <td>{{ $user->country }}</td>
              </tr>
              <tr>
                <th>Forum Username</th>
                <td>{{ $user->username }}</td>
              </tr>
              <tr>
                <th>Joined On</th>
                <td>{{ \Carbon\Carbon::parse($user->join_date)->isoFormat($user->settings()->get('date_format')) }}</td>
              </tr>
              @if ($uses_pli)
                <tr>
                  <th>PLI Last Paid</th>
                  <td>
                    @if ($user->pli_date != null)
                      {{ \Carbon\Carbon::parse($user->pli_date)->isoFormat($user->settings()->get('date_format')) }}
                    @else
                      <h6>N/A</h6>
                    @endif
                  </td>
                </tr>
              @endif
              <tr>
                <th>QR Code:</th>
                <td>
                  <a href="{{ url('/') . '/id/' . $user->badge_id }}">
                    <img src="{{ route('image.displayQRCode', $user->id) }}" alt="qr_code" class="mb-1 rounded img-fluid" style="height:150px;">
                  </a>
                </td>
              </tr>
            </table>

            <div class="buttons">
              @can('Edit Members')
                <a class="btn btn-edit" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
              @else
                <a class="btn btn-edit" href="{{ route('user.edit', $user->id) }}">Edit</a>
              @endcan
            </div>
          </div>
        </div>

        {{-- Photo Card --}}
        <div class="col-12 col-lg-6 user-photo-col">
          <h4 class="text-uppercase text-center">ID Card Photo</h4>
          <div class="id-photo-wrapper d-flex justify-content-center">
            <img src="{{ route('image.displayMugShot', [$user->id, '240']) }}" alt="mug_shot" class="img-fluid">
          </div>

          <div class="id-photo-button mt-2 d-flex justify-content-center">
            @if (Auth::user()->can('Edit Members') || Auth::user()->id == $user->id)
              <form action="{{ route('image') }}" method="GET">
                @csrf
                <div class="input-group">
                  <input type="hidden" name="user" value="{{ $user->id }}">
                  <input type="hidden" name="droid" value=0>
                  <input type="hidden" name="photo_name" value="mug_shot">
                  <div class="buttons">
                    <button type="submit" class="btn btn-edit">Change Photo</button>
                  </div>
                </div>
              </form>
            @endif
          </div>
        </div>

        {{-- Stat Boxes --}}
        <div class="db-mt-2 stat-group">
          <div class="user-stats-box">
            <div class="icon-wrapper blue">
              <i class="fas fa-calendar fa-fw"></i>
            </div>
            <div class="user-stat">
              <p class="text-value text-info">{{ $user->attended_events->count() }}</p>
              <p class="text-muted text-uppercase font-weight-bold">Events</p>
            </div>
          </div>
          <div class="user-stats-box">
            <div class="icon-wrapper purple">
              <i class="fas fa-robot fa-fw"></i>
            </div>
            <div class="user-stat">
              <p class="text-value text-info">{{ $user->droids->count() }}</p>
              <p class="text-muted text-uppercase font-weight-bold">Droids</p>
            </div>
          </div>

          <div class="user-stats-box">
            <div class="icon-wrapper green">
              <i class="fas fa-clock fa-fw"></i>
            </div>
            <div class="user-stat">
              @if ($user->join_date != '')
                <p class="text-value text-info">{{ $user->yearsService() }}</p>
              @else
                <p class="text-value text-info">0</p>
              @endif
              <p class="text-muted text-uppercase font-weight-bold">Years</p>
            </div>
          </div>

          <div class="user-stats-box">
            <div class="icon-wrapper orange">
              <i class="fas fa-trophy fa-fw"></i>
            </div>
            <div class="user-stat">
              <p class="text-value text-info">{{ $user->achievements->count() }}</p>
              <p class="text-muted text-uppercase font-weight-bold">Achievements</p>
            </div>
          </div>
          <div class="user-stats-box">
            <div class="icon-wrapper red">
              <i class="fas fa-pound-sign"></i>
            </div>
            <div class="user-stat">
              <p class="text-value text-info">{{ $user->attended_events->sum('charity_raised') }}</p>
              <p class="text-muted text-uppercase font-weight-bold">Raised For Charity</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Droids --}}
      @if ($user->droids->count() != 0)
        <div class="row build-section inner db-my-2">
          <div class="col-12 text-center">
            <h4 class="text-uppercase text-center">My Droids</h4>
            <div class="row d-block db-my-1">
              @can('Edit Droids')
                <div class="col-12 d-flex justify-content-center text-center">
                  <button class="btn btn-standard new-droid" onclick="document.location='{{ route('admin.droids.create', [$user->id]) }}'">
                    <i class="fas fa-plus"></i>
                    <h5>Add a Droid</h5>
                  </button>
                </div>
              @else
                <div class="col-12 d-flex justify-content-center text-center">
                  <button class="btn btn-standard new-droid" onclick="document.location='{{ route('droid.create') }}'">
                    <i class="fas fa-plus"></i>
                    <h5>Add a Droid</h5>
                  </button>
                </div>
              @endcan
            </div>
            <div class="row d-flex justify-content-center">
              @foreach ($user->droids as $droid)
                <div class="col-12 col-lg-4 db-mb-2 d-flex justify-content-center">
                  <div class="my-droid-card">
                    <button class="my-droid" onclick="document.location='{{ route('droid.show', $droid->id) }}'">
                      <img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_front', '240']) }}" alt="{{ $droid->name }}" class="mb-1 rounded img-fluid">
                    </button>
                    <div class="droid-body-text">
                      {{-- Functionality To Add - Generate Datasheet for Droid to share --}}
                      <div class="share" data-toggle="modal" data-target="#comingSoon">
                        <i class="fas fa-share-alt"></i>
                      </div>

                      <h4 class="db-mt-1 text-center uppercase">{{ $droid->name }}</h4>

                      <div class="delete" data-toggle="modal" data-target="#confirmDelete">
                        <i class="fas fa-trash-alt"></i>
                      </div>
                    </div>
                    @if ($droid->club->hasOption('mot'))
                      <div class="pli-container noclick">
                        <h5 class="pli-text">@include('partials.motstatus', $droid->displayMOT())</h5>
                      </div>
                    @else
                      <div class="no-mot-block">
                        <h5>N/A</h5>
                      </div>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="modal fade" id="comingSoon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Coming Soon</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Sharing Functionality is on its way!</p>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('droid.destroy', $droid->id) }}" method="POST" onsubmit="return confirmDeleteDroid(event)">
                    @csrf
                    {{ method_field('DELETE') }}
                    <p>Please confirm you wish to delete this droid. This action cannot be undone.</p>
                    <button type="submit" class="btn btn-delete">Delete Droid</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="row build-section inner db-my-2">
          <div class="col-12 text-center">
            <h4 class="text-uppercase text-center">My Droids</h4>
            <div class="row d-block db-my-1">
              @can('Edit Droids')
                <div class="col-12 d-flex justify-content-center text-center">
                  <button class="btn btn-standard new-droid" onclick="document.location='{{ route('admin.droids.create', [$user->id]) }}'">
                    <i class="fas fa-plus"></i>
                    <h5>Add a Droid</h5>
                  </button>
                </div>
              @else
                <div class="col-12 d-flex justify-content-center text-center">
                  <button class="btn btn-standard new-droid" onclick="document.location='{{ route('droid.create') }}'">
                    <i class="fas fa-plus"></i>
                    <h5>Add a Droid</h5>
                  </button>
                </div>
              @endcan
            </div>

            <div class="row d-flex justify-content-center">
              <h4 class="db-my-2">You have no droids yet! Add a droid to begin</h4>
            </div>
          </div>
        </div>
      @endif

      {{-- Achievements --}}
      <div class="row build-section inner db-mb-2 achievements">
        <div class="col-12">
          <h4 class="text-center text-uppercase">Achievements</h4>
        </div>

        @can('Edit Members')
          <div class="col-12 text-center new-achievement">
            <h6>Add new Achievement</h6>
            <form action="{{ route('admin.achievements.award') }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <div class="form-row mb-4">
                <div class="col-12 col-lg-3 achievement-col-fields">
                  <select name="achievement_id" class="form-control">
                    @foreach ($achievements as $achievement)
                      <option value="{{ $achievement->id }}">{{ $achievement->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-12 col-lg-3 achievement-col-fields">
                  <input type="text" class="form-control" name="notes" placeholder="Reason for Award">
                </div>
                <div class="col-12 col-lg-3 achievement-col-fields">
                  <input type="date" class="form-control" name="date" value="@php echo date('Y-m-d'); @endphp">
                </div>
                <div class="col-12 col-lg-3 achievement-col-fields">
                  <button type="submit" class=" btn-sm w-100 btn btn-edit">Award</button>
                </div>
              </div>
            </form>
          </div>
        @endcan

        @if ($user->achievements->count() != 0)
          <div class="table-responsive achievements-table">
            <table class="table text-center table-hover">
              <tr>
                <th>Name</th>
                <th>Reason for Award</th>
                <th>Date Awarded</th>
              </tr>

              @foreach ($user->achievements as $achievement)
                <tr>
                  <td>{{ $achievement->name }}</td>
                  <td>{!! $achievement->pivot->notes !!}</td>
                  <td>{{ Carbon\Carbon::parse($achievement->pivot->date_added)->isoFormat($user->settings()->get('date_format')) }}</td>
                </tr>
              @endforeach
            </table>
          </div>
        @else
          <h4 class="db-my-2">No Achievements Yet!</h4>
        @endif

        <div class="col-12">
          <div class="buttons">
            <a class="btn btn-view" href="{{ route('achievements.index') }}">View All Achievements</a>
          </div>
        </div>
      </div>

      {{-- Events To Finish --}}
      <div class="row build-section inner text-center db-mb-2 events">
        <div class="col-12 text-center">
          <h4 class="text-center text-uppercase">Events</h4>
          <div class="buttons">
            <a class="btn btn-view" href="/ical/{{ $user->calendar_id }}" target="_blank">iCal</a>
          </div>

          @if ($user->attended_events->count() != 0)
            <div class="table-responsive">
              <table class="table text-center table-hover">
                <tr>
                  <th>Date</th>
                  <th>Details</th>
                  <th>Location</th>
                  <th>Charity Raised</th>
                </tr>

                @foreach ($user->goingTo as $event)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($event->date)->isoFormat($user->settings()->get('date_format')) }}</td>
                    <td>{{ $event->name }}</td>
                    <td><a class="btn-view btn-sml" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
                    <td>-</td>
                    <td><a class="btn-view" href="{{ route('event.show', $event->id) }}"></a></td>
                  </tr>
                @endforeach
                <tr>
                  <th colspan=5>Attended</th>
                </tr>
                @foreach ($user->attended_events as $event)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($event->date)->isoFormat($user->settings()->get('date_format')) }}</td>
                    <td>{{ $event->name }}</td>
                    <td><a class="btn-sml btn-view" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
                    <td>£­{{ $event->charity_raised }}</td>
                    <td><a class="btn-view" href="{{ route('event.show', $event->id) }}"><i class="fas fa-eye"></a></td>
                  </tr>
                @endforeach
              </table>
            </div>
          @else
            <h4 class="db-my-2">You have not attended any events yet!</h4>
          @endif
        </div>
      </div>

      <div class="row build-section inner text-center db-mb-2 course-runs">
        <div class="col-12">
          <h4 class="text-center text-uppercase">Driving Course Runs</h4>

          @if ($user->course_runs->count() != 0)
            <div class="table-responsive">
              <table class="text-center table-hover">
                <tr>
                  <th>Run Date</th>
                  <th>Droid Name</th>
                  <th>Penalties</th>
                  <th>Final Time</th>
                  <th></th>
                </tr>
                @foreach ($user->course_runs as $course_run)
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
                    <td>{{ formatMilliseconds($course_run->final_time) }}</td>
                    <td><a class="btn-sm btn-view" href="{{ route('runs.show', $course_run->id) }}"><i class="fas fa-eye"></a></td>
                  </tr>
                @endforeach
              </table>
            </div>
          @else
            <h4 class="db-my-2">Take a drive on the driving course to view your times!</h4>
          @endif

        </div>
      </div>
    </div>
  </div>
@endsection
