{{-- Comments --}}
<div class="build-section">
    <div class="row w-100">
        <div class="col-12 text-center db-mb-1">
            <h4>Comments</h4>
        </div>

        <div class="col-12">
            <div class="comment-card">
                <div class="overlay"></div>
                @foreach ($comments as $comment)
                    <div class="comment">
                        <div class="comment-header">
                            <h5>
                                <strong>
                                    {{ $comment->user->forename ?? 'Deactivated' }}
                                    {{ $comment->user->surname ?? 'User' }}
                                    @if ($comment->user != null)
                                        @if ($comment->user->can($permission))
                                            <i class="fas fa-user-shield"></i>
                                        @endif
                                    @endif
                                </strong>
                            </h5>

                            <span>
                                {{ Carbon\Carbon::parse(
                                    $comment->created_at,
                                    Auth::user()->settings()->get('timezone'),
                                )->isoFormat(
                                    Auth::user()->settings()->get('date_format') .
                                        ' - ' .
                                        Auth::user()->settings()->get('time_format'),
                                ) }}

                                @if ($comment->broadcast)
                                    <i class="fas fa-bullhorn"></i>
                                @endif
                            </span>
                        </div>

                        <div class="comment-body">
                            {!! nl2br(e($comment->body)) !!}
                            @can($permission)
                                <div class="buttons">
                                    <a href="{{ route('comment.delete', $comment->id) }}"
                                        class="btn btn-delete">
                                        Delete
                                    </a>
                                </div>
                            @endcan
                            <span class="reactions">
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
            </div>

            <div class="comment-card">
                <div class="comment">
                    <div class="comment-header">
                        <h5>Add Comment</h5>
                    </div>
                    <div class="comment-body">
                        <form action="{{ route('comment.add', [ 'id' => $model_id ]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="model" value="{{ $model_type }}">

                            <div class="form-group">
                                <textarea type="text" class="form-control" name="body"></textarea>
                            </div>

                            @can($permission)
                                <div class="form-check db-my-1">
                                    <input class="form-check-input" type="checkbox" name="broadcast" id="broadcast">
                                    <label class="form-check-label" for="broadcast">Broadcast</label>
                                </div>
                            @endcan

                            <input type="submit" class="btn btn-submit" name="comment" value="Add Comment"
                                onclick="this.disabled=true;this.form.submit();">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
