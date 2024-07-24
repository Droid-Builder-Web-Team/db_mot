@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
      <div class="card">
        <div class="card-header">
          <div class="row d-flex align-items-center">
            <div class="col-sm-2 text-left">
              @hasanyrole('Super Admin|Org Admin')
                <a class="btn btn-primary" href={{ route('portalnews.edit', $article->id) }}>{{  __('Edit Article') }}</a>
              @endhasanyrole
            </div>
            <div class="col-sm-8 text-center">
              <h4 class="text-center title">{{$article->title}}</h4>
            </div>
            <div class="col-sm-2 text-right">
              @hasanyrole('Super Admin|Org Admin')
              <form action="{{ route('portalnews.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-danger"><i style="color:#FFF;" class="fas fa-trash-alt"></i></button>
            </form>
              @endhasanyrole
            </div>
          </div>
        </div>
        <div class="card-body">
            <h3>{{ \Carbon\Carbon::parse($article->created_at)->isoFormat(Auth::user()->settings()->get('date_format')) }}</h3>
            @if( $article->created_at != $article->updated_at)
              <div class="row"><div class="col-md-2"><strong>{{  __('Updated') }}:</strong></div><div class="col-md-10">{{ $article->updated_at }}</div></div>
            @endif
            <div id="news_description">{!! $article->message !!}</div>

        </div>
      </div>
    </div>
  </div>
@endsection
