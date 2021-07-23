@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center title">Create A Parts Run</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('part-runs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Title</span>
                                </div>
                                <input type="text" name="title" class="form-control" placeholder="Title">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Price</span>
                                </div>
                                <input type="number" name="price"  class="form-control" placeholder="Price">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">User</span>
                                </div>
                                <input type="text" name="user"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Droid</span>
                                </div>
                                <input type="text" name="droid"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Location</span>
                                </div>
                                <input type="text" name="location"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Shipping Costs</span>
                                </div>
                                <input type="text" name="shipping_costs"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Description</span>
                                </div>
                                <input type="text" name="description"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Includes</span>
                                </div>
                                <textarea type="text" name="includes" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Purchase URL</span>
                                </div>
                                <input type="text" name="purchase_url"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Email</span>
                                </div>
                                <input type="text" name="contact_email"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Instructions</span>
                                    <input type="file" name="instructions" class="form-control-file" id="exampleFormControlFile1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Image</span>
                                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">History</span>
                                </div>
                                <textarea type="text" name="history"  class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-3">
                        <button type="submit" style="width:auto;" class="btn btn-mot">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
</div>
@endsection
