    <!-- Facebook metadata for sharing events -->
    <meta property="og:url"           content="{{ URL::current() }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{ $event->name }} - {{ $event->location->name }}, {{ $event->location->county }} - {{ $event->date }}" />
    <meta property="og:description"   content="{{ $event->description }}" />
    @if($event->hasImage())
    <meta property="og:image"         content="{{ route('events.showimage', $event->id) }}" />
    @else
    <meta property="og:image"         content="https://{{ request()->getHttpHost() }}/images/new_event.jpg" />
    @endif
    <meta property="fb:app_id"        content="{{ config('fb.fb_app_id', 'Laravel') }}" />
    <!-- End of metadata -->
