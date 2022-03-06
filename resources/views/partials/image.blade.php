<div class="col-12 col-lg-3 droid-card">       <!-- droid front -->
  <div class="droid-card-content">
    <div style="text-align:center">
          <img src="{{ route('image.displayDroidImage', [$droid_id , $photo_name, '240']) }}" alt="{{ $photo_name }}" class="img-fluid mb-1 rounded">
    </div>


    <div class="droid-card-table" style="z-index:2">
		   <div class="droid-card-row">
					<div class="droid-card-left">
						<form action="{{ route('image') }}" method="GET">
              <div class="input-group">
                  <button class="btn btn-standard" type="submit"><i class="fas fa-upload"></i></button>
                  <input type="hidden" name="user" value="{{ $user_id }}">
                  <input type="hidden" name="droid" value="{{ $droid_id }}">
                  <input type="hidden" name="photo_name" value="{{ $photo_name }}">
              </div>
						</form>
					</div>
          <div class="droid-card-center">
            {{ $photo_name }}
          </div>
					<div class="droid-card-right">
						<form action="/image/destroy" method="GET">
							@csrf
              <input type="hidden" name="user" value="{{ $user_id }}">
              <input type="hidden" name="droid" value="{{ $droid_id }}">
              <input type="hidden" name="photo_name" value="{{ $photo_name }}">
							<button type="submit" class="fas fa-trash"></i>
						</form>
					</div>
				</div>
			</div>

  </div>
</div>
