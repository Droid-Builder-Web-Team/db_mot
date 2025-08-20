@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-2 text-left">
                    </div>
                    <div class="col-sm-8 text-center">
                        <h4 class="text-center title">{{ __('Nominate Member') }}</h4>
                    </div>
                    <div class="col-sm-2 text-right">
                        <a class="btn btn-primary" href="{{ route('nominations.index') }}">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ html()->modelForm(new \App\Models\Nomination(), 'POST')->route('nominations.store')->open() }}

                <div class="form-group row d-flex justify-content-center align-items-center">
                    <div class="col-sm-2">
                        {{  html()->label(__('Nominee'), 'nominee_id') }}
                    </div>
                    <div class="col-sm-10">
                        {{ html()->select('nominee_id', $users)->id('nominee-select')->class('form-control') }}
                    </div>
                </div>
    
    
                <div class="form-group row d-flex justify-content-center align-items-top">
                    <div class="col-sm-2">
                        {{  html()->label(__('Reason'), 'reason') }}
                    </div>
    
                    <div class="col-sm-10">
                        {{ html()->textarea('reason') }}
                    </div>
                </div>
    
    
                <div class="text-center form-group">
                    {{  html()->submit(__('Submit'))->class('btn btn-primary') }}
                </div>
    
                {{ html()->closeModelForm() }}
    
            <br />
    


            </div>
        </div>
    </div>
</div>

<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script>
    tinymce.init({
        selector: '#reason',
        plugins: 'autolink lists table link hr autoresize code image media',
        toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | table | link image media | hr code ',
        toolbar_mode: 'floating',
        image_caption: true,
        content_style: 'img {max-width: 800px; width: 100%; height: auto;}',
        image_class_list: [
            {title: 'Responsive', value: 'img-responsive'}
        ]
    });
</script>
<script>
    $(document).ready(function() {
        $('#nominee-select').select2();
    });
</script>
@endsection