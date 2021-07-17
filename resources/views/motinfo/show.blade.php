@extends('layouts.app')

@section('content')


<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="card">
      <div class="card-header">
        <h4 class="title text-center">MOT Info</h4>
        {{-- @foreach($sections as $s)
        <a class="btn btn-primary" href="{{ route('motinfo.export', $s->id) }}">Export MOT Info</a>
        @endforeach --}}
      </div>
      <div class="card-body mb-2">
          <div>
            <p>Why MOT? Droids can be rather heavy and dangerous if built wrong. The MOT process is a way to make sure your droid is safe for taking out in public and
              is unlikely to cause any injuries or issues. Not just to the people you interact with, but also the environment itself. A 60kg+ runaway droid can do a lot of
              damage to stalls, cars, etc. After your droid has passed its MOT, you can then join in the club PLI to make sure you are insured incase of any incidents. The MOT process is
              a requirement for the PLI. <p>
            <div>
              <h5>MOT Officers:</h5>
              <ul>
                @foreach($mot_officers as $officer)
                  <li>{{ $officer->forename}} {{ $officer->surname}} - {{ $officer->county }}</li>
                @endforeach
              </ul>
            </div>
            <p>Below are the checks that the MOT officers will perform as part of the MOT process. This is just a (fairly detailed) guideline, the overall aim of
            the officer is to ascertain that you and your droid are safe for both you and the public in general. </p>
            <p>That being said, the club want you to pass. This is a hobby for fun, and we don't want to stop that. The MOT officer will be able to help you should
              there be any issues, and if they can't the club in general are there to help. The more droids out and about across the country raising money
              for charity, the better. It will also benefit you from club experience and the officers know where the common failure points are, hopefully saving you the embarassment of
            winning the Walk Of Shame achievement.</p>
            <p>Ideally, an MOT will be done at one of the large events where we have plenty of room to move. However, if you need one before doing a small local event for example, then
              feel free to get in touch with one of the MOT officers listed above and see if we can arrange a test for you at a suitable location. Village halls, or even a quiet street should be
              fine.  </p>
          </div>
            <div class="accordion" id="accordionMOT">
          @foreach($sections as $section)

              <div class="card-mot">
                <div class="card-header-mot" id="heading{{ $section->id}}">
                  <h5 class="mb-0 d-inline">
                  <button class="btn btn-motinfo collapsed" type="button" data-toggle="collapse" data-target="#collapse{{ $section->id}}" aria-expanded="false" aria-controls="collapse{{ $section->id}}">
                    {{ $section->section_long_description }}
                  </button>
                </h5>
                </div>
                <div id="collapse{{ $section->id}}" class="collapse" aria-labelledby="heading{{ $section->id}}" data-parent="#accordionMOT">
                  <div class="card-body">
                    <div class="mb-2">{!! nl2br(e($section->section_long_description)) !!}</div>
                    <div class="accordion" id="accordionLines{{ $section->id}}">
                      @foreach($lines[$section->id] as $line)
                        <div class="card-mot">
                          <div class="card-header-line" id=headingLine{{ $line->id}}">
                            <button class="btn btn-motinfosub collapsed" type="button" data-toggle="collapse" data-target="#collapseLine{{ $line->id}}" aria-expanded="false" aria-controls="collapseLine{{ $line->id}}">
                              {{ $line->test_description }}
                            </button>
                          </div>
                          <div id="collapseLine{{ $line->id}}" class="collapse" aria-labelledby="headingLine{{ $line->id}}" data-parent="#accordionLines{{ $section->id}}">
                            <div class="card-body">
                              <p class="sub">{!! nl2br(e($line->test_long_description)) !!}</p>
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
