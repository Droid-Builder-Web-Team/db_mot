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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                     <div class="form-group row">
                        <div class="col-12">
                            <label for="status" class="col-4 col-form-label">Parts Run Status</label> 
                            <div class="col-12">
                                <select id="status" name="status" class="custom-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Gathering_Interest">Gathering Interest</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="title" class="col-4 col-form-label">Title</label> 
                            <div class="col-12">
                                <input type="text" name="title"  class="form-control" placeholder="Title of Parts Run" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="price" class="col-4 col-form-label">Price</label> 
                            <div class="col-12">
                            <input type="number" name="price" class="form-control" placeholder="Cost of Parts Run" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="select" class="col-4 col-form-label">Club</label> 
                            <div class="col-12">
                                <select id="club_id" name="club_id" class="custom-select"  required>
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
                                <select id="bc_rep_id" name="bc_rep_id" class="custom-select" required>
                                    <option value="null">Please select club first</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="location" class="col-4 col-form-label">Location</label> 
                            <div class="col-12">
                                <input type="text" name="location" class="form-control" placeholder="Where is the run coming from?" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="shipping_costs" class="col-4 col-form-label">Shipping Costs</label> 
                            <div class="col-12">
                                <input type="text" name="shipping_costs" class="form-control" placeholder="What are the standard shipping costs?" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="description" class="col-4 col-form-label">Description</label> 
                            <div class="col-12">
                                <input type="text" name="description" class="form-control" placeholder="A detailed description of the part run" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="includes" class="col-4 col-form-label">Includes</label> 
                            <div class="col-12">
                                <textarea type="text" name="includes" class="form-control" placeholder="What is included in this run?"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="includes" class="col-4 col-form-label">History</label> 
                            <div class="col-12">
                                <textarea type="text" name="history" class="form-control" placeholder="Optional History of Parts Run"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="purchase_url" class="col-4 col-form-label">Purchase URL</label> 
                            <div class="col-12">
                                <input type="text" name="purchase_url" class="form-control" placeholder="Link to purchase the part" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="email" class="col-4 col-form-label">Email</label> 
                            <div class="col-12">
                                <input type="text" name="contact_email" class="form-control" value="{{ Auth()->user()->email }}" placeholder="Contact Email for Seller"  required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="text" class="col-4 col-form-label">Instructions</label> 
                            <div class="col-12">
                                <input type="file" name="instructions" class="form-control-file" id="exampleFormControlFile1" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="text1" class="col-4 col-form-label">Image</label> 
                            <div class="col-12">
                                <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" required>
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
    </div>
</div>
</div>

<script type="text/javascript">
$('#club_id').change(function() {
  let dropdown = $('#bc_rep_id');

  dropdown.empty();

  dropdown.append('<option value="null">Select Your BC Rep</option>');
  dropdown.prop('selectedIndex', 0);

  const url = '{{ URL::to('/') }}/bcreps/' + this.value;

  $.getJSON(url, function(data) {
    $.each(data, function (key, entry) {
      dropdown.append($('<option></option>').attr('value', entry.id).text(entry.forename + ' ' + entry.surname));
    })
  })

})
</script>
@endsection
