    <!-- Facebook metadata for sharing events -->
    <meta property="og:url"           content="{{ URL::current() }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{ $partsRunData[0]->partsRunAd->title }}" />
    <meta property="og:description"   content="{{ $partsRunData[0]->partsRunAd->description }}" />
    <meta property="fb:app_id"        content="{{ config('fb.fb_app_id', 'Laravel') }}" />
    <!-- End of metadata -->
