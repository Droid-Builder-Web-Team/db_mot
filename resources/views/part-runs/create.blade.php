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
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Title</span>
                                </div>
                                <input type="text" name="title" class="form-control" placeholder="Title">
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Price</span>
                                </div>
                                <input type="number" name="price"  class="form-control" placeholder="Price">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                      <div class="mb-3 col-md-6">
                          <div class="mb-3 input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text">Club</span>
                              </div>
                              <select id="club_id" name="club_id">
                                <option value="null">Select Club</option>
                                @foreach($clubs as $club)
                                  <option value={{ $club->id }}>{{ $club->name }}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                          <div class="mb-3 col-md-6">
                              <div class="mb-3 input-group">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text">BC Rep</div>
                                      <select id="bc_rep_id" name="bc_rep_id">
                                        <option value="null">Please select club first</option>
                                      </select>
                                  </div>
                              </div>
                          </div>

                    </div>

                    <div class="form-row">
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Location</span>
                                </div>
                                <input type="text" name="location"  class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Shipping Costs</span>
                                </div>
                                <input type="text" name="shipping_costs"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 col-md-12">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Description</span>
                                </div>
                                <input type="text" name="description"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Includes</span>
                                </div>
                                <textarea type="text" name="includes" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">History</span>
                                </div>
                                <textarea type="text" name="history"  class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Purchase URL</span>
                                </div>
                                <input type="text" name="purchase_url"  class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contact Email</span>
                                </div>
                                <input type="text" name="contact_email"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Instructions</span>
                                    <input type="file" name="instructions" class="form-control-file" id="exampleFormControlFile1">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Image</span>
                                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 text-center col-xs-12 col-sm-12 col-md-12">
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
