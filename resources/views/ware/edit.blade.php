@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="mb-4 pull-right">
                        <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('ware.index') }}">Back</a>
                    </div>
                    <div class="mb-4 pull-left">
                        <h2>Edit Item</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('ware.update', $ware->id) }}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="state" value=1>

                <div class="form-group">
                    <label for="title"><strong>Title</strong></label>
                    <input type="text" name="title" class="form-control" placeholder="Title" value="{{$ware->title}}">
                </div>

                <div class="form-group">
                    <label for="type"><strong>Type of Post</strong></label>
                    <select id="type" name="type" class="custom-select">
                        <option {{ ($ware->type) == 'FS' ? 'selected' : '' }} value="FS">For Sale</option>
                        <option {{ ($ware->type) == 'WTB' ? 'selected' : '' }} value="WTB">Want To Buy</option>
                        <option {{ ($ware->type) == 'FREE' ? 'selected' : '' }} value="FREE">Free</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description"><strong>Description</strong></label>
                    <textarea class="form-control" style="height:250px" id="description" name="description" placeholder="Description">{{ $ware->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="showemail"><strong>Show Email</strong></label>
                    {{Form::hidden('showemail','0')}}
                    <input type="checkbox" {{ $ware->showemail ? 'checked=1 value=1' : 'value=1' }} name="showemail" class="form-control">

                    <label for="state"><strong>Active Sale</strong></label>
                    {{Form::hidden('state','0')}}
                    <input type="checkbox" {{ $ware->state ? 'checked=1 value=1' : 'value=1' }} name="state" class="form-control">
                </div>



                <div class="text-center form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
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
