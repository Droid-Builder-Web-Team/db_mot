@extends('layouts.app')

@section('scripts')
<script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>

<script>
    $(document).ready(function(){
        $('#shipModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            console.log(button.data());
            var user_id = button.data('userid') // Extract info from data-* attributes
            console.log("User ID: " + user_id);
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#user_id').val(user_id)
        })
    })
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
                @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->hasRole('BC Rep')))
                <div class="text-center row">
                    <div class="col-12">
                        <a class="btn btn-primary" href={{ route('parts-run.edit', $data->id) }}>Edit Run</a>
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
                                    @if(count($shippingCostsArray) > 0)
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <p class="pr-1 droid"><strong>Shipping Costs:</strong></p>
                                            <ul>
                                                @foreach($shippingCostsArray as $s)
                                                    <li><?php echo '£' . number_format($s, 2); ?></li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                    @endif
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
                                            @if($data->open == 1 || $data->canBuy(Auth::user()))
                                                <p><strong>Purchase Link:</strong></p>
                                                <p>
                                                    @if($data->partsRunAd->purchase_url_type == "email")
                                                        <a class="btn btn-primary" id="buy_button" target=_default
                                                            href="mailto:{{ $data->partsRunAd->purchase_url }}?subject=BUY: {{ $data->partsRunAd->title }}&body=I'm interested in purchasing from this run.">
                                                            Email Seller to Buy</a>
                                                    @else
                                                        <a class="btn btn-primary" id="buy_button" target=_default href="{{ $data->partsRunAd->purchase_url }}">Buy Here</a>
                                                    @endif
                                                </p>
                                                Note: Purchases are between you and the person doing the run. This site does not handle any transactions.
                                                @if($data->isInterested->only([ Auth::user()->id ])->count() != 0)
                                                    <p><a class="btn btn-primary" id="cancel_button" href="{{ route('parts-run.interested',[$data->id, 'interest' => 'no', 'quantity' => 0]) }}">Remove Interest!</a></p>
                                                @endif
                                            @else
                                                Run is currently only open to those who registered interest. It will become an open run once those people have had a chance to purchase if there are any left.
                                            @endif


                                        @elseif($data->status == "Gathering_Interest")
                                            <p><strong>Register Your Interest:</strong></p>
                                            @php
                                                $status="no";
                                                $quantity = 1;
                                                $user = $data->isInterested->only([ Auth::user()->id ])->first();
                                                if ($user != NULL) {
                                                    $status = $user->pivot->status;
                                                }
                                            @endphp
                                            @if($status == 'interested')
                                                <p><a class="btn btn-primary" href="{{ route('parts-run.interested',[$data->id, 'interest' => 'no', 'quantity' => 0]) }}">Remove Interest!</a></p>
                                            @else
                                                @if(!$data->partsRunAd->quantity == 0 && $data->partsRunAd->quantity + $data->partsRunAd->reserve < $data->interestQuantity())
                                                    <p>Interest List is Full</p>
                                                @else
                                                    @if($data->interestQuantity() >= $data->partsRunAd->quantity)
                                                        <p>Run is full, but you may add yourself to the reserve list</p>
                                                    @endif
                                                <form action="{{ route('parts-run.interested',$data->id) }}" method="GET">
                                                    <input size=4 type=number value="1" name="quantity">
                                                    <input type="hidden" name="interest" value="interested">
                                                    <input class="btn btn-primary" type=submit value="Interested">
                                                </form>
                                                    Note: Registering interest is not a commitment to buy, but please only do so if you think you will. This will give the person doing the run access to your email address.
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
        @php
            $quantity = 0;
        @endphp
        @foreach($data->interested as $user)
        @if($user->pivot->status == 'interested')
            <li>
                @can('View Members')
                    <a class="p-link" href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                @else
                    {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                @endcan
                @if($user->pivot->quantity != 1)
                    ({{$user->pivot->quantity}})
                @endif
                @php $quantity += $user->pivot->quantity @endphp
                @if($quantity > $data->partsRunAd->quantity)
                    (Reserve)
                @endif
                @if(auth()->user()->id == $data->user_id || Auth::user()->hasRole('BC Rep'))
                    @if ($data->status == "Active")
                        <form action="{{ route('parts-run.status_update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="run_id" value="{{ $data->id }}">
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="btn"><i class="fas fa-pound-sign"></i></button>
                        </form>
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
                @can('View Members')
                    <a class="p-link" href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                @else
                    {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                @endcan
                @if($user->pivot->quantity != 1)
                    ({{$user->pivot->quantity}})
                @endif
                @if(auth()->user()->id == $data->user_id || auth()->user()->id == $data->bc_rep_id)
                    @if ($data->status == "Active")
                        <button type="submit" class="btn" data-toggle="modal" data-userid="{{ $user->id }}" data-target="#shipModal"><i class="fas fa-truck"></i></button>
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
                @can('View Members')
                    <a class="p-link" href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                @else
                    {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                @endcan
                @if($user->pivot->quantity != 1)
                    ({{$user->pivot->quantity}})
                @endif
                &nbsp;<i class="fas fa-box"></i>&nbsp;
                @if(auth()->user()->id == $data->user_id || auth()->user()->id == $data->bc_rep_id || auth()->user()->id == $user->id)
                    @if($user->pivot->tracking != "" )
                        {!! $data->trackingUrl($user->pivot->tracking, $user->pivot->shipper) !!}
                    @else
                        No tracking
                    @endif
                @endif
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
@include('partials.comments', ['comments' => $data->comments, 'permission' => 'Edit Partrun', 'model_type' => 'App\PartsRunData', 'model_id' => $data->id])
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
                            <form action="{{ route('parts-run.status_update') }}" method="POST">
                                @csrf
                                Shipper:
                                <select class="form-control" name="shipper">
                                    <option value="none">None</option>
                                    <option value="Royal Mail">Royal Mail</option>
                                    <option value="Parcel Force">Parcel Force</option>
                                    <option value="DPD">DPD</option>
                                    <option value="Hermes">Hermes</option>
                                    <option value="Other">Other...</option>
                                </select>
                                Tracking Number: <input type="text" size=20 name="tracking">
                                <input type="hidden" name="user_id" id="user_id" value="">
                                <input type="hidden" name="run_id" value="{{ $data->id }}">
                                <input type="hidden" name="status" value="shipped">
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
