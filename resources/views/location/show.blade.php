@extends('layouts.app')

@section('content')

<div class="build-section text-center page-heading-text d-flex flex-column db-mt-2" id="app">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12">
                <h4>{{ $location->name }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 text-left">
                <div class="build-section db-my-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4>Address</h4>
                                {{ $location->street }}<br>
                                {{ $location->town }}<br>
                                {{ $location->county }}<br>
                                {{ $location->country }}<br>
                                {{ $location->postcode }}<br>
                                <br>

                                @can('Edit Events')
                                    @include('partials.show_contacts', ['contacts' => $location->contacts, 'model_type' => 'App\Location', 'model_id' => $location->id])
                                @endcan
                            </div>
                            <div class="col-xl-6">
                                @if($location->name == "Online" || $location->name == "No Location")
                                    <!-- No map to display -->
                                @else
                                    <div class="map-responsive">
                                        <iframe
                                            width="200"
                                            height="200"
                                            frameborder="0"
                                            style="border:1"
                                            src="https://www.google.com/maps/embed/v1/place?key={{ config('gmap.google_api_key') }}&q={{ urlencode($location->name) }},{{ urlencode($location->postcode) }}"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                @endif
                            </div>
                            <div class="rating col-12">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $location->averageRating(\App\User::class))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                ( {{ $location->raters(\App\User::class)->get()->count() }} ratings )
                                <form method="POST" action="{{ route('location.rating', $location) }}">
                                    @csrf
                                    <select id="locationRating" name="locationRating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if(Auth::user()->hasRated($location))
                                                <option name="ratings[]" value="{{ $i }}">{{$i}}</option>
                                            @else
                                                <option name="ratings[]" value="{{ $i }}">{{$i}}</option>
                                            @endif
                                        @endfor
                                    </select>
                                    <button type="submit">Rate Location</button>
                                </form>
                                @can('Edit Events')
                                    <a class="btn btn-info" style="width:auto;" href="{{ route('admin.locations.edit',$location->id) }}">Edit</a>
                                    <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#addContactModal">Add Contact</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 text-left">
                <div class="build-section db-my-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12">
                                <h4>Events</h4>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <h2>Previous</h2>
                            @if( count($events) === 0 )
                               No previous events listed
                           @else
                            <table class="table table-striped table-sm table-hover table-dark text-center">
                              <tr><th>Date</th><th>Name</th></tr>
                              @foreach($events as $event)
                              <tr>
                               <td>{{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
                               <td><a href="{{ route('event.show', $event->id) }}">{{ $event->name }}</a></td>
                              </tr>
                              @endforeach
                            </table>
                            @endif
                            <hr>
                            <h2>Upcoming</h2>
                            @if( count($upcoming) === 0 )
                                No upcoming events listed
                            @else
                             <table class="table table-striped table-sm table-hover table-dark text-center">
                               <tr><th>Date</th><th>Name</th></tr>
                               @foreach($upcoming as $event)
                               <tr>
                                <td>{{ Carbon\Carbon::parse($event->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
                                <td><a href="{{ route('event.show', $event->id) }}">{{ $event->name }}</a></td>
                               </tr>
                               @endforeach
                             </table>
                             @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.comments', ['comments' => $location->comments, 'permission' => 'Edit Events', 'model_type' => 'App\Location', 'model_id' => $location->id])
    </div>
</div>

    @can('Edit Events')
        @include('partials.add_contact', ['model_id' => $location->id, 'model_type' => 'App\Location'])
    @endcan
@endsection
