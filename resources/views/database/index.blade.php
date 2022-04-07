@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h2>Droid Database</h2>
    </div>
    <div class="card-content">
        <ul class="nav nav-tabs nav-justified">
            @foreach($clubs as $club)
                @if($club->droids->count() > 0)
                    <li><a data-toggle="tab" class="nav-item nav-link" href="#club{{$club->id}}">{{$club->name}}</a></li>
                @endif
            @endforeach
        </ul>


        <div class="tab-content md-4">
            @foreach($clubs as $club)
                <div id="club{{$club->id}}" class="tab-pane fade">
                    <h4>{{$club->name}}</h4>
                    <div class="row md-4">
                        @foreach($club->droids as $droid)
                            @if($droid->public == 'Yes')
                                <div class="mx-auto my-auto text-center col-md-3 droid-card">
                                    <div class="droid-card-content">
                                        <div style="text-align:center" onclick="document.location='{{ route('database.show', $droid->id) }}'">
                                            <img src="{{ route('image.displayDroidImage', [$droid->id, 'photo_front', '240']) }}" alt="{{ $droid->name }}" class="mb-1 rounded img-fluid">
                                        </div>
                                        <div class="droid-card-table" style="z-index:2">
                                            <div class="droid-card-row">
                                                <div class="droid-card-center noclick" onclick="document.location='{{ route('database.show', $droid->id) }}'">
                                                    <h2 style="margin-bottom:0px">{{ $droid->name }}</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
