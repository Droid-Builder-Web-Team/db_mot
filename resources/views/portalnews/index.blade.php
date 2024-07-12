@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
          <div class="col-sm-2 text-left">
            @can('Edit Members')
              <a class="btn btn-primary" href={{ route('news.create') }}>Create Article</a>
            @endcan
          </div>
          <div class="col-sm-8 text-center">
            <h4 class="text-center title">News and Updates</h4>
          </div>
          <div class="col-sm-2 text-right"></div>
        </div>
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
