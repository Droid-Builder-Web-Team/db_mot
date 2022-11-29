<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          Comments
        </div>
        <div class="card-body">
  @foreach($comments as $comment)
          <div class="card border-primary">
            <div class="card-header">
              @can('View Members')
                <strong><a class="btn btn-info" href="{{ route('user.show', $comment->user->id) }}">{{ $comment->user->forename ?? "Deactivated"}} {{ $comment->user->surname ?? "User"}}</a></strong>
              @else
                <strong>{{ $comment->user->forename ?? "Deactivated"}} {{ $comment->user->surname ?? "User"}}</strong>
              @endcan
              @if ($comment->user != NULL)
                @if ($comment->user->can('Edit Partsrun'))
                  <i class="fas fa-user-shield"></i>
                @endif
              @endif
              <span class="float-right">
                @if ($comment->broadcast)
                  <i class="fas fa-bullhorn"></i>
                @endif
                {{ Carbon\Carbon::parse($comment->created_at, Auth::user()->settings()->get('timezone'))->isoFormat(Auth::user()->settings()->get('date_format').' - '.Auth::user()->settings()->get('time_format')) }}
              </span>
            </div>
            <div class="card-body">
              {!! nl2br(e($comment->body)) !!}
              @can('Edit Partrun')
              <span class="float-right">
                <a href="{{ route('comment.delete', $comment->id )}}" class="btn-sm btn-danger">Delete</a>
              </span>
              @endcan
              <span class="float-right">
                <reaction-component
                      :comment="{{ $comment->id }}"
                      :summary='@json($comment->reactionSummary())'
                      @auth
                      :reacted='@json($comment->reacted())'
                      @endauth
                />
              </span>
            </div>
          </div>
  @endforeach
          <div class="card border-primary">
            <div class="card-header">
              <strong>Add Comment</strong>
            </div>
            <div class="card-body">
              <form action="{{ route('comment.add', [ 'id' => $model_id]) }}" method="POST">
                  @csrf
                  <input type="hidden" name="model" value="{{ $model_type }}">
                <div class="form-group">
                  <textarea type="text" class="form-control" name="body"></textarea>
                </div>
                <input type="submit" class="btn-sm btn-comment" name="comment" value="Add Comment"
                      onclick="this.disabled=true;this.form.submit();">
                @can($permission)
                  <div class="form-check float-right">
                    <input class="form-check-input" type="checkbox" name="broadcast" id="broadcast">
                    <label class="form-check-label" for="broadcast">Broadcast</label>
                  </div>
                @endcan
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
