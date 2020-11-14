@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <img src="https://droidbuilders.uk/wp-content/uploads/2019/10/DBUK-banner-1470.png" class="img-fluid">
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h1>About Us</h1>
        Droidbuilders UK aims to pull together all of the various droid building groups across the UK. Builder groups like the BB8, MSE, Gonk, etc. All with the aim
        of making it easier to attend events.
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4>Links:</h4>
        <ul>
          <li>Website: <a href="https://droidbuilders.uk/" target="_blank">https://droidbuilders.uk/</a></li>
          <li>Youtube: <a href="https://www.youtube.com/c/DroidbuildersUK/featured" target="_blank">https://www.youtube.com/c/DroidbuildersUK/featured</a></li>
          <li>Facebook: <a href="https://www.facebook.com/groups/droidbuildersuk" target="_blank">https://www.facebook.com/groups/droidbuildersuk</a></li>
          <li>GDPR</li>
          <li><a href="{{ route('codeofconduct') }}">Code of Conduct</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


@endsection
