@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @foreach($partsRunData as $data)
            {{-- <pre><?php print_r($data); exit; ?></pre> --}}
            <div class="card-header">
                <h4 class="text-center title">Editing Parts Run #{{ $data->id }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('parts-run.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                     <div class="form-group row">
                        <div class="col-10">
                            <label for="status" class="col-4 col-form-label">Parts Run Status</label>
                            <div class="col-10">
                                <select id="status" name="status" class="custom-select">
                                    <option {{ ($data->status) == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                    <option {{ ($data->status) == 'Inactive' ? 'selected' : '' }} value="Inactive">Inactive</option>
                                    <option {{ ($data->status) == 'Gathering_Interest' ? 'selected' : '' }} value="Gathering_Interest">Gathering Interest</option>
                                    <option {{ ($data->status) == 'Initial' ? 'selected' : '' }} value="Initial">Initial</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 mb-2">
                          {{Form::hidden('open','0')}}
                          <label>Open for all</label>
                          <input type="checkbox" name="open" {{ $data->open ? 'checked=1 value=1' : 'value=1' }} class="form-control">
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
                            <input type="float" name="price" value="{{ $data->partsRunAd->price }}" class="form-control" placeholder="Price" required>
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
                            <label for="shipping_costs" class="col-4 col-form-label">Shipping Costs (UK)</label>
                            <div class="col-12">
                                <input type="text" name="shipping_costs" value="{{ $data->partsRunAd->shipping_costs }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="description" class="col-4 col-form-label">Description</label>
                            <div class="col-12">
                                <textarea class="form-control" style="height:150px" id="description" name="description" placeholder="Description">
                                  {{ $data->partsRunAd->description }}
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="includes" class="col-4 col-form-label">Includes</label>
                            <div class="col-12">
                                <textarea type="text" name="includes" class="form-control">{{ $includes }}</textarea>
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
                            <label for="quantity" class="col-6 col-form-label">Quantity (Enter 0 for a continuous run/no limit)</label>
                            <div class="col-12">
                                <input size=10 type="number" name="quantity" value="{{ $data->partsRunAd->quantity }}" class="form-control" placeholder="Quantity" required>
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
                            <label for="purchase_url" class="col-4 col-form-label">Purchase URL</label>
                            <div class="col-12">
                                <input type="text" name="purchase_url" value="{{ $data->partsRunAd->purchase_url }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="purchase_url_type" class="col-4 col-form-label">Purchase URL Type</label>
                            <div class="col-12">
                                <select class="form-control" name="purchase_url_type">
                                    @foreach($data->partsRunAd->purchaseTypes() as $key => $value)
                                        <option value="{{ $key }}"
                                            @if($key == $data->partsRunAd->purchase_url_type)
                                                selected
                                            @endif
                                        >{{ $value }}</option>
                                    @endforeach
                                </select>
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
        image_caption: true
    });
</script>
@endsection
