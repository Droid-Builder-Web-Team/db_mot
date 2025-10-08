@extends('layouts.app')



@section('content')


    <div class="row">
        <div class="col-md-12 mb-2">
            {{-- <div class="card">
                <div class="card-header">
                    User Settings
                </div> --}}
            {{-- <div class="card-body"> --}}

                <div class="card">
                    <div class="card-header">
                        Two-Factor Authentication (2FA)
                    </div>
                    <div class="card-body">
                        <h5 class="mb-3">
                            @if (auth()->user()->two_factor_secret)
                                @if (auth()->user()->two_factor_confirmed_at)
                                    <span class="text-success">2FA is Enabled.</span>
                                @else
                                    <span class="text-warning">2FA Setup Pending Confirmation.</span>
                                @endif
                            @else
                                <span class="text-danger">2FA is Not Enabled.</span>
                            @endif
                        </h5>
                
                        {{-- Session Status Messages (from Fortify actions) --}}
                        @if (session('status') == 'two-factor-authentication-enabled')
                            <div class="alert alert-success">
                                **Two-Factor Authentication Enabled!** Please scan the QR code and confirm the token to finish the setup.
                            </div>
                        @endif
                
                        @if (session('status') == 'two-factor-authentication-disabled')
                            <div class="alert alert-danger">
                                Two-Factor Authentication has been disabled.
                            </div>
                        @endif
                
                        @error('code')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                
                        {{-- 1. DISPLAY QR CODE & CONFIRMATION (If Secret exists but is NOT confirmed) --}}
                        @if (auth()->user()->two_factor_secret && ! auth()->user()->two_factor_confirmed_at)
                            <div class="mb-4">
                                <p>Scan the following QR code using your phone's authenticator application (e.g., Google Authenticator, Authy).</p>
                                {{-- WARNING: Must use {!! !!} to render raw SVG --}}
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>
                
                            <form action="{{ route('two-factor.confirm') }}" method="POST" class="mt-4">
                                @csrf
                                <div class="form-group row">
                                    <label for="code" class="col-md-4 col-form-label text-md-right">Confirmation Code</label>
                                    <div class="col-md-6">
                                        <input id="code" type="text" class="form-control" name="code" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Confirm 2FA Setup</button>
                                    </div>
                                </div>
                            </form>
                
                            <hr>
                        @endif
                
                
                        {{-- 2. DISPLAY RECOVERY CODES & DISABLE BUTTON (If CONFIRMED and Enabled) --}}
                        @if (auth()->user()->two_factor_secret && auth()->user()->two_factor_confirmed_at)
                            <div class="mb-4">
                                <p>Your two-factor authentication is active. Use the buttons below to view/regenerate recovery codes or disable the feature.</p>
                
                                {{-- Recovery Codes Section --}}
                                <h6 class="mt-4">Recovery Codes:</h6>
                                @if (session('status') == 'recovery-codes-generated')
                                    <div class="alert alert-warning">
                                        **NEW** Recovery Codes Generated! Please store these immediately!
                                    </div>
                                @endif
                                
                                <div class="card card-body bg-dark text-white p-2">
                                    <div class="row">
                                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                            <div class="col-md-6">{{ $code }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <small class="form-text text-muted">Store these codes in a secure location. They can be used to log in if you lose access to your authenticator device.</small>
                
                                {{-- Regenerate Recovery Codes --}}
                                <form action="{{ route('two-factor.recovery-codes') }}" method="POST" class="d-inline-block mt-3 mr-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">Regenerate Recovery Codes</button>
                                </form>
                                
                                {{-- Disable 2FA --}}
                                <form action="{{ route('two-factor.disable') }}" method="POST" class="d-inline-block mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Disable 2FA</button>
                                </form>
                                
                            <hr>
                        @endif
                
                        {{-- 3. ENABLE BUTTON (If NOT Enabled) --}}
                        @if (! auth()->user()->two_factor_secret)
                            <p>Two-Factor Authentication adds an extra layer of security to your account.</p>
                            <form action="{{ route('two-factor.enable') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Enable 2FA</button>
                            </form>
                        @endif
                        
                    </div>
                </div>


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
