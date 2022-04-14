@extends('layouts.app')

@section('content')
  <div class="build-section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-center">
          <h4 class="db-my-1">Editing Droid - {{ $droid->name }}</h4>
          <div class="buttons">
            <a class="btn btn-back" href="{{ url()->previous() }}">Back</a>
          </div>
        </div>
      </div>

      <div class="col-12">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>

      <div class="row build-section">
        <div class="col-12">
          <form action="{{ route('droid.store') }}" method="POST">
            @csrf
            <div class="row form-group">
              <div class="col-12 col-lg-8 order-12 order-lg-1">
                <label for="name">Droid Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $droid->name }}">
                <small id="nameHelp" class="form-text text-muted">What is the name of your droid? PRO TIP: Builders usually create droid names but using their own initials!</small>
              </div>

              <div class="col-12 col-lg-4 order-1 order-lg-12">
                <label for="club">Club:</label>
                <select class="custom-select" id="club" name="club_id">
                  @foreach ($clubs as $club)
                    <option value="{{ $club->id }}">{{ $club->name }}</option>
                  @endforeach
                </select>
                <small id="clubHelp" class="form-text text-muted">Which club does this droid belong to?</small>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-lg-8">
                <label for="style">Style:</label>
                <input type="text" id="style" name="style" class="form-control" value="{{ $droid->style }}">
                <small id="styleHelp" class="form-text text-muted">A New Hope, Prequels, Custom etc</small>
              </div>

              <div class="col-12 col-lg-4">
                <label for="build_log">Build Log:</label>
                <input type="text" id="build_log" name="build_log" class="form-control" value="{{ $droid->build_log }}">
                <small id="buildLogHelp" class="form-text text-muted">A link to your build log - Astromech Forum, Custom website etc</small>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-lg-8">
                <label for="transmitter_type">Control System:</label>
                <input type="text" name="transmitter_type" class="form-control" value="{{ $droid->transmitter_type }}">
                <small id="transmitterTypeHelp" class="form-text text-muted">Kyber, Padawan360, Stealth etc</small>
              </div>

              <div class="col-12 col-lg-4">
                <label for="radio_controlled">Radio Controlled</label>
                <select class="custom-select" id="radio_controlled" name="radio_controlled">
                  <option value="No" <?php echo $droid->radio_controlled == 'No' ? 'selected' : ''; ?>>No</option>
                  <option value="Yes" <?php echo $droid->radio_controlled == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                </select>
                <small id="radioControlledHelp" class="form-text text-muted">Are you using a traditional R/C System?</small>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-lg-8">
                <label for="material">Build Material:</label>
                <input type="text" id="material" name="material" class="form-control" value="{{ $droid->material }}">
                <small id="materialHelp" class="form-text text-muted">What material are you using? Aluminium, Wood, Styrene, Hybrid?</small>
              </div>
              <div class="col-12 col-lg-4">
                <label for="sound_system">Sound System:</label>
                <input type="text" id="sound_system" name="sound_system" class="form-control" value="{{ $droid->sound_system }}">
                <small id="soundSystemHelp" class="form-text text-muted">What Sound System will you use?</small>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-lg-8">
                <label for="battery_type">Battery Type:</label>
                <input type="text" name="battery" class="form-control" value="{{ $droid->battery }}">
                <small id="batteryTypeHelp" class="form-text text-muted">SLA, LiPo, LiFePo etc</small>
              </div>
              <div class="col-12 col-lg-4">
                <label for="voltage">Voltage:</label>
                <input type="text" name="drive_voltage" class="form-control" value="{{ $droid->drive_voltage }}">
                <small id="voltageHelp" class="form-text text-muted">What voltage will you be running your droid at?</small>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-lg-8">
                <label for="drive_type">Drive System:</label>
                <input type="text" name="drive_type" class="form-control" value="{{ $droid->drive_type }}">
                <small id="driveTypeHelp" class="form-text text-muted">Scavenger Drives, Senna, Warp Drives etc</small>
              </div>
              <div class="col-12 col-lg-4"></div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-lg-8">
                <label for="value">Approximate Value:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">£</span>
                  </div>
                  <input type="text" name="value" class="form-control" value="{{ $droid->value }}">
                </div>
                <small id="valueHelp" class="form-text text-muted">This number is hidden from family at your request!</small>
              </div>

              <div class="col-12 col-lg-4">
                <label for="weight">Approximate Weight</label>
                <div class="input-group">
                  <input type="text" name="weight" class="form-control" value="{{ $droid->weight }}">
                  <div class="input-group-append">
                    <span class="input-group-text">Kg</span>
                  </div>
                </div>
                <small id="weightHelp" class="form-text text-muted">You can sometimes get your droid weighed at events!</small>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12">
                <button type="submit" class="btn btn-submit">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
