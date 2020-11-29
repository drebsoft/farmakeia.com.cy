<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <ul>
                    @if(isset($pharmacies) && count($pharmacies) > 0)
                        @foreach($pharmacies as $pharmacy)
                            <li>
                                <a href="{{ route('farmakeio', ['am' => $pharmacy->am, 'name' => \Str::slug($pharmacy->name)]) }}">Φαρμακείο {{ $pharmacy->name }}</a>
                            </li>
                        @endforeach
                    @else
                        <li>Δεν υπάρχουν διαθέσιμα φαρμακεία για αυτή την περιοχή</li>
                        <li><a href="{{ route('homepage') }}">Επιστροφή στην Αρχική</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-guest-layout>
