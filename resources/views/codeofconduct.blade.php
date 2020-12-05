@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Code Of Conduct</h2>
      </div>
      <div class="card-body">
        <p>The Droid Builders currently have a very good relationship with Lucas Film Limited (LFL) and Disney, and as such we don't want to jeapordise
        this in any way. To this end, we would like to put forward a code of conduct for members to follow when at events or in any other way
        representing the club.</p>
        <ul>
          <li>Make sure your droid is up to MOT standards before each event, even if your MOT is not due</li>
          <li>Refrain from swearing or using adult language when in public at an event. Especially if there may be children in the vicinity.</li>
          <li>Always ask permission when taking photographs involving members of the public whenever possible, especially children.</li>
          <li>Make sure your droid is powered off or otherwise has its main drive disabled when leaving it unattended.</li>
          <li>Never leave any batteries charging unattended, especially over night at weekend events.</li>
          <li>Do not accept payment for attending events, beyond typical expenses. Charitable donations to the club's designated charity are perfectly fine.</li>
        </ul>

        <p>By clicking the button below, you are agreeing to abide by the rules of Droidbuilders UK when representing the club in any form.</p>
        <form  method="POST">
          @csrf
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <input type="submit" name="accept" value="Accept">
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
