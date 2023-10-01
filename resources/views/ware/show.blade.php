@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <div class="col-sm-2 text-left">
                    @if(Auth::user()->id == $ware->user->id)
                        <a class="btn btn-primary" href={{ route('ware.edit', $ware->id) }}>Edit Item</a>
                    @endif
                </div>
                <div class="col-sm-8 text-center">
                    <h4 class="text-center title">{{$ware->title}}</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <a class="btn btn-primary" href="{{ route('ware.index') }}">Back</a>
                </div>
            </div>
        </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                <div id="user">Name: {{ $ware->user->forename }} {{ $ware->user->surname }}</div>
                <div id="user">Country: {{ $ware->user->country }}</div>
                @if($ware->showemail)
                  <div id="user">Email: {{ $ware->user->email }}</div>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                Description:
                <div id="description">{!! $ware->description !!}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id='app'>
    @include('partials.comments', ['comments' => $ware->comments, 'permission' => 'Edit Auction', 'model_type' => 'App\Models\Ware', 'model_id' => $ware->id])
</div>

@endsection