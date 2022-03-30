@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
      <div class="card">
        <div class="card-header">
          <h4 class="title text-center">{{$article->title}}</h4>
        </div>
        <div class="card-body">
            <h3>{{ \Carbon\Carbon::parse($article->created_at)->isoFormat(Auth::user()->settings()->get('date_format')) }}</h3>
            <div id="news_description">{!! $article->message !!}</div>

        </div>
      </div>
    </div>
  </div>
@endsection
