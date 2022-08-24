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
    <div class="row">
        {{-- User Details --}}
        <div class="col-12 col-xl-6 mb-4">
            <div class="user card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="float-left">
                        <h2>{{ $user->forename }} {{ $user->surname }} </h2>
                    </span>
                    @if ($uses_pli)
                        @if ($user->validPLI())
                            <span class="float-right">
                                <a class="btn btn-cover" style="color:white;" href="{{ action('UserController@downloadPDF', $user->id) }}" target="_blank">Cover Note</a>
                            </span>
                        @else
                            <span class="float-right badge badge-danger">
                                No Valid PLI
                            </span>
                        @endif
                        @if (($has_mot && !$user->validPLI()) || $user->expiringPLI())
                            <span class="float-right badge badge-warning">
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    Pay PLI:
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="2NC9NZLY3CK58">
                                    <input type="hidden" name="custom" value="{{ $user->id }}">
                                    <input type="hidden" name="on0" value="MOT Type">
                                    <input type="hidden" name="os0" value="Initial/Renewal">
                                    <input type="hidden" name="currency_code" value="GBP">
                                    <input type="hidden" name="notify_url" value="{{ url('') }}/ipn/notify">
                                    <input type="hidden" name="return" value="{{ url('') }}/user/{{ $user->id }}">
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
                                @if ($user->join_date == null)
                                    <td>Unknown</td>
                                @else
                                    <td>{{ \Carbon\Carbon::parse($user->join_date)->isoFormat($user->settings()->get('date_format')) }}</td>
                                @endif
                            </tr>
                            @if ($uses_pli)
                                <tr>
                                    <th>PLI Last Paid</th>
                                    <td>
                                        @if ($user->pli_date != null)
                                            {{ \Carbon\Carbon::parse($user->pli_date)->isoFormat($user->settings()->get('date_format')) }}
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
                    </div>
                    <div class="text-center edit-button">
                        @can('Edit Members')
                            <a class="btn btn-transparent-outline-blue" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                        @else
                            <a class="btn btn-transparent-outline-blue" href="{{ route('user.edit', $user->id) }}">Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        {{-- User Stats --}}
        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-3 mb-4">
            <div class="card card-mot-info">
                <div class="p-3 card-body d-flex align-items-center">
                    <div class="p-3 bg-gradient-info mfe-3">
                        <i class="fas fa-calendar fa-fw"></i>
                    </div>
                    <div>
                        <div class="text-value text-info">{{ $user->attended_events->count() }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Events</div>
                    </div>
                </div>
            </div>
            <div class="card card-mot-info">
                <div class="p-3 card-body d-flex">
                    <div class="p-3 bg-gradient-primary mfe-3">
                        <i class="fas fa-robot fa-fw"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ $user->droids->count() }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Droids</div>
                    </div>
                </div>
            </div>
            @if ($user->join_date != '')
                <div class="card card-mot-info">
                    <div class="p-3 card-body d-flex">
                        <div class="p-3 bg-gradient-success mfe-3">
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
                    <div class="p-3 card-body d-flex">
                        <div class="p-3 bg-gradient-success mfe-3">
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
                <div class="p-3 card-body d-flex">
                    <div class="p-3 bg-gradient-warning mfe-3">
                        <i class="fas fa-trophy fa-fw"></i>
                    </div>
                    <div>
                        <div class="text-value text-warning">{{ $user->achievements->count() }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Achievements</div>
                    </div>
                </div>
            </div>
            <div class="card card-mot-info">
                <div class="p-3 card-body d-flex align-items-center">
                    <div class="p-3 bg-gradient-info mfe-3">
                        <i class="fas fa-pound-sign"></i>
                    </div>
                    <div>
                        <div class="text-value text-info">£{{ $user->attended_events->sum('charity_raised') }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Raised For Charity</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- User Image --}}
        <div class="col-md-6 col-lg-6 col-xl-3 mb-4">
            <div class="user card">
                <div class="card-header">
                    <h4>ID Card Photo</h4>
                </div>
                <div class="card-body">
                    <div class="id-photo-wrapper">
                        <img src="{{ route('image.displayMugShot', [$user->id, '240']) }}" alt="mug_shot" class="img-fluid">
                    </div>

                    <div class="id-photo-button mt-2 d-flex justify-content-center">
                        @if (Auth::user()->can('Edit Members') || Auth::user()->id == $user->id)
                            <form action="{{ route('image') }}" method="GET">
                                @csrf
                                <input type="hidden" name="user" value="{{ $user->id }}">
                                <input type="hidden" name="droid" value=0>
                                <input type="hidden" name="photo_name" value="mug_shot">
                                <button type="submit" class="btn btn-transparent-outline-blue">Change</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- User Droids --}}
    <div class="row">
        <div class="col-12">
            <div class="text-center card">
                <div class="card-header">
                    <h4 class="text-center title">Your Droids</h4>
                </div>
                <div class="text-center card-body">
                    <div class="row">
                        @foreach ($user->droids as $droid)
                            <div class="mx-auto my-auto text-center col-md-3 droid-card">
                                <div class="droid-card-content">
                                    <div style="text-align:center" onclick="document.location='{{ route('droid.show', $droid->id) }}'">
                                        <img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_front', '240']) }}" alt="{{ $droid->name }}" class="mb-1 rounded img-fluid">
                                    </div>

                                    <div class="droid-card-table" style="z-index:2">
                                        <div class="droid-card-row">
                                            <div class="droid-card-left">
                                                <form action="">
                                                    <input type="image" src="/img/share.png">
                                                </form>
                                            </div>
                                            <div class="droid-card-center noclick" onclick="document.location='{{ route('droid.show', $droid->id) }}'">
                                                <h2 style="margin-bottom:0px">{{ $droid->name }}</h2>
                                            </div>
                                            <div class="droid-card-right">
                                                <form action="{{ route('droid.destroy', $droid->id) }}" method="POST" onsubmit="return confirmDeleteDroid(event)">
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
                            <div class="mx-auto my-auto col-md-3 droid-card" onclick="document.location='{{ route('admin.droids.create', [$user->id]) }}'">
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
                        @else
                            <div class="mx-auto my-auto col-md-3 droid-card" onclick="document.location='{{ route('droid.create') }}'">
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
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- User Achievements --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="text-center card-header">
                    <h4 class="text-center title">Achievements</h4>
                </div>
                <div class="card-body">
                    @can('Edit Members')
                    <div class="new-award d-flex justify-content-center d-flex flex-column text-center">
                        <p class="mb-2">Award New Achievement</p>
                        <form action="{{ route('admin.achievements.award') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="form-row mb-4">
                                <div class="col">
                                    <select name="achievement_id" class="form-control">
                                        @foreach ($achievements as $achievement)
                                            <option value="{{ $achievement->id }}">{{ $achievement->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="notes" placeholder="Award Notes">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" name="date" value="@php echo date('Y-m-d'); @endphp">
                                </div>
                                <div class="col">
                                    <button type="submit" class=" btn-sm w-100 btn btn-transparent-outline-blue">Award</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endcan
                    @if($user->achievements->count() != 0)
                    <div class="table-responsive">
                        <table class="table text-center table-striped table-sm table-hover table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Notes</th>
                                <th width=140>Date Added</th>
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
                    <span class="float-right">
                        <a class="btn btn-transparent-outline-blue" href="{{ route('achievements.index') }}">View All</a>
                    </span>
                    @else
                    <span class="float-center">
                        Achievements can be gained for certain actions. Click the button below to find out more<br>
                        <a class="btn btn-transparent-outline-blue" href="{{ route('achievements.index') }}">View All</a>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- User Events --}}
    @if($user->events->count() != 0)
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="text-center card-header">
                    <span class="float-right">
                        <a class="btn btn-cover" style="color:white;" href="/ical/{{ $user->calendar_id }}" target="_blank">iCal</a>
                    </span>
                    <h4 class="text-center title">Events</h4>
                </div>
                <div class="text-center card-body">
                    <div class="table-responsive">
                        <table class="table text-center table-striped table-sm table-hover table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Location</th>
                                <th>Charity Raised</th>
                                <th></th>
                            </tr>
                            <tr><th colspan=5>Upcoming</th></tr>
                            @foreach ($user->goingTo as $event)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($event->date)->isoFormat($user->settings()->get('date_format')) }}</td>
                                    <td>{{ $event->name }}</td>
                                    <td><a class="btn-sml btn-transparent-outline-view-event" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
                                    <td>-</td>
                                    <td><a class="btn-outline-icon-view" href="{{ route('event.show', $event->id) }}"><i class="fas fa-eye"></a></td>
                                </tr>
                            @endforeach
                            <tr><th colspan=5>Attended</th></tr>
                            @foreach ($user->attended_events as $event)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($event->date)->isoFormat($user->settings()->get('date_format')) }}</td>
                                    <td>{{ $event->name }}</td>
                                    <td><a class="btn-sml btn-transparent-outline-view-event" href="{{ route('location.show', $event->location->id) }}">{{ $event->location->name }}</a></td>
                                    <td>£­{{ $event->charity_raised }}</td>
                                    <td><a class="btn-outline-icon-view" href="{{ route('event.show', $event->id) }}"><i class="fas fa-eye"></a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Driving Course --}}
    @if($user->course_runs->count() != 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="text-center card-header">
                    <h4 class="text-center title">Driving Course Runs</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-center table-striped table-sm table-hover table-dark">
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
                </div>
            </div>
        </div>
        @endif

    @endsection
