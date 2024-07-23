@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex ">
                <div class="text-left col-3">
                    <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('asset.index') }}">{{ __('Back') }}</a>
                </div>
                <div class="text-center col-6">
                    <h2 class="justify-content-center">{{ __('Create Asset') }}</h2>
                </div>
                <div class="text-right col-3"></div>
            </div>
        </div>
        <div class="card-body">

           
            {{ html()->modelForm(new \App\Models\Asset(), 'POST')->route('asset.store')->open() }}

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    {{  html()->label(__('Name'), 'title') }}
                </div>
                <div class="col-sm-10">
                    {{ html()->text('title')->required() }}
                </div>
            </div>


            <div class="form-group row d-flex justify-content-center align-items-top">
                <div class="col-sm-2">
                    {{  html()->label(__('Description'), 'description') }}
                </div>

                <div class="col-sm-10">
                    {{ html()->textarea('description') }}
                </div>
            </div>

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    {{  html()->label(__('Type'), 'type') }}
                </div>
                <div class="col-sm-10">
                    {{ html()->select('type')
                            ->children(\App\Enums\AssetTypes::cases(), function ($enum) {
                                    return html()->option($enum->name, $enum->value);
                             })
                    }}
                </div>
            </div>

            <div class="form-group row d-flex justify-content-center align-items-center">
                <div class="col-sm-2">
                    {{  html()->label(__('Condition'), 'current_state') }}
                </div>
                <div class="col-sm-10">
                    {{ html()->select('current_state')
                            ->children(\App\Enums\AssetConditions::cases(), function ($enum) {
                                    return html()->option($enum->name, $enum->value);
                                })
                    }}
                </div>
            </div>

            <div class="text-center form-group">
                {{  html()->submit(__('Submit'))->class('btn btn-primary') }}
            </div>

            {{ html()->closeModelForm() }}

        <br />

        </div>
    </div>
    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'autolink lists table link hr autoresize code image media',
            toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | table | link image media | hr code ',
            toolbar_mode: 'floating',
            image_caption: true,
            content_style: 'img {max-width: 100%; height: auto;}'
        });
    </script>
@endsection
