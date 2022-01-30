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
    <form action="{{ route('admin.contacts.unlink') }}" method="POST">
        @csrf
            <input type="hidden" name="contact_id" value="{{ $contact->id }}">
            <input type="hidden" name="model_id" value="{{ $model_id }}">
            <input type="hidden" name="model_type" value="{{ $model_type }}">
            <input type="submit" class="btn btn-danger" value="x">
    </form>
    </li>
@endforeach
</ul>
