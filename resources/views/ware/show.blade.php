@extends('layouts.app')
@section('scripts')

<script>
  function shareToFacebook(_this) {
 var body = 'An item has been added to the Droid Builders Portal Marketplace. ';
 body += 'Follow the link to see more details and to ask any questions';
 FB.ui({
   display: 'iframe',
   app_id: '{{ config('fb.fb_app_id', 'Laravel') }}',
   method: 'share',
   hashtag: '#marketplace',
   href: '{{ URL::current() }}',
   quote: body,
 }, function(response){});
}
</script>

<script type="application/javascript" async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '{{ config('fb.fb_app_id', 'Laravel') }}',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v10.0'
    });
  };
</script>

<script>

  function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(() => {
          // Optional: Add a success message
          alert("Link copied to clipboard!");
      }).catch(err => {
          // Optional: Handle error
          console.error("Failed to copy: ", err);
      });
  }
</script>

@endsection
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <div class="col-sm-2 text-left">
                    @if(Auth::user()->id == $ware->user->id || Gate::check('Edit Marketplace'))
                        <a class="btn btn-primary" href={{ route('ware.edit', $ware->id) }}>Edit Item</a>
                    @endif
                </div>
                <div class="col-sm-8 text-center">
                    <h4 class="text-center title">{{$ware->title}}</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <a class="btn btn-primary" href="{{ route('ware.index') }}">Back</a>
                </div>
            </div>
        </div>

      <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="row"><div class="col-md-2"><strong>Name:</strong></div><div class="col-md-10">{{ $ware->user->forename }} {{ $ware->user->surname }}</div></div>
              <div class="row"><div class="col-md-2"><strong>Country:</strong></div><div class="col-md-10">{{ $ware->user->country }}</div></div>
              @if($ware->showemail)
                <div class="row"><div class="col-md-2"><strong>Email:</strong></div><div class="col-md-10">{{ $ware->user->email }}</div></div>
              @endif
              <div class="row"><div class="col-md-2"><strong>Listed:</strong></div><div class="col-md-10">{{ $ware->created_at }}</div></div>
              @if( $ware->created_at != $ware->updated_at)
                <div class="row"><div class="col-md-2"><strong>Updated:</strong></div><div class="col-md-10">{{ $ware->updated_at }}</div></div>
              @endif
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <strong>Description:</strong>
            <div id="description">{!! $ware->description !!}</div>
          </div>
        </div>
        @if(Auth::user()->id == $ware->user->id)
          <span id="export" class="btn btn-info" onclick="shareToFacebook(event.target);">Share to Facebook</span>
          <button class="btn btn-info" onclick="copyToClipboard('{{ url()->current() }}')">Copy Link</button>
        @endif
      </div>
    </div>
  </div>
</div>
<div id='app'>
    @include('partials.comments', ['comments' => $ware->comments, 'permission' => 'Edit Auction', 'model_type' => 'App\Models\Ware', 'model_id' => $ware->id])
</div>

@endsection