@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @foreach($partsRunData as $data)
            <div class="card-header padding-container">
                <div class="mb-4 text-center row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-3 club">
                        <h6>Club: {{ $data->club->name }}</h6>
                    </div>
                    <div class="col-12 col-md-3 active_since">
                        <h6>Active Since: {{  \Carbon\Carbon::createFromTimeString($data->partsRunAd->updated_at)->format('d/m/Y') }}</h6>
                    </div>
                    <div class="col-12 col-md-3 status">
                        <h6>Status: {{ $data->status }}</h6>
                    </div>
                </div>
                @role('Super Admin')
                <div class="text-center row">
                    <div class="col-12">
                        <a class="btn btn-primary" href={{ route('part-runs.edit', $data->id) }}>Edit Run</a>
                        {{-- <a class="btn btn-danger" href={{ route('part-runs.destroy', $data->id) }}>Delete Run</a> --}}
                    </div>
                </div>
                @endrole
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
                                            <p class="pr-1 price"><strong>Price:</strong></p>
                                            <?php echo '£' . number_format($data->partsRunAd->price, 2); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="parts-run-break">

                            <div class="mb-4 row">
                                <div class="seller-info">
                                    <div class="col-12 col-md-6">
                                        <p class="seller"><strong>Seller:</strong> {{ $data->user->username }}</p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="droid"><strong>Club:</strong> {{ $data->club->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
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

                            <div class="mb-4 row">
                                <div class="description">
                                    <div class="col-12">
                                        <p class="description-text"><strong>Description:</strong></p>
                                        <p>{{ $data->partsRunAd->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
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
                            <div class="mb-4 row">
                                <div class="purchase-email">
                                    <div class="col-12 col-md-4">
                                        @if($data->status == "Active")
                                            <p><strong>Purchase Link:</strong></p>
                                            <p><a class="btn btn-primary" href="{{ $data->partsRunAd->purchase_url }}"> Buy Here</a></p>
                                        @elseif($data->status == "Gathering_Interest")
                                            <p><strong>Register Your Interest:</strong></p>
                                            <p><a class="btn btn-primary" href="#">Interested!</a></p>
                                        @else
                                            <p>This run is inactive. Please wait for it to become active again.</p>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-4">
                                        @if($data->status == "Gathering_Interest")
                                            <p><strong>Interest List:</strong></p>
                                            <ul>
                                                <li>Test</li>

                                            </ul>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <p class="droid"><strong>Contact Email: </strong></p>
                                        <p><a href="mailto:{{ $data->partsRunAd->contact_email }}"> {{ $data->partsRunAd->contact_email }}</a></p>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="instructions">
                                    <div class="col-12">
                                        <p class="instructions"><strong>Instructions:</strong></p>

                                        @if(is_null($data->partsRunAd->instructions->filename))
                                            <p>Test</p>
                                        @elseif(is_null($data->partsRunAd->instructions->url))
                                            <p><a href="{{ $data->partsRunAd->instructions->filepath }}"> {{ $data->partsRunAd->instructions->title }}</a></p>
                                        @else
                                            <p>No Instructions Given :(</p>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="image-wrapper" style="display:flex; justify-content:right;">
                            <a href="{{ route('image.displayPartsRunImage', $data->id) }}" data-toggle="lightbox">
                                <img src="{{ route('image.displayPartsRunImage', $data->id) }}" class="img-fluid">
                            </a>
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
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        Comments
      </div>
      <div class="card-body">
@foreach($data->comments as $comment)
        <div class="card border-primary">
          <div class="card-header">
            <strong>{{ $comment->user->forename ?? "Deactivated"}} {{ $comment->user->surname ?? "User"}}</strong>
            @if ($comment->user != NULL)
              @if ($comment->user->can('Edit Partsrun'))
                <i class="fas fa-user-shield"></i>
              @endif
            @endif
            <span class="float-right">
              @if ($comment->broadcast)
                <i class="fas fa-bullhorn"></i>
              @endif
              {{ Carbon\Carbon::parse($comment->created_at, Auth::user()->settings()->get('timezone'))->isoFormat(Auth::user()->settings()->get('date_format').' - '.Auth::user()->settings()->get('time_format')) }}
            </span>
          </div>
          <div class="card-body">
            {!! nl2br(e($comment->body)) !!}
            @can('Edit Partsrun')
            <span class="float-right">
              <a href="{{ route('admin.parts-run.delete_comment', $comment->id )}}" class="btn-sm btn-danger">Delete</a>
            </span>
            @endcan
          </div>
        </div>
@endforeach
        <div class="card border-primary">
          <div class="card-header">
            <strong>Add Comment</strong>
          </div>
          <div class="card-body">
            <form action="{{ route('parts-run.comment', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
              <div class="form-group">
                <textarea type="text" class="form-control" name="body"></textarea>
              </div>
              <input type="submit" class="btn-sm btn-comment" name="comment" value="Add Comment">
              @can('Edit Partrun')
                <div class="form-check float-right">
                  <input class="form-check-input" type="checkbox" name="broadcast" id="broadcast">
                  <label class="form-check-label" for="broadcast">Broadcast</label>
                </div>
              @endcan
            </form>
          </div>
        </div>
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
