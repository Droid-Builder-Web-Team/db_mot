@extends('layouts.app')

@section('content')


<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">MOT Info</h4>
      </div>
      <div class="card-body ">
          <div class="mb-4">
            This is a guide for things that an MOT officer will look at on your droid and with your driving. Use this to help prepare for your MOT.
          </div>
            <div class="accordion" id="accordionMOT">
          @foreach($sections as $section)

              <div class="card">
                <div class="card-header" id="heading{{ $section->id}}">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse{{ $section->id}}" aria-expanded="false" aria-controls="collapse{{ $section->id}}">
                    {{ $section->section_description }}
                  </button>
                </div>
                <div id="collapse{{ $section->id}}" class="collapse" aria-labelledby="heading{{ $section->id}}" data-parent="#accordionMOT">
                  <div class="card-body">
                    <div class="mb-4">{!! nl2br(e($section->section_long_description)) !!}</div>


                    <div class="accordion" id="accordionLines{{ $section->id}}">
                      @foreach($lines[$section->id] as $line)
                        <div class="card">
                          <div class="card-header" id=headingLine{{ $line->id}}">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseLine{{ $line->id}}" aria-expanded="false" aria-controls="collapseLine{{ $line->id}}">
                              {{ $line->test_description }}
                            </button>
                          </div>
                          <div id="collapseLine{{ $line->id}}" class="collapse" aria-labelledby="headingLine{{ $line->id}}" data-parent="#accordionLines{{ $section->id}}">
                            <div class="card-body">
                              {!! nl2br(e($line->test_long_description)) !!}
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>


                </div>
              </div>

          @endforeach
            </div>
      </div>
    </div>
  </div>
</div>

@endsection
