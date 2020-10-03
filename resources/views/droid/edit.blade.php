@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="float-right mb-4">
          <a class="btn btn-primary" href="{{ route('droid.show', $droid->id) }}">Back</a>
        </div>
        <h4 class="title text-center">Edit Droid</h4>
      </div>

      <form action="{{ route('droid.update',$droid->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">

        <div class="form-row">
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
         <div class="form-row">
           <div class="col-xs-9 col-sm-9 col-md-9">
               <div class="form-group">
                   <strong>Style:</strong> (eg, ANH, custom, etc.)
                   <input type="text" name="style" class="form-control" value="{{ $droid->style }}">
               </div>
           </div>
         </div>
         <div class="form-row">
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
         <div class="form-row">
           <div class="col-xs-12 col-sm-12 col-md-12">
               <div class="form-group">
                   <strong>Sound System:</strong>
                   <input type="text" name="sound_system" class="form-control" value="{{ $droid->sound_system }}">
               </div>
           </div>
         </div>
         <div class="form-row">
           <div class="col-xs-12 col-sm-12 col-md-12">
               <div class="form-group">
                   <strong>Build Material:</strong>
                   <input type="text" name="material" class="form-control" value="{{ $droid->material }}">
               </div>
           </div>
         </div>
         <div class="form-row">
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
         <div class="form-row">
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
         <div class="form-row">
           <div class="col-xs-6 col-sm-6 col-md-6">
             Builders Notes
             <div class="form-group">
               <textarea type="text" class="form-control" name="notes">{!! nl2br(e($droid->notes)) !!}</textarea>
             </div>
           </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              Back Story
              <div class="form-group">
                <textarea type="text" class="form-control" name="back_story">{!! nl2br(e($droid->back_story)) !!}</textarea>
              </div>
           </div>
         </div>
         <div class="form-row">
           <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                   <button type="submit" class="btn btn-primary">Submit</button>
           </div>
         </div>
</div>

    </form>
  </div>
</div>
</div>
@endsection
