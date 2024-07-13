@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <div class="row d-flex align-items-center">
          <div class="col-sm-2 text-left">
            @hasanyrole('Super Admin|Org Admin')
              <a class="btn btn-primary" href={{ route('portalnews.create') }}>Create Article</a>
            @endhasanyrole
          </div>
          <div class="col-sm-8 text-center">
            <h4 class="text-center title">News and Updates</h4>
          </div>
          <div class="col-sm-2 text-right"></div>
        </div>
      </div>




      <div class="card-body">
        <div class="table text-center card-body table-striped table-hover table-dark">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $article)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($article->created_at)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
                            <td><a href="{{ route('portalnews.show',$article->id) }}">{{ $article->title }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
