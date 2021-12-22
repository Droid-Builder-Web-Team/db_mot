@extends('layouts.app')



@section('content')

    <div class="row">
        <div class="col-md-12 mb-2">
            {{-- <div class="card">
                <div class="card-header">
                    User Settings
                </div> --}}
            {{-- <div class="card-body"> --}}
            <form action="{{ route('settings.update', Auth::user()->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        Email Notifications
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover table-dark text-center">
                                <tr>
                                    <th>Account</th>
                                    <td>Get emails about the status of your account, eg. expiring or expired PLI</td>
                                    <td>
                                        <label class="switch">
                                            <input type="hidden" name="notifications[account]" value="off">
                                            <input type="checkbox" name="notifications[account]" data-toggle="toggle" {{ $settings['notifications']['account'] == 'on' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>MOT</th>
                                    <td>Get emails regarding your droid MOT status, eg. expiring or expired</td>
                                    <td>
                                        <label class="switch">
                                            <input type="hidden" name="notifications[mot]" value="off">
                                            <input type="checkbox" name="notifications[mot]" data-toggle="toggle" {{ $settings['notifications']['mot'] == 'on' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Events</th>
                                    <td>Get emails about new events</td>
                                    <td>
                                        <label class="switch">
                                            <input type="hidden" name="notifications[event]" value="off">
                                            <input type="checkbox" name="notifications[event]" data-toggle="toggle" {{ $settings['notifications']['event'] == 'on' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Broadcasts</th>
                                    <td>Get emails for broadcast comments from event organisers, part runs, etc. that you have registered interest in.</td>
                                    <td>
                                        <label class="switch">
                                            <input type="hidden" name="notifications[broadcast]" value="off">
                                            <input type="checkbox" name="notifications[broadcast]" data-toggle="toggle" {{ $settings['notifications']['broadcast'] == 'on' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Achievements</th>
                                    <td>Get emails when you have been granted a new achievement</td>
                                    <td>
                                        <label class="switch">
                                            <input type="hidden" name="notifications[achievement]" value="off">
                                            <input type="checkbox" name="notifications[achievement]" data-toggle="toggle" {{ $settings['notifications']['achievement'] == 'on' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                  <div class="card-header">
                    Display Preferences
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-sm table-hover table-dark text-center">
                        <tr>
                          <th>Date Format</th>
                          <td>Format to display dates</td>
                          <td>
                            <select id="date_format" name="date_format">
                              @php
                                $formats = ['YYYY-MM-DD', 'YYYY/MM/DD', 'DD/MM/YYYY', 'DD MMM YYYY', 'YY/MM/DD', 'DD/MM/YY'];
                              @endphp
                              @foreach($formats as $format)
                                <option value='{{ $format }}'
                                @if($format == $settings['date_format'])
                                  selected
                                @endif
                                >{{ $format }} </option>
                              @endforeach
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <th>Time Format</th>
                          <td>24 Hour or 12 Hour clock</td>
                          <td>
                            <select id="time_format" name="time_format">
                                <option value='HH:mm:ss'
                                @if($settings['time_format'] == 'HH:mm:ss')
                                  selected
                                @endif
                                >24H</option>
                                <option value='hh:mm:ss a'
                                @if($settings['time_format'] == 'hh:mm:ss a')
                                  selected
                                @endif
                                >12H</option>
                            </select>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Event Requirements
                    </div>
                    <div class="card-body">
                        Requirements for getting notifications about new events added
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover table-dark text-center">
                                <tr>
                                    <th>Distance</th>
                                    <td>Max distance from the postcode in your user profile (miles)</td>
                                    <td>
                                        <input type="text" name="max_event_distance" value="{{ $settings['max_event_distance'] }}">
                                    </td>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <input type="submit" class="btn btn-mot btn-mot--light" style="max-width: 200px;">
                </div>

            </form>
        </div>
    </div>

@endsection
