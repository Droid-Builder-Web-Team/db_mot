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
                 <select class="js-example-basic-single" name=club_id>
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
          <div class="col-md-1 mb-3">
            {{Form::hidden('active','off')}}
            <label>Active</label>
            <input type="checkbox" name="active" {{ $droid->active == 'on' ? 'checked' : '' }} class="form-control">
          </div>
          @if ($droid->club->hasOption('topps'))
          <div class="col-md-1 mb-3">
            <label>Topps ID</label>
            <input type="text" name="topps_id" class="form-control" value="{{ $droid->topps_id }}">
          </div>
          @endif
          @if ($droid->club->hasOption('tier_two'))
          {{Form::hidden('tier_two','No')}}
          <div class="col-md-1 mb-3">
            <label>Tier 2?</label>
            <input type="checkbox" name="tier_two" {{ $droid->tier_two == 'Yes' ? 'checked="Yes"' : 'value=Yes' }} class="form-control">
          </div>
          @endif
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Created On: </label>
          {{ $droid->date_added }}
        </div>
        <div class="col-md-4 mb-3">
          <label>Updated On: </label>
          {{ $droid->last_updated }}
        </div>
      </div>
         <div class="row">
           <div class="col-xs-6 col-sm-6 col-md-6">
             Builders Notes
             <div class="form-group">
               <textarea type="text" class="form-control" name="notes"></textarea>
             </div>
           </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              Back Story
              <div class="form-group">
                <textarea type="text" class="form-control" name="back_story"></textarea>
              </div>
           </div>
         </div>
         <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                   <button type="submit" class="btn btn-primary">Submit</button>
           </div>
         </div>


    </form>
    <script>
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
@endsection
