@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @foreach($partsRunData as $data)
            <div class="card-header">
                <h4 class="text-center title">Editing Parts Run #{{ $data->id }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('part-runs.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Title</span>
                                </div>
                                <input type="text" name="title" value="{{ $data->partsRunAd->title }}" class="form-control" placeholder="Title">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Price</span>
                                </div>
                                <input type="number" name="price" value="{{ $data->partsRunAd->price }}" class="form-control" placeholder="Price">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">User</span>
                                </div>
                                <input type="text" name="user" value="{{ $data->user->username }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Club</span>
                                </div>
                                <input type="text" name="droid" value="{{ $data->club->name }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Location</span>
                                </div>
                                <input type="text" name="location" value="{{ $data->partsRunAd->location }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Shipping Costs</span>
                                </div>
                                <input type="text" name="shipping_costs" value="{{ $data->partsRunAd->shipping_costs }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Description</span>
                                </div>
                                <input type="text" name="description" value="{{ $data->partsRunAd->description }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Includes</span>
                                </div>
                                <textarea type="text" name="includes" value="{{ $data->partsRunAd->includes }}" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Purchase URL</span>
                                </div>
                                <input type="text" name="location" value="{{ $data->partsRunAd->purchase_url }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Email</span>
                                </div>
                                <input type="text" name="contact_email" value="{{ $data->partsRunAd->contact_email }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">History</span>
                                </div>
                                <input type="text" name="history" value="{{ $data->partsRunAd->history }}" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-3">
                        <button type="submit" style="width:auto;" class="btn btn-mot">Submit</button>
                        </div>
                    </div>
                </form>


                <div class="row">

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
            </div>
        @endforeach
    </div>
</div>
</div>
@endsection
