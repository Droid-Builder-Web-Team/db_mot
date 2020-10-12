@extends('layouts.app')



@section('content')

<div class="row">
  <div class="col-md-12 mb-2">
    <div class="card">
      <div class="card-header">
        User Settings
      </div>
      <div class="card-body">
        <form action="{{ route('settings.update',Auth::user()->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
          <div class="card-header">
            Email Notifications
          </div>
          <div class="card-body">
            Toggle all
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
                  <td>Get emails about new events, and updates/reminders about events you are subscribed to</td>
                  <td>
                    <label class="switch">
                      <input type="hidden" name="notifications[event]" value="off">
                      <input type="checkbox" name="notifications[event]" data-toggle="toggle" {{ $settings['notifications']['event'] == 'on' ? 'checked' : '' }}>
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
        <input type="submit" class="btn btn-mot">
      </div>
    </div>
  </div>
</div>

@endsection
