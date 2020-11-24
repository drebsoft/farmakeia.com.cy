<label>Name: </label>{{ $pharmacy->name }}
<ul>
    <li>Town: {{ $pharmacy->town }}</li>
    <li>Municipality: {{ $pharmacy->municipality }}</li>
    <li>Address: {{ $pharmacy->address }}</li>
    <li>Additional Address: {{ $pharmacy->add_address }}</li>
    <li>Phone number: {{ $pharmacy->phone }}</li>
    <li>AM: {{ $pharmacy->am }}</li>
    <li>Owner: {{ $pharmacy->owner->name ?? 'Not assigned' }}</li>
</ul>
