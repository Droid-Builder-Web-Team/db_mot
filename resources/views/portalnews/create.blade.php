@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex ">
                <div class="text-left col-3">
                    <a class="btn btn-mot-invert" style="width:auto; color:white;" href="{{ route('portalnews.index') }}">Back</a>
                </div>
                <div class="text-center col-6">
                    <h2 class="justify-content-center">Create New Article</h2>
                </div>
                <div class="text-right col-3"></div>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('portalnews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="state" value=1>

                <div class="form-group">
                    <label for="title"><strong>Title</strong></label>
                    <input type="text" name="title" class="form-control" placeholder="Title">
                </div>

                <div class="form-group">
                    <label for="message"><strong>Message</strong></label>
                    <textarea class="form-control" style="height:250px" id="message" name="message" placeholder="Message"></textarea>
                </div>

                <div class="form-group">
                    To add images, first have them saved somewhere like Google Photos or another image hosting site. From there you can get a link to the image. (For Google, hit the share icon and click 'Create link')
                    Now click on Insert->Image from the menu in text entry above, and post the link into the Source field. You can also set hover over text and a size limit to the picture. 
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
            selector: '#message',
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
