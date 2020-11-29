<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <ul>
                    @if(isset($pharmacy) && $pharmacy instanceof \App\Models\Pharmacy)
                        <li>Name: {{ $pharmacy->name }}</li>
                        <li>Region: {{ $pharmacy->region }}</li>
                        <li>Area: {{ $pharmacy->area }}</li>
                        <li>Address: {{ $pharmacy->address }}</li>
                        <li>Additional Address: {{ $pharmacy->additional_address }}</li>
                        <li>Phone number: {{ $pharmacy->phone }}</li>
                        <li>AM: {{ $pharmacy->am }}</li>
                    @else
                        <li>Το φαρμακείο που ψάχνετε δεν βρέθηκε</li>
                        <li><a href="{{ route('homepage') }}">Επιστροφή στην Αρχική</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-guest-layout>
