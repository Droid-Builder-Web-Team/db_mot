@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @foreach($partsRunData as $data)
            <div class="card-header">
                <h4 class="text-center title">Parts Run #{{ $data->id }} - BC Rep: olivers - {{ $data->status }}</h4>
                <a class="btn btn-primary" href={{ route('part-runs.edit', $data->id) }}>Edit Run</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="text-left part-content">
                            <div class="row">
                                <div class="run-header">
                                    <div class="col-12 col-md-6">
                                        <p class="title"><strong>{{ $data->partsRunAd->title }}</strong></p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <p class="pr-1 price"><strong>Price:</strong> </p>
                                            @money($data->partsRunAd->price)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="parts-run-break">

                            <div class="row">
                                <div class="seller-info">
                                    <div class="col-12 col-md-6">
                                        <p class="seller"><strong>Seller:</strong> {{ $data->user->username }}</p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="droid"><strong>Droid:</strong> {{ $data->droidType->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
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

                            <div class="row">
                                <div class="description">
                                    <div class="col-12">
                                        <p class="description-text"><strong>Description:</strong></p>
                                        <p>{{ $data->partsRunAd->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
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
                            <div class="row">
                                <div class="purchase-email">
                                    <div class="col-12 col-md-6">
                                        <p class="location"><strong>Purchase Link:</strong></p>
                                        <p><a class="btn btn-primary" href="{{ $data->partsRunAd->purchase_url }}"> Buy Here</a></p>
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
                                        @if(is_null($data->partsRunAd->instructions->filepath))
                                            <p><a href="{{ $data->partsRunAd->instructions->url }}"> {{ $data->partsRunAd->instructions->title }}</a></p>
                                        @elseif(is_null($data->partsRunAd->instructions->url))
                                            <p><a href="{{ $data->partsRunAd->instructions->filepath }}"> {{ $data->partsRunAd->instructions->title }}</a></p>
                                        @else
                                            <p>No Instructions Given :()</p>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="image-wrapper" style="display:flex; justify-content:right;">
                            <a href="https://cdn.shopify.com/s/files/1/0174/8616/products/R_series_data_port_and_cbi_logic_set_1024x1024.jpg?v=1571706165" data-toggle="lightbox">
                                <img src="https://cdn.shopify.com/s/files/1/0174/8616/products/R_series_data_port_and_cbi_logic_set_1024x1024.jpg?v=1571706165" class="img-fluid">
                            </a>
                            {{-- <a href="https://unsplash.it/1200/768.jpg" data-toggle="lightbox">
                                <img src="https://unsplash.it/600.jpg" class="img-fluid">
                            </a> --}}
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
        @endforeach
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