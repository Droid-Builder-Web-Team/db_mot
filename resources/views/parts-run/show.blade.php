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
    <div class="build-section text-center page-heading-text d-flex flex-column" id="app">
        <div class="container-fluid">
            <div class="row">
                {{-- Run Header --}}
                <div class="col-12 col-lg-4 active_since">
                    <h5>Active Since:
                        {{ \Carbon\Carbon::createFromTimeString($data->partsRunAd->updated_at)->format('d/m/Y') }}</h5>
                </div>
                <div class="col-12 col-lg-4">
                    @if($data->status == 'Gathering_Interest')
                        <h5>Status: Gathering Interest</h5>
                    @else
                        <h5>Status: {{ $data->status }}</h5>
                    @endif
                </div>
                <div class="col-12 col-lg-4">
                    <h5>BC Rep: {{ $data->bcRep->forename }} {{ $data->bcRep->surname }}</h5>
                </div>

                <div class="col-12">
                    <div class="buttons icon-text">
                        <a class="btn btn-back" href="{{ url()->previous() }}">Back</a>
                        @hasrole('BC Rep')
                            <a class="btn btn-edit" href={{ route('parts-run.edit', $data->id) }}>Edit Run</a>
                        @endhasrole
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-8">
                    {{-- Run Details --}}
                    <div class="build-section db-my-2">
                        <div class="row form-wrapper d-flex justify-content-center align-items-center">
                            <div class="col-12 order-12">
                                <div class="row">
                                    <div class="col-12 col-lg-6 d-flex justify-content-center">
                                        <p class="title"><strong>{{ $data->partsRunAd->title }}</strong></p>
                                    </div>
                                    <div class="col-12 col-lg-6 d-flex flex-row justify-content-center">
                                        <p class="title"><strong>Price: </strong>
                                            <small><?php echo '£' . number_format($data->partsRunAd->price, 2); ?></small>
                                        </p>
                                    </div>
                                    <div class="divider"></div>

                                    <div class="form-section text-center text-sm-left db-my-1">
                                        <div class="col-12 col-lg-6 text-center">
                                            <p class="seller"><strong>Seller:</strong> 
                                                {{ $data->user->forename }} {{ $data->user->surname }}
                                            </p>
                                        </div>

                                        <div class="col-12 col-lg-6 text-center">
                                            <p class="droid"><strong>Club:</strong> {{ $data->club->name }}</p>
                                        </div>
                                    </div>

                                    <div class="form-section text-center text-sm-left db-my-1">
                                        <div class="col-12 col-lg-6 text-center">
                                            <p class="location">
                                                <strong>Location:</strong>
                                                {{ $data->partsRunAd->location }}
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
                                            <p class="pr-1 droid"><strong>Shipping Costs:</strong></p>
                                            <ul>
                                                @foreach ($shippingCostsArray as $s)
                                                    <li>{{ $s }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="form-section text-center text-sm-left db-my-1">
                                        <div class="col-12 text-left description-col">
                                            <p class="description-text"><strong>Description:</strong></p>
                                            {!! $data->partsRunAd->description !!}
                                        </div>
                                    </div>

                                    <div class="form-section text-center db-my-1 justify-content-center d-flex">
                                        <div class="col-12 text-center">
                                            <p class="includes"><strong>Included:</strong></p>
                                            <ul>
                                                @foreach ($includesArray as $i)
                                                    <li>{{ $i }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="form-section text-center db-my-1 purchase-contact">
                                        <div class="col-12 col-xl-6 equal">
                                            {{-- If Part Run is Active --}}
                                            @if ($data->status == 'Active')
                                            <div class="status-wrapper">
                                                <p><strong>Purchase Link:</strong></p>
                                                @if ($data->open == 1)
                                                    <p>
                                                        <a class="btn btn-purchase mx-auto" target=_blank
                                                            href="{{ $data->partsRunAd->purchase_url }}">
                                                            <i class="fas fa-shopping-cart"></i> 
                                                            Order Now
                                                        </a>
                                                    </p>
                                                    <small class="transaction-notice">
                                                        Note: Purchases are between you and the person
                                                        doing the run. 
                                                        <span>
                                                            This site does not handle any
                                                            transactions.
                                                        </span>
                                                    </small>
                                                @else
                                                    <p>
                                                        Run is currently only open to those who registered interest. It will become an
                                                    open run once those people have had a chance to purchase.
                                                    </p>
                                                @endif
                                            </div>
                                                


                                            {{-- If Part Run is Gathering Interest --}}
                                            @elseif($data->status == 'Gathering_Interest')
                                            <div class="status-wrapper">
                                                <p><strong>Register Your Interest:</strong></p>
                                                @php
                                                    $status = 'no';
                                                    $quantity = 1;
                                                    $user = $data->is_interested->only([Auth::user()->id])->first();
                                                    if ($user != null) {
                                                        $status = $user->pivot->status;
                                                    }
                                                @endphp

                                                @if ($status != 'no')
                                                    <p><a class="btn btn-purchase mx-auto"
                                                            href="{{ route('parts-run.interested', [$data->id, 'interest' => 'no', 'quantity' => 0]) }}">Remove
                                                            Interest!</a></p>
                                                @else

                                                    @if ($data->partsRunAd->quantity == 0 || $data->partsRunAd->quantity > $data->interested->count())
                                                        <form action="{{ route('parts-run.interested', $data->id) }}" method="GET">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Quantity</span>
                                                                </div>
                                                                <input class="form-control interested" size=4 type=number value="1" name="quantity">
                                                                <input type="hidden" name="interest" value="interested">
                                                                <div class="buttons">
                                                                    <input class="btn btn-purchase" type=submit value="Interested">
                                                                </div>
                                                            </div>
                                                            
                                                        </form>
                                                        <small>
                                                        Note: Registering interest is not a commitment to buy, but please only do so
                                                        if you think you will. This will give the person doing the run access to
                                                        your email address.
                                                        </small>
                                                    @else
                                                        <p>Interest List is Full</p>
                                                    @endif
                                                @endif
                                            </div>
                                                
                                            {{-- If Part Run is Inactive --}}
                                            @else
                                                <p>This run is inactive. Please wait for it to become active again.</p>
                                            @endif
                                        </div>

                                        <div class="col-12 col-xl-6 equal db-my-1">
                                            <p class="droid"><strong>Contact Email: </strong></p>
                                            <p>
                                                <a class="p-link" href="mailto:{{ $data->partsRunAd->contact_email }}">
                                                    {{ $data->partsRunAd->contact_email }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>

                                    @if ($data->partsRunAd->history != "")
                                        <div class="form-section text-center db-my-1">
                                            <div class="col-12">
                                                <p class="history-text"><strong>History:</strong></p>
                                                <p>{{ $data->partsRunAd->history }}</p>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            {{-- Parts Run Main Image --}}
                            @if($data->images->count() != 0)
                            <div class="col-12 col-lg-6 order-1 part-run-image">
                                <div class="image-wrapper">
                                    {{-- Run IF Statement, if has no image, use dummy placeholder - please keep baby yoda!! --}}
                                    <img src="{{ route('image.displayPartsRunImage', $data->id) }}" class="img-fluid">
                                </div>
                            </div>
                            @else
                            <div class="col-12 col-lg-6 order-1 part-run-image">
                                <div class="image-wrapper">
                                    <img src="https://snipdaily.com/wp-content/uploads/2020/01/baby-yoda-disneyplus-1024x574.jpg" class="img-fluid">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    {{-- Interest List --}}
                    <div class="build-section db-my-2">
                        <div class="row w-100">
                            <div class="col-12">
                                <h5 class="text-center db-mb-1">Interest:</h5>
                            </div>
                            {{-- Hides the entire column if there is 0 interest -RH --}}
                            @if(!$data->interest = 0)
                            <div class="col-12 form-section text-sm-left db-my-1">
                                <ul>
                                    @foreach($data->interested as $user)
                                        @if($user->pivot->status == 'interested')
                                            <li class="d-flex align-items-center justify-content-center">
                                                @can('View Members')
                                                    1<a class="p-link" href="{{ route('user.show', $user->id) }}">{{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}</a>
                                                @else
                                                <div class="input-group">
                                                    {{ $user->forename ?? "Deactivated"}} {{ $user->surname ?? "User"}}
                                                </div>
                                                @endcan
                                                @if($user->pivot->quantity != 1)
                                                    ({{$user->pivot->quantity}})
                                                @endif
                                                @if(auth()->user()->id == $data->user_id || Auth::user()->hasRole('BC Rep'))
                                                    @if ($data->status == "Active")
                                                        <form action="{{ route('parts-run.status_update') }}" method="POST">
                                                            @csrf
                                                            <div class="input-group">
                                                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                                                <input type="hidden" name="run_id" value="{{ $data->id }}">
                                                                <input type="hidden" name="status" value="paid">
                                                                <button class="btn btn-paid" type="submit"><i class="fas fa-pound-sign"></i></button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if ($data->status == "Active")
                                <div class="col-12 form-section text-sm-left db-my-1">
                                    <h5 class="text-center db-mb-1">Paid:</h5>
                                </div>
                                {{-- Trying to get this to hide the entire col-12 if the count for paid is 0 -RH --}} 
                                @if(!$data->interest = 0)
                                <div class="col-12 form-section text-sm-left db-my-1">
                                    <ul>
                                        @foreach($data->interested as $user)
                                            @if($user->pivot->status == 'paid')
                                                <li class="d-flex align-items-center justify-content-center paid-col">
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
                                                        <div class="input-group justify-content-end">
                                                            <button type="button" class="btn btn-paid" data-toggle="modal" data-userid="{{ $user->id }}" data-target="#shipModal"><i class="fas fa-truck"></i></button>
                                                        </div>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="col-12 form-section text-sm-left db-my-1">
                                    <h5 class="text-center db-mb-1">Shipped:</h5>
                                </div>
                                {{-- Trying to get this to hide the entire col-12 if the count for paid is 0 -RH --}} 
                                @if(!$data->interest = 0 )
                                <div class="col-12 form-section text-sm-left db-my-1">
                                    <ul>
                                        @foreach($data->interested as $user)
                                            @if($user->pivot->status == 'shipped')
                                                <li class="d-flex align-items-center justify-content-center interest-shipped">
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
                                </div>
                                @endif
                            @endif
                            @if(Gate::check('Edit Partrun') && (Auth()->user()->id == $data->user_id || Auth()->user()->id == $data->bc_rep_id))
                            <div class="buttons">
                                <span id="export" class="btn btn-create" data-href={{ route('parts-run.export', $data->id) }} onclick="exportTasks(event.target);">Download list as CSV
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('partials.comments', ['comments' => $data->comments, 'permission' => 'Edit Partrun', 'model_type' => 'App\PartsRunData', 'model_id' => $data->id])
        </div>
    </div>

    <div class="modal fade" id="shipModal" tabindex="-1" role="dialog" aria-labelledby="shipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content db-mt-1">
                <div class="modal-header db-m-1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id=close-button>
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="shipModalLabel">Shipping Information</h5>
                    <small>
                        Please input shipping/ tracking information where possible. This helps
                        the buyer keep track of their order and prevents persistant emails
                        asking for updates.
                    </small>
                </div>
                <form action="{{ route('parts-run.status_update') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="shipper">Courier:</label>
                            <select class="form-control" name="shipper">
                                <option value="none">None</option>
                                <option value="Royal Mail">Royal Mail</option>
                                <option value="Parcel Force">Parcel Force</option>
                                <option value="DPD">DPD</option>
                                <option value="Hermes">Hermes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tracking_number">Tracking Number:</label>
                            <input id="tracking_number" class="form-control" type="text" size=20 name="tracking">
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <input type="hidden" name="run_id" value="{{ $data->id }}">
                            <input type="hidden" name="status" value="shipped">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-create" value="Shipped">
                    </div>
                </form>
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
