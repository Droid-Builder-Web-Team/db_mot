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
            <p>Why MOT? Droids can be rather heavy and dangerous if built wrong. The MOT process is a way to make sure your droid is safe for taking out in public and
              is unlikely to cause any injuries or issues. Not just to the people you interact with, but also the environment itself. A 60kg+ runaway droid can do a lot of
              damage to stalls, cars, etc. After your droid has passed its MOT, you can then join in the club PLI to make sure you are insured incase of any incidents. The MOT process is
              a requirement for the PLI. <p>
            <p>Below are the checks that the MOT officers will perform as part of the MOT process. This is just a (fairly detailed) guideline, the overall aim of
            the officer is to ascertain that you and your droid are safe for both you and the public in general. </p>
            <p>That being said, the club want you to pass. This is a hobby for fun, and we don't want to stop that. The MOT officer will be able to help you should
              there be any issues, and if they can't the club in general are there to help. The more droids out and about across the country raising money
              for charity, the better.</p>
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
