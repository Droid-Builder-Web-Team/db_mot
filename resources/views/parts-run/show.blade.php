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
    <div class="build-section text-center page-heading-text d-flex flex-column db-mt-2" id="app">
        <div class="container-fluid">
            <div class="row">
                {{-- Run Header --}}
                <div class="col-12 col-md-4 active_since">
                    <h5>Active Since:
                        {{ \Carbon\Carbon::createFromTimeString($data->partsRunAd->updated_at)->format('d/m/Y') }}</h5>
                </div>
                <div class="col-12 col-md-4">
                    <h5>Status: {{ $data->status }}</h5>
                </div>
                <div class="col-12 col-md-4">
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

            {{-- Run Details --}}
            <div class="build-section db-my-2">
                <div class="row form-wrapper d-flex justify-content-center align-items-center">
                    <div class="col-12 order-12">
                        <div class="row">
                            <div class="col-12 col-md-6 d-flex justify-content-center">
                                <p class="title"><strong>{{ $data->partsRunAd->title }}</strong></p>
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-row justify-content-center">
                                <p class="title"><strong>Price: </strong>
                                    <small><?php echo '£' . number_format($data->partsRunAd->price, 2); ?></small>
                                </p>
                            </div>
                            <div class="divider"></div>

                            <div class="form-section text-center text-sm-left db-my-1">
                                <div class="col-12 col-md-6 text-center">
                                    <p class="seller"><strong>Seller:</strong> {{ $data->user->forename }}
                                        {{ $data->user->surname }}</p>
                                </div>

                                <div class="col-12 col-md-6 text-center">
                                    <p class="droid"><strong>Club:</strong> {{ $data->club->name }}</p>
                                </div>
                            </div>

                            <div class="form-section text-center text-sm-left db-my-1">
                                <div class="col-12 col-md-6 text-center">
                                    <p class="location"><strong>Location:</strong>
                                        {{ $data->partsRunAd->location }}</p>
                                </div>
                                <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                    <p class="pr-1 droid"><strong>Shipping Costs:</strong></p>
                                    <ul>
                                        @foreach ($shippingCostsArray as $s)
                                            <li>{{ $s }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="form-section text-center text-sm-left db-my-1">
                                <div class="col-12 text-center">
                                    <p class="description-text"><strong>Description:</strong></p>
                                    <p>{!! $data->partsRunAd->description !!}</p>
                                </div>
                            </div>

                            <div class="form-section text-center db-my-1 justify-content-center d-flex">
                                <div class="col-12 text-center">
                                    <p class="includes"><strong>Included:</strong>
                                    <ul>
                                        @foreach ($includesArray as $i)
                                            <li>{{ $i }}</li>
                                        @endforeach
                                    </ul>
                                    </p>
                                </div>
                            </div>

                            <div class="form-section text-center db-my-1 purchase-contact">
                                <div class="col-12 col-xl-6 equal">
                                    @if ($data->status == 'Active')
                                        <p><strong>Purchase Link:</strong></p>
                                        @if ($data->open == 1)
                                            <p>
                                                <a class="btn btn-purchase mx-auto" target=_blank
                                                    href="{{ $data->partsRunAd->purchase_url }}">
                                                    <i class="fas fa-shopping-cart"></i> Order Now
                                                </a>
                                            </p>
                                            <small class="transaction-notice">Note: Purchases are between you and the person
                                                doing the run. <span>This site does not handle any
                                                    transactions.</span></small>
                                        @else
                                            Run is currently only open to those who registered interest. It will become an
                                            open run once those people have had a chance to purchase.
                                        @endif

                                    @elseif($data->status == 'Gathering_Interest')
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
                                            <p><a class="btn btn-primary mx-auto"
                                                    href="{{ route('parts-run.interested', [$data->id, 'interest' => 'no', 'quantity' => 0]) }}">Remove
                                                    Interest!</a></p>
                                        @else

                                            @if ($data->partsRunAd->quantity == 0 || $data->partsRunAd->quantity > $data->interested->count())
                                                <form action="{{ route('parts-run.interested', $data->id) }}"
                                                    method="GET">

                                                    <input size=4 type=number value="1" name="quantity">
                                                    <input type="hidden" name="interest" value="interested">
                                                    <input class="btn btn-primary" type=submit value="Interested">
                                                </form>
                                                Note: Registering interest is not a commitment to buy, but please only do so
                                                if you think you will. This will give the person doing the run access to
                                                your email address.
                                            @else
                                                <p>Interest List is Full</p>
                                            @endif
                                        @endif
                                    @else
                                        <p>This run is inactive. Please wait for it to become active again.</p>
                                    @endif
                                </div>

                                <div class="col-12 col-xl-6 equal">
                                    <p class="droid"><strong>Contact Email: </strong></p>
                                    <p>
                                        <a class="p-link" href="mailto:{{ $data->partsRunAd->contact_email }}">
                                            {{ $data->partsRunAd->contact_email }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="form-section text-center db-my-1">
                                <div class="col-12">
                                    <p class="history-text"><strong>History:</strong></p>
                                    <p>{{ $data->partsRunAd->history }}</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Parts Run Main Image --}}
                    <div class="col-12 col-sm-6 order-1 part-run-image">
                        <div class="image-wrapper">
                            {{-- Run IF Statement, if has no image, use dummy placeholder - please keep baby yoda!! --}}
                            <img src="https://snipdaily.com/wp-content/uploads/2020/01/baby-yoda-disneyplus-1024x574.jpg"
                                width=500 height=500>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Comments --}}
            <div class="build-section">
                <div class="row w-100">
                    <div class="col-12 text-center db-mb-1">
                        <h4>Comments</h4>
                    </div>

                    <div class="col-12">
                        <div class="comment-card">
                            <div class="overlay"></div>
                            @foreach ($data->comments as $comment)
                                <div class="comment">
                                    <div class="comment-header">
                                        <h5>
                                            <strong>
                                                {{ $comment->user->forename ?? 'Deactivated' }}
                                                {{ $comment->user->surname ?? 'User' }}
                                                @if ($comment->user != null)
                                                    @if ($comment->user->can('Edit Partsrun'))
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
                                        @can('Edit Partrun')
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
                                    <form action="{{ route('comment.add', [ 'id' => $data->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="model" value="App\PartsRunData">

                                        <div class="form-group">
                                            <textarea type="text" class="form-control" name="body"></textarea>
                                        </div>

                                        @can('Edit Partrun')
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
        </div>
    </div>

    {{-- <div class="modal fade" id="shipModal" tabindex="-1" role="dialog" aria-labelledby="shipModalLabel" aria-hidden="true">
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
    </div> --}}

    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            $(this).ekkoLightbox();
            event.preventDefault();
        });
    </script>
@endsection
