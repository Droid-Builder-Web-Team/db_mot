@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
      <div class="card">
            @foreach($partsRun as $data)
            <div class="card-header">
                <h4 class="text-center title">{{ $data->title }}</h4>
            </div>
            <div class="card-body">
                <div class="seller-wrapper d-flex align-items-baseline">
                    <h3>Seller: </h3>
                    <p> {{ $data->partsRun->user->username }}</p>
                </div>
                <div class="droid-wrapper d-flex align-items-baseline">
                    <h3>Droid: </h3>
                    <p> {{ $data->partsRun->droidType->name }}</p>
                </div>
                <div class="text-center part-content">
                    <div class="title">
                        <p>Title: {{ $data->title }}</p>
                    </div>
                    <div class="description">
                        <p>Description: {{ $data->description }}</p>
                    </div>
                    <div class="price">
                        <p>Price: {{ $data->price }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
  </div>
</div>
@endsection
