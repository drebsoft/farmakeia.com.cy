<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if(isset($pharmacy) && $pharmacy instanceof \App\Models\Pharmacy)
                    <ul>
                        <li>Name: {{ $pharmacy->name }}</li>
                        <li>Region: {{ $pharmacy->region }}</li>
                        <li>Area: {{ $pharmacy->area }}</li>
                        <li>Address: {{ $pharmacy->address }}</li>
                        <li>Additional Address: {{ $pharmacy->additional_address }}</li>
                        <li>Phone number: {{ $pharmacy->phone }}</li>
                        <li>AM: {{ $pharmacy->am }}</li>
                    </ul>
                    @if(!empty($maps_api_key) && !empty($pharmacy->map_address))
                        <iframe
                            width="650" height="400"
                            style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?key={{ $maps_api_key }}
                                &q={{ $pharmacy->map_address }}&region=cy" allowfullscreen>
                        </iframe>
                    @endif
                @else
                    <ul>
                        <li>Το φαρμακείο που ψάχνετε δεν βρέθηκε</li>
                        <li><a href="{{ route('homepage') }}">Επιστροφή στην Αρχική</a></li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
