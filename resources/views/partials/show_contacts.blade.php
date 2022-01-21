<h4>Contacts</h4>
<ul>
@foreach($contacts as $contact)
    @if($contact->email != "")
        <li><a href="mailto:{{ $contact->email }}">{{ $contact->name }}</a>
    @else
        <li>{{ $contact->name }}
    @endif
    @if($contact->phone != "")
     - Phone: {{ $contact->phone }}
    @endif
    </li>
@endforeach
</ul>
