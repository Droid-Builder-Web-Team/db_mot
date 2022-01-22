@extends('layouts.app')

@section('scripts')
<script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
@endsection

@section('content')

<div id="app">
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header padding-container">
                <div class="mb-4 text-center row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-4 active_since">
                        <h6>Active Since: {{  \Carbon\Carbon::createFromTimeString($data->partsRunAd->updated_at)->format('d/m/Y') }}</h6>
                    </div>
                    <div class="col-12 col-md-4 status">
                        <h6>Status: {{ $data->status }}</h6>
                    </div>
                    <div class="col-12 col-md-4 status">
                        <h6>Rep: {{ $data->bcRep->forename }} {{ $data->bcRep->surname }}</h6>
                    </div>
                </div>
                @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                <div class="text-center row">
                    <div class="col-12">
                        <a class="btn btn-primary" href={{ route('parts-run.edit', $data->id) }}>Edit Run</a>
                        @can('Create Partrun')
                          <a class="btn btn-danger" href={{ route('parts-run.destroy', $data->id) }}>Delete Run</a>
                        @endcan
                    </div>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="text-left part-content">
                            <div class="row">
                                <div class="run-header">
                                    <div class="col-12 col-md-6">
                                        <p class="title"><strong>{{ $data->partsRunAd->title }}</strong></p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <p class="pr-1 price"><strong>Price:</strong></p>
                                            <?php echo '£' . number_format($data->partsRunAd->price, 2); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="parts-run-break">

                            <div class="mb-4 row">
                                <div class="seller-info">
                                    <div class="col-12 col-md-6">
                                        <p class="seller"><strong>Seller:</strong> {{ $data->user->forename }} {{ $data->user->surname }}</p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="droid"><strong>Club:</strong> {{ $data->club->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="location-shipping">
                                    <div class="col-12 col-md-6">
                                        <p class="location"><strong>Location:</strong> {{ $data->partsRunAd->location }}</p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <p class="pr-1 droid"><strong>Shipping Costs:</strong></p>
                                            <ul>
                                                @foreach($shippingCostsArray as $s)
                                                    <li>{{ $s }}</li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="description">
                                    <div class="col-12">
                                        <p class="description-text"><strong>Description:</strong></p>
                                        <p>{!! $data->partsRunAd->description !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="includes">
                                    <div class="col-12">
                                        <p class="includes"><strong>Included:</strong>
                                            <ul>
                                            @foreach($includesArray as $i)
                                                <li>{{ $i }}</li>
                                            @endforeach
                                            </ul>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-4 row">
                                <div class="purchase-email">
                                    <div class="col-12 col-md-6">
                                        @if($data->status == "Active")
                                          <p><strong>Purchase Link:</strong></p>
                                          @if($data->open == 1)
                                            <p><strong>Purchase Link:</strong></p>
                                            <p><a class="btn btn-primary" target=_default href="{{ $data->partsRunAd->purchase_url }}"> Buy Here</a></p>
                                            Note: Purchases are between you and the person doing the run. This site does not handle any transactions.
                                          @else
                                            Run is currently only open to those who registered interest. It will become an open run once those people have had a chance to purchase.
                                          @endif
                                        @elseif($data->status == "Gathering_Interest")
                                            <p><strong>Register Your Interest:</strong></p>
                                            @php
                                              $status="no";
                                              $quantity = 1;
                                              $user = $data->is_interested->only([ Auth::user()->id ])->first();
                                              if ($user != NULL) {
                                                $status = $user->pivot->status;
                                              }
                                            @endphp
                                            @if($status != 'no')
                                              <p><a class="btn btn-primary" href="{{ route('parts-run.interested',[$data->id, 'interest' => 'no', 'quantity' => 0]) }}">Remove Interest!</a></p>
                                            @else
                                              @if($data->partsRunAd->quantity == 0 || $data->partsRunAd->quantity > $data->interested->count())
                                              <form action="{{ route('parts-run.interested',$data->id) }}" method="GET">

                                                <input size=4 type=number value="1" name="quantity">
                                                <input type="hidden" name="interest" value="interested">
                                                <input class="btn btn-primary" type=submit value="Interested">
                                              </form>
                                                Note: Registering interest is not a commitment to buy, but please only do so if you think you will. This will give the person doing the run access to your email address.
                                              @else
                                                <p>Interest List is Full</p>
                                              @endif
                                            @endif
                                        @else
                                            <p>This run is inactive. Please wait for it to become active again.</p>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <p class="droid"><strong>Contact Email: </strong></p>
                                        <p><a href="mailto:{{ $data->partsRunAd->contact_email }}"> {{ $data->partsRunAd->contact_email }}</a></p>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="instructions">
                                    <div class="col-12">
                                        <p class="instructions"><strong>Instructions:</strong></p>

                                        @if(is_null($data->partsRunAd->instructions->filename))
                                            <p>Test</p>
                                        @elseif(is_null($data->partsRunAd->instructions->url))
                                            <p><a href="{{ $data->partsRunAd->instructions->filepath }}"> {{ $data->partsRunAd->instructions->title }}</a></p>
                                        @else
                                            <p>No Instructions Given :(</p>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
                <hr class="parts-run-break">
                <div class="row">
                    <div class="col-12">
                        <div class="history">
                                <div class="col-12">
                                <p class="history-text"><strong>History:</strong></p>
                                <p>{{ $data->partsRunAd->history }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
  </div>

<!-- Interest -->

<div class="col-xs-3 col-sm-3 col-md-3">
  <div class="card">
    <div class="card-header">
      Status:
    </div>
    <div class="card-body">
      <h3>Interest</h3>
      <ul>
      @foreach($data->interested as $user)
        @if($user->pivot->status == 'interested')
        <li>
            {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
            @if($user->pivot->quantity != 1)
             ({{$user->pivot->quantity}})
            @endif
            @if(auth()->user()->id == $data->user_id || auth()->user()->id == $data->bc_rep_id)
              @if ($data->status == "Active")
                <a href="{{ route('parts-run.status_update',[$data->id, 'status' => 'paid', 'user_id' => $user->id]) }}"><i class="fas fa-pound-sign"></i></a>
              @endif
            @endif
        </li>
        @endif
      @endforeach
    </ul>

    @if ($data->status == "Active")
    <h3>Paid</h3>
    <ul>
    @foreach($data->interested as $user)
      @if($user->pivot->status == 'paid')
      <li>
          {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
          @if($user->pivot->quantity != 1)
           ({{$user->pivot->quantity}})
          @endif
          @if(auth()->user()->id == $data->user_id || auth()->user()->id == $data->bc_rep_id)
            @if ($data->status == "Active")
            <i class="fas fa-truck"data-toggle="modal" data-target="#shipModal"></i>

            @endif
          @endif
      </li>
      @endif
    @endforeach
    </ul>
    <h3>Shipped</h3>
    <ul>
    @foreach($data->interested as $user)
      @if($user->pivot->status == 'shipped')
      <li>
          {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
          @if($user->pivot->quantity != 1)
           ({{$user->pivot->quantity}})
          @endif
          <i class="fas fa-box"></i>
      </li>
      @endif
    @endforeach
  </ul>


    @endif
    @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
      <span id="export" class="btn btn-primary" data-href={{ route('parts-run.export', $data->id) }} onclick="exportTasks(event.target);">Download list as CSV
      </span>
    @endif
  </div>
  </div>

</div>


</div>
<div class="row">
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">
        Comments
      </div>
      <div class="card-body">
@foreach($data->comments as $comment)
        <div class="card border-primary">
          <div class="card-header">
            <strong>{{ $comment->user->forename ?? "Deactivated"}} {{ $comment->user->surname ?? "User"}}</strong>
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
            <form action="{{ route('comment.add', [ 'id' => $data->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="model" value="App\PartsRunData">
              <div class="form-group">
                <textarea type="text" class="form-control" name="body"></textarea>
              </div>
              <input type="submit" class="btn-sm btn-comment" name="comment" value="Add Comment"
                    onclick="this.disabled=true;this.form.submit();">
              @can('Edit Partrun')
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
</div>


<div class="modal fade" id="shipModal" tabindex="-1" role="dialog" aria-labelledby="shipModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="shipModalLabel">Shipping</h5>
								<button type="button" class="close" data-dismiss="modal" aria-
                                label="Close" id=close-button>
									<span aria-hidden="true">&times;</span>
								</button>
						</div>
                        <div>
                            <form action="{{ route('parts-run.status_update',[$data->id, 'status' => 'shipped', 'user_id' => $user->id]) }}" method="POST">
                                @csrf
                                Shipper:
                                <select class="form-control" name="shipper">
                                    <option value="none">None</option>
                                    <option value="Royal Mail">Royal Mail</option>
                                    <option value="Parcel Force">Parcel Force</option>
                                    <option value="DPD">DPD</option>
                                    <option value="Hermes">Hermes</option>
                                </select>
                                Tracking Number: <input type="text" size=20 name="tracking">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                        </div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-primary" value="Shipped">
						</div>
					</div>
				</div>
			</div>


<script>
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        $(this).ekkoLightbox();
        event.preventDefault();
    });
</script>
@endsection
