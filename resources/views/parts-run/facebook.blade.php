    <!-- Facebook metadata for sharing events -->
    <meta property="og:url"           content="{{ URL::current() }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{ $data->partsRunAd->title }}" />
    <meta property="og:description"   content="{{ $data->partsRunAd->description }}" />
    <meta property="fb:app_id"        content="{{ config('fb.fb_app_id', 'Laravel') }}" />
    <!-- End of metadata -->
