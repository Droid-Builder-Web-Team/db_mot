@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">Portal News</h4>
      </div>
      <div class="card-body">
        <ul>
          @foreach($news as $article)
              <li>{{ \Carbon\Carbon::parse($article->created_at)->isoFormat(Auth::user()->settings()->get('date_format')) }} - <a href="{{ route('portalnews.show',$article->id) }}">{{ $article->title }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
