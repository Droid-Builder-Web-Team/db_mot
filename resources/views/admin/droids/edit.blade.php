@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Droid</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('droid.show', $droid->id) }}">Back</a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.droids.update',$droid->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
           <div class="col-xs-9 col-sm-9 col-md-9">
               <div class="form-group">
                   <strong>Droid Name:</strong>
                   <input type="text" name="name" class="form-control" value="{{ $droid->name }}">
               </div>
           </div>
           <div class="col-xs-3 col-sm-3 col-md-3">
               <div class="form-group">
                 <strong>Club</strong><br>
                 <select name=club_id>
                   @foreach($clubs as $club)
                     <option value="{{ $club->id }}"
                     @if($droid->club_id == $club->id)
                        selected
                     @endif
                     >{{ $club->name }}</option>
                   @endforeach
                 </select>
               </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-9 col-sm-9 col-md-9">
               <div class="form-group">
                   <strong>Style:</strong> (eg, ANH, custom, etc.)
                   <input type="text" name="style" class="form-control" value="{{ $droid->style }}">
               </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-9 col-sm-9 col-md-9">
               <div class="form-group">
                   <strong>Control System:</strong> (eg, Padawan, shadow, custom.)
                   <input type="text" name="transmitter_type" class="form-control" value="{{ $droid->transmitter_type }}">
               </div>
           </div>
           <div class="col-xs-3 col-sm-3 col-md-3">
               <div class="form-group">
                   <strong>RC?</strong>
                   <input type="text" name="radio_controlled" class="form-control" value="{{ $droid->radio_controller }}">
               </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12">
               <div class="form-group">
                   <strong>Sound System:</strong>
                   <input type="text" name="sound_system" class="form-control" value="{{ $droid->sound_system }}">
               </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12">
               <div class="form-group">
                   <strong>Build Material:</strong>
                   <input type="text" name="material" class="form-control" value="{{ $droid->material }}">
               </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-4 col-sm-4 col-md-4">
               <div class="form-group">
                   <strong>Battery Type:</strong> (eg, LiPo, LiFePo, SLA.)
                   <input type="text" name="battery" class="form-control" value="{{ $droid->battery }}">
               </div>
           </div>
           <div class="col-xs-4 col-sm-4 col-md-4">
               <div class="form-group">
                   <strong>Drive Type:</strong> (eg, Warp drives, scavenger.)
                   <input type="text" name="drive_type" class="form-control" value="{{ $droid->drive_type }}">
               </div>
           </div>
           <div class="col-xs-4 col-sm-4 col-md-4">
               <div class="form-group">
                   <strong>Voltage</strong>
                   <input type="text" name="drive_voltage" class="form-control" value="{{ $droid->drive_voltage }}">
               </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-4 col-sm-4 col-md-4">
               <div class="form-group">
                   <strong>Approx Value:</strong>
                   <input type="text" name="value" class="form-control" value="{{ $droid->value }}">
               </div>
           </div>
           <div class="col-xs-4 col-sm-4 col-md-4">
               <div class="form-group">
                   <strong>Approx Weight</strong> (in kg)
                   <input type="text" name="weight" class="form-control" value="{{ $droid->weight }}">
               </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                   <button type="submit" class="btn btn-primary">Submit</button>
           </div>
         </div>


    </form>
@endsection
