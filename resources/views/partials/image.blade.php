<div class="col-md-3 droid-card">       <!-- droid front -->
  <div class="droid-card-content">
    <div style="text-align:center">
          <img src="{{ route('image.displayDroidImage', [$droid_id , $photo_name]) }}" alt="{{ $photo_name }}" class="img-fluid mb-1 rounded" style="height:300px;">
    </div>
    <div class="droid-card-table" style="z-index:2">
      <div class="droid-card-row">
        <div class="droid-card-center noclick">
          <form action="{{ route('image') }}" method="GET">
            @csrf
            <input type="hidden" name="user" value="{{ $user_id }}">
            <input type="hidden" name="droid" value="{{ $droid_id }}">
            <input type="hidden" name="photo_name" value="{{ $photo_name }}">
            <button type="submit" class="btn btn-primary">Change</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
