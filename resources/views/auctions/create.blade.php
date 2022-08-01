@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-2 text-left">
                    </div>
                    <div class="col-sm-8 text-center">
                        <h4 class="text-center title">Charity Auctions</h4>
                    </div>
                    <div class="col-sm-2 text-right">
                        <a class="btn btn-primary" href="{{ route('auctions.index') }}">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('auctions.store') }}" method="POST">
                    @csrf

                    <input type=hidden name="user_id" value="{{ Auth::user()->id }}">
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <div class="form-group">
                                <strong>Title:</strong>
                                <input type="text" name="title" class="form-control" placeholder="Title" value='{{ old('title') }}'>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <strong>Type:</strong><br>
                                <select name=type>
                                        <option value="standard">Standard (eBay style)</option>
                                        <option value="silent">Silent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <label for="description"><strong>Description:</strong></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <textarea class="form-control" style="height:550px" id="description" name="description" placeholder="Event Description"></textarea>
                        </div>
                    </div>


                    <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <strong>Country:</strong><br>
                                <select name=country>
                                        <option value="united kingdom">United Kingdom</option>
                                        <option value="united states">United States</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <strong>Currency:</strong><br>
                                <select name=currency>
                                        <option value="gbp">GBP (£)</option>
                                        <option value="usd">USD ($)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <strong>Finish Time:</strong>
                                <input type="datetime-local" name=finish_time>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <strong>Timezone:</strong><br>
                                <select name=timezone>
                                        <option value="Europe/London">British Summer Time</option>
                                        <option value="America/New York">Grenwich Mean Time</option>
                                </select>
                            </div>
                        </div>                        
                    </div>


                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'autolink lists table link hr autoresize',
        toolbar: 'table numlist bullist link hr',
        toolbar_mode: 'floating',
    });
</script>
@endsection