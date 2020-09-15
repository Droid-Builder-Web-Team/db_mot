<div class="col-md-3 droid-card">       <!-- droid front -->
  <div class="droid-card-content">
    <div style="text-align:center">
          <img src="{{ route('image.displayDroidImage', [$droid_id , $photo_name, '240']) }}" alt="{{ $photo_name }}" class="img-fluid mb-1 rounded">
    </div>


    <div class="droid-card-table" style="z-index:2">
		   <div class="droid-card-row">
					<div class="droid-card-left">
						<form action="{{ route('image') }}" method="GET">
							<button type="submit" class="fas fa-upload"></i>
              <input type="hidden" name="user" value="{{ $user_id }}">
              <input type="hidden" name="droid" value="{{ $droid_id }}">
              <input type="hidden" name="photo_name" value="{{ $photo_name }}">
						</form>
					</div>
					<div class="droid-card-right">
						<form action="{{ route('droid.destroy', $droid->id) }}" method="POST">
							@csrf
							{{ method_field('DELETE') }}
							<button type="submit" class="fas fa-trash"></i>
						</form>
					</div>
				</div>
			</div>

  </div>
</div>
