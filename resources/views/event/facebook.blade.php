@php
    $location = array_filter([$event->location->name ?? null, $event->location->county ?? null]);
    $titleParts = array_filter([$event->name ?? null, !empty($location) ? implode(', ', $location) : null, $event->date ?? null]);
    $title = !empty($titleParts) ? implode(' - ', $titleParts) : config('app.name', 'Droidbuilders Portal');
    $description = $event->description ?? config('app.name', 'Droidbuilders Portal');
@endphp
    <!-- Facebook metadata for sharing events -->
    <meta property="og:url"           content="{{ URL::current() }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{ $title }}" />
    <meta property="og:description"   content="{{ $description }}" />
    @if(!empty($event) && $event->hasImage())
    <meta property="og:image"         content="{{ route('events.showimage', $event->id) }}" />
    @else
    <meta property="og:image"         content="https://{{ request()->getHttpHost() }}/images/new_event.jpg" />
    @endif
    <meta property="fb:app_id"        content="{{ config('fb.fb_app_id', 'Laravel') }}" />
    <!-- End of metadata -->

