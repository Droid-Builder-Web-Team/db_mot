@extends('layouts.app')
@section('content')
<div class="build-section">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="image-wrapper landscape header-image">
          <img src="https://droidbuilders.uk/wp-content/uploads/2019/10/DBUK-banner-1470.png">
        </div>
      </div>

        <div class="col-12">
          <h1 class="db-my-1">About Us</h1>
          <p>
            Droidbuilders UK aims to pull together all of the various droid building groups across the UK. Builder groups like the BB8, MSE, Gonk, etc. All with the aim
            of making it easier to attend events.
          </p>

          <div class="divider"></div>

          <h4 class="db-my-1">Links:</h4>
          <ul class="links">
            <li>
              <i class="fas fa-link"></i>
              <a class="p-link" href="https://droidbuilders.uk/" target="_blank">https://droidbuilders.uk/</a>
            </li>
            <li>
              <i class="fab fa-youtube"></i>
              <a class="p-link" href="https://www.youtube.com/c/DroidbuildersUK/featured" target="_blank">https://www.youtube.com/c/DroidbuildersUK/featured</a>
            </li>
            <li>
              <i class="fab fa-facebook-square"></i>
              <a class="p-link" href="https://www.facebook.com/groups/droidbuildersuk" target="_blank">https://www.facebook.com/groups/droidbuildersuk</a>
            </li>
            <li><i class="fab fa-discord"></i>
              <a class="p-link" href="https://discord.gg/4ZV9DmY" target="_blank">Droid Builder Discord Server</a>
            </li>
            <li>
              <i class="fas fa-shield-alt"></i>
              <a class="p-link" href="{{ route('gdpr-terms') }}">GDPR</a>
            </li>
            <li>
              <i class="far fa-handshake"></i>
              <a class="p-link" href="{{ route('codeofconduct') }}">Code of Conduct</a>
            </li>
          </ul>
        </div>
    </div>
  </div>
</div>
@endsection
