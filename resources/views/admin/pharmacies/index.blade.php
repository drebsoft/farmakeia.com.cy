 @if($pharmacies !== null)
    @foreach($pharmacies as $pharmacy)
        <label>Name: </label>{{ $pharmacy->name }}
        <ul>
            <li>Region: {{ $pharmacy->region }}</li>
            <li>Area: {{ $pharmacy->area }}</li>
            <li>Address: {{ $pharmacy->address }}</li>
            <li>Additional Address: {{ $pharmacy->additional_address }}</li>
            <li>Phone number: {{ $pharmacy->phone }}</li>
            <li>AM: {{ $pharmacy->am }}</li>
            <li>Owner: {{ $pharmacy->owner->name ?? 'Not assigned'}}</li>
        </ul>
    @endforeach
@else
   No pharmacies available at the moment
@endif
