@extends('layouts.app')

@section('content')

    <div class="row">
      <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="card">
          <div class="card-header">
            <strong>{{ $location->name }}</strong>

          </div>
          <div class="card-body">
            <div class="row no-gutters">
              <div class="col-md-8">
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
              <div class="col-md-4">
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
            </div>
            <div class="rating">
              @for ($i = 0; $i < 5; $i++)
                @if ($i < $location->averageRating(\App\User::class))
                  <i class="fas fa-star"></i>
                @else
                  <i class="far fa-star"></i>
                @endif
              @endfor
              ( {{ $location->usersRated() }} ratings )
              <form method="POST" action="{{ route('location.rating', $location) }}">
                @csrf
                <select id="locationRating" name="locationRating">
                  @for ($i = 1; $i <= 5; $i++)
                      <option name="ratings[]" value="{{ $i }}">{{$i}}</option>
                  @endfor
                </select>
                <button type="submit">Rate Location</button>
              </form>
              @can('Edit Events')
              <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.locations.edit',$location->id) }}">Edit</a>
              <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#addContactModal">Add Contact</button>

            @endcan
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            Events
          </div>
          <div class="card-body">
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

    @include('partials.comments', ['comments' => $location->comments, 'permission' => 'Edit Events', 'model_type' => 'App\Location', 'model_id' => $location->id])


    @can('Edit Events')
        @include('partials.add_contact', ['model_id' => $location->id, 'model_type' => 'App\Location'])
    @endcan
@endsection
