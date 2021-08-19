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
                     <div class="form-group row">
                        <div class="col-12">
                            <label for="parts_run_status" class="col-4 col-form-label">Parts Run Status</label> 
                            <div class="col-12">
                                <select id="parts_run_status" name="parts_run_status" value="{{ $data->status }}" class="custom-select" required="required">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Gathering_Interest">Gathering Interest</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="title" class="col-4 col-form-label">Title</label> 
                            <div class="col-12">
                                <input type="text" name="title" value="{{ $data->partsRunAd->title }}" class="form-control" placeholder="Title" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="price" class="col-4 col-form-label">Price</label> 
                            <div class="col-12">
                            <input type="number" name="price" value="{{ $data->partsRunAd->price }}" class="form-control" placeholder="Price" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="select" class="col-4 col-form-label">Club</label> 
                            <div class="col-12">
                                <select id="club_id" name="club_id" class="custom-select">
                                    <option value="null">Select a club</option>
                                    @foreach($clubs as $club)
                                        <option value={{ $club->id }}>{{ $club->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="select1" class="col-4 col-form-label">BC Rep</label> 
                            <div class="col-12">
                                <select id="bc_rep_id" name="bc_rep_id" class="custom-select">
                                    <option value="null">Please select club first</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="location" class="col-4 col-form-label">Location</label> 
                            <div class="col-12">
                                <input type="text" name="location" value="{{ $data->partsRunAd->location }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="shipping_costs" class="col-4 col-form-label">Shipping Costs</label> 
                            <div class="col-12">
                                <input type="text" name="shipping_costs" value="{{ $data->partsRunAd->shipping_costs }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="description" class="col-4 col-form-label">Description</label> 
                            <div class="col-12">
                                <input type="text" name="description" value="{{ $data->partsRunAd->description }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="includes" class="col-4 col-form-label">Includes</label> 
                            <div class="col-12">
                                <textarea type="text" name="includes" value="{{ $data->partsRunAd->includes }}" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="includes" class="col-4 col-form-label">History</label> 
                            <div class="col-12">
                                <textarea type="text" name="history" value="{{ $data->partsRunAd->history }}" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="purchase_url" class="col-4 col-form-label">Purchase URL</label> 
                            <div class="col-12">
                                <input type="text" name="purchase_url" value="{{ $data->partsRunAd->purchase_url }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="email" class="col-4 col-form-label">Email</label> 
                            <div class="col-12">
                                <input type="text" name="contact_email" value="{{ $data->partsRunAd->contact_email }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="text" class="col-4 col-form-label">Instructions</label> 
                            <div class="col-12">
                                <input type="file" name="instructions" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="text1" class="col-4 col-form-label">Image</label> 
                            <div class="col-12">
                                <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                            <div class="image-preview mt-3" style="width: 400px; height: 400px;">
                                <img src="{{ route('image.displayPartsRunImage', $data->id) }}" class="img-fluid">
                            </div>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" style="width:auto;" class="btn btn-mot">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>
</div>
@endsection
