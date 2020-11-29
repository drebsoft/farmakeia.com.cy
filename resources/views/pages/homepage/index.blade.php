<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <ul>
                    <li><a href="{{ route('farmakeia', ['region' => 'lefkosia']) }}">Λευκωσία</a></li>
                    <li><a href="{{ route('farmakeia', ['region' => 'lemesos']) }}">Λεμεσός</a></li>
                    <li><a href="{{ route('farmakeia', ['region' => 'larnaka']) }}">Λάρνακα</a></li>
                    <li><a href="{{ route('farmakeia', ['region' => 'pafos']) }}">Πάφος</a></li>
                    <li><a href="{{ route('farmakeia', ['region' => 'paralimni']) }}">Παραλίμνι</a></li>
                </ul>
            </div>
        </div>
    </div>
</x-guest-layout>
