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
          <h5>Active Since: {{  \Carbon\Carbon::createFromTimeString($data->partsRunAd->updated_at)->format('d/m/Y') }}</h5>
        </div>
        <div class="col-12 col-md-4">
          <h5>Status: {{ $data->status }}</h5>
        </div>
        <div class="col-12 col-md-4">
          <h5>BC Rep: {{ $data->bcRep->forename }} {{ $data->bcRep->surname }}</h5>
        </div>

        <div class="col-12">
          <div class="buttons">
            @hasrole('BC Rep')
              <a class="btn btn-edit" href={{ route('parts-run.edit', $data->id) }}>
                <i class="fas fa-eye"></i> Edit Run
              </a>
            @endhasrole
            @can('Create Partrun')
              <a class="btn btn-delete" href={{ route('parts-run.destroy', $data->id) }}>
                <i class="fas fa-trash-alt"></i> Delete Run
              </a>
            @endcan
          </div>
        </div>
      </div>

      {{-- Run Details --}}
      <div class="build-section">
        <div class="row form-wrapper d-flex justify-content-start align-items-center">
          <div class="col-12 col-md-8">
            <div class="row">
              <div class="col-12 col-md-6 d-flex justify-content-start">
                <p class="title"><strong>{{ $data->partsRunAd->title }}</strong></p>
              </div>
              <div class="col-12 col-md-6 d-flex flex-row justify-content-start">
                <p class="title"><strong>Price: </strong>
                  <small><?php echo '£' . number_format($data->partsRunAd->price, 2); ?></small>
                </p>
              </div>
              <div class="divider"></div>
    
              <div class="form-section text-center text-sm-left db-my-1">
                <div class="col-12 col-md-6">
                  <p class="seller"><strong>Seller:</strong> {{ $data->user->forename }} {{ $data->user->surname }}</p>
                </div>
    
                <div class="col-12 col-md-6">
                    <p class="droid"><strong>Club:</strong> {{ $data->club->name }}</p>
                </div>
              </div>
    
              <div class="form-section text-center text-sm-left db-my-1">
                <div class="col-12 col-md-6">
                  <p class="location"><strong>Location:</strong> {{ $data->partsRunAd->location }}</p>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                  <p class="pr-1 droid"><strong>Shipping Costs:</strong></p>
                  <ul>
                    @foreach($shippingCostsArray as $s)
                        <li>{{ $s }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>

              <div class="form-section text-center text-sm-left db-my-1">
                <div class="col-12">
                  <p class="description-text"><strong>Description:</strong></p>
                  <p>{!! $data->partsRunAd->description !!}</p>
                </div>
              </div>

              <div class="form-section text-center text-sm-left dbmy-1">
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

              <div class="form-section text-center text-sm-left db-my-1">
                <div class="col-12 col-md-6 equal">
                  @if($data->status == "Active")
                    <p><strong>Purchase Link:</strong></p>
                      @if($data->open == 1)
                        <p>
                          <a class="btn btn-purchase" target=_blank href="{{ $data->partsRunAd->purchase_url }}">
                            <i class="fas fa-shopping-cart"></i> Order Now
                          </a>
                        </p>
                        <small class="transaction-notice">Note: Purchases are between you and the person doing the run. <span>This site does not handle any transactions.</span></small>
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

              <div class="col-12 col-md-6 equal">
                  <p class="droid"><strong>Contact Email: </strong></p>
                  <p><a href="mailto:{{ $data->partsRunAd->contact_email }}"> {{ $data->partsRunAd->contact_email }}</a></p>
              </div>
              </div>

            </div>
          </div>

          {{-- Parts Run Main Image --}}
          <div class="col-12 col-md-4">
            <div class="image-wrapper">
              <img src="https://snipdaily.com/wp-content/uploads/2020/01/baby-yoda-disneyplus-1024x574.jpg" width=500 height=500>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    jQuery(function () {
      $('.match').matchHeight();
    });

    // jQuery('.equal').matchHeight({ byRow: false });
  </script>
@endsection
