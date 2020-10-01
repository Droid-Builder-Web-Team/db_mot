@extends('layouts.app')



@section('content')

<div class="row">
  <div class="col-md-12 mb-2">
    <div class="card">
      <div class="card-header">
        User Settings
      </div>
      <div class="card-body">


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
                  <td>
                    <label class="switch">
                      <input type="checkbox" name="noti_account" data-toggle="toggle" checked>
                      <span class="slider round"></span>
                    </label>
                  </td>
                </tr>
                <tr>
                  <th>MOT</th>
                  <td>
                    <label class="switch">
                      <input type="checkbox" name="noti_mot" data-toggle="toggle">
                      <span class="slider round"></span>
                    </label>
                  </td>
                </tr>
                <tr>
                  <th>Events</th>
                  <td>
                    <label class="switch">
                      <input type="checkbox" name="noti_events" data-toggle="toggle">
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
            <div class="table-responsive">
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
