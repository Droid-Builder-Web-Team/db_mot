@extends('layouts.app')

@section('content')
    <div class="build-section d-flex">
        <div class="container-fluid">
            <div class="row">
                @foreach($partsRunData as $data)
                    <div class="col-12">
                        <h4 class="db-my-1">Edit Part Run #{{ $data->id }}</h4>
                    </div>

                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('parts-run.update', $data->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row form-group">
                                <div class="col-12 col-lg-6 d-flex flex-column justify-content-start">
                                    {{Form::hidden('open','0')}}
                                    <label for="open_for_all">Open for all</label>                                    
                                    <input type="checkbox" id="open_for_all" name="open" {{ $data->open ? 'checked=1 value=1' : 'value=1' }} class="form-control">
                                    <small id="openHelp" class="form-text text-muted">Open for all members, regardless whether they registered interest</small>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="status">Parts Run Status</label>
                                    <select id="status" name="status" class="custom-select">
                                        <option {{ ($data->status) == 'Initial' ? 'selected' : '' }} value="Initial">Initial</option>
                                        <option {{ ($data->status) == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                        <option {{ ($data->status) == 'Gathering_Interest' ? 'selected' : '' }} value="Gathering_Interest">Gathering Interest</option>
                                        <option {{ ($data->status) == 'Inactive' ? 'selected' : '' }} value="Inactive">Inactive</option>
                                    </select>
                                    <small id="statusHelp" class="form-text text-muted">Current status of this parts run </small>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-lg-6">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title" value="{{ $data->partsRunAd->title }}" class="form-control" placeholder="Title" required>
                                    <small id="titleHelp" class="form-text text-muted">Title of the run - what part(s) are you selling?</small>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="price">Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon2">£</span>
                                        </div>
                                        <input type="float" id="price" name="price" value="{{ $data->partsRunAd->price }}" class="form-control" placeholder="Price" required>
                                    </div>

                                    <small id="priceHelp" class="form-text text-muted">Price of the part <b><i>excluding shipping</i></b></small>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-lg-6">
                                    <label for="location">Location</label>
                                    <input type="text" id="locatin" name="location" value="{{ $data->partsRunAd->location }}" class="form-control">
                                    <small id="locationHelp" class="form-text text-muted">Where are you in the world? Town/City only</small>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="shipping">Shipping Costs</label>
                                    <input type="text" id="shipping" name="shipping_costs" value="{{ $data->partsRunAd->shipping_costs }}" class="form-control">
                                    <small id="shippingHelp" class="form-text text-muted">Where do you ship this part to and what are the costs of shipping?</small>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" style="height:150px" id="description" name="description" placeholder="Description">
                                        {{ $data->partsRunAd->description }}
                                    </textarea>
                                    <small id="descriptionHelp" class="form-text text-muted">Description of the part. Please give as much detail as possible.</small>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-lg-6">
                                    <label for="includes">Includes</label>
                                    <textarea type="text" id="includes" name="includes" class="form-control">{{ $includes }}</textarea>
                                    <small id="includesHelp" class="form-text text-muted">List ALL items that are included in this run.</small>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="history">History</label>
                                    <textarea type="text" id="history" name="history" value="{{ $data->partsRunAd->history }}" class="form-control"></textarea>
                                    <small id="historyHelp" class="form-text text-muted">Only applicable for parts runs that have been going for a while but any history about the run is always nice to read.</small>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12">
                                    <label for="quantity">Quantity</label>
                                    <input size=10 type="number" id="quantity" name="quantity" value="{{ $data->partsRunAd->quantity }}" class="form-control" placeholder="Quantity" required>
                                    <small id="quantityHelp" class="form-text text-muted">What is the quantity of this run? Insert 0 for continuous runs.</small>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-lg-6">
                                    <label for="purchase_url">Purchase Link</label>
                                    <input type="text" id="purchase_url" name="purchase_url" value="{{ $data->partsRunAd->purchase_url }}" class="form-control">
                                    <small id="purchaseHelp" class="form-text text-muted">Link to buy your part (usually astromech or your own store).</small>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="contact_email">Contact Email</label>
                                    <input type="text" id="contact_email" name="contact_email" value="{{ $data->partsRunAd->contact_email }}" class="form-control">
                                    <small id="contactEmailHelp" class="form-text text-muted">An email address members can contact you on with questions.</small>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="buttons">
                                    <button type="submit" class="btn btn-submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'autolink lists table link hr autoresize code image media',
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | table | link image media | hr code ',
            toolbar_mode: 'floating',
            image_caption: true,
            invalid_elements: "span"
        });
    </script>
@endsection
