@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New MOT</h2>
        </div>
    </div>
</div>

<form action="{{ route('admin.mot.store') }}" method="POST">
    @csrf

    <input type=hidden name="droid_id" value="{{ $droid->id }}">
    <input type=hidden name="club_id" value="{{ $droid->club_id }}">
    <input type=hidden name="user" value="{{ Auth::user()->id }}">
    <div class="row justify-content-between">
      <div class="col-md-4 mb-1">
        <table>
          <tr><th>Date:</th><td><input type=date name=date></td></tr>
          <tr><th>Location:</th><td><input type=text name=location></td></tr>
          <tr><th>Officer:</th><td>{{ Auth::user()->forename }} {{Auth::user()->surname }}</td></tr>
          <tr><th>Type:</th><td><select name=mot_type><option value=Initial>Initial</option><option value=Renewal>Renewal</option><option value=Retest>Retest</option></select></td></tr>
          <tr><th>Overall:</th><td><select name=approved><option value=Yes>Yes</option><option value=No>No</option><option value=WIP>WIP</option><option value=Advisory>Yes (Advisory)</option></select></td></tr>
        </table>
      </div>
      <div class="col-md-8-mb-1">
        <textarea name=new_comment rows=10 cols=30></textarea>
      </div>
    </div>
      @foreach($sections as $section)
        <div class="row">
          <div class="col-md-12">
          <h4>{{$section->section_description }}</h2>
          </div>
        </div>
        @foreach(App\MOT::lines($section->id) as $line)
        <div class="row">
          <div class="col-md-3 offset-md-1" data-toggle="tooltip" data-placement="top" title="{{ $line->test_long_description }}">
            {{ $line->test_description}}
          </div>
          <div class="col-md-2 mb-1">
              <input type=radio name="{{ $line->test_name }}" value=Pass>Pass
  			      <input type=radio name="{{ $line->test_name }}" value=Fail checked>Fail
			        <input type=radio name="{{ $line->test_name }}" value=NA>NA
          </div>
        </div>
        @endforeach
      @endforeach
      <input type=submit value=Submit name=new_mot>
</form>
@endsection
