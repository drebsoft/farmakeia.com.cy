<x-guest-layout>
    <div class="py-10">
        <section>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap">
                            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                                Φαρμακείο {{ $pharmacy->name }}
                            </h1>
                        </div>
                        <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap">
                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-900 sm:mr-6">
                                {{ $pharmacy->address }} ({{ $pharmacy->additional_address }})
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        @if($pharmacy->phone)
                            <span class="shadow-sm rounded-md">
                            <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out"
                               href="tel:{{ $pharmacy->phone }}"
                            >
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"
                                    />
                                </svg>
                                <span>Τηλέφωνο</span>
                            </a>
                        </span>
                        @endif
                        @if($pharmacy->home_phone)
                            <span class="ml-3 shadow-sm rounded-md">
                            <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out"
                               href="tel:{{ $pharmacy->home_phone }}"
                            >
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg"
                                ><path
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                    ></path>
                                </svg>
                                <span>Τηλ. Οικίας</span>
                            </a>
                        </span>
                        @endif
                    </div>
                </div>

            </div>

        </section>

        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if($nextAvailabilities->first()->date->isBefore(now()->addDays(4)))
                    <div
                        class="my-4 w-full inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium leading-5 bg-green-100 text-green-800">
                        @if($nextAvailabilities->first()->date->isToday())
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                 viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"></circle>
                            </svg>
                            <span>Εφημερεύει Σήμερα!</span>
                        @else
                            Επόμενη εφημερία: {{ $nextAvailabilities->first()->date->dayName . ', ' . $nextAvailabilities->first()->date->format('d/m/Y') }}
                        @endif
                    </div>
                @endif

                <div class="flex px-4 py-8 sm:px-0">
                    <div class="w-1/5">
                        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Επόμενες εφημερίες
                            </h3>
                        </div>

                        <ul aria-disabled="true" class="overflow-y-scroll" style="max-height: 330px">
                            @foreach($nextAvailabilities as $availability)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm leading-5 font-medium text-gray-600 truncate">
                                                {{ $availability->date->dayName . ', ' . $availability->date->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>


                    </div>
                    <div class="w-4/5">
                        @if(!empty(config('googlemaps.api_key')) && !empty($pharmacy->map_address))
                            <iframe
                                width="650" height="400"
                                style="width:100%;border:0"
                                src="https://www.google.com/maps/embed/v1/place?key={{ config('googlemaps.api_key') }}&q={{ $pharmacy->map_address }}&region=cy"
                                allowfullscreen>
                            </iframe>
                        @endif
                    </div>
                </div>

                <div class="p-2 rounded-lg bg-gray-600 shadow-lg sm:p-3">
                    <div class="flex items-center justify-between flex-wrap">
                        <div class="w-0 flex-1 flex items-center">
                            <p class="ml-3 font-medium text-white truncate">
                                <span class="">
                                    Δεν σε βολεύει; Μπορείς να δεις όλα τα φαρμακεία της επαρχίας εδώ
                                </span>
                            </p>
                        </div>
                        <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
                            <div class="rounded-md shadow-sm">
                                <a href="{{ route('farmakeia', ['region' => $pharmacy->getSeoRegionAlias()]) }}"
                                   class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-gray-800 bg-white hover:text-gray-900 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">
                                    Φαρμακεία {{ __($pharmacy->region) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    @php
        echo \Spatie\SchemaOrg\Schema::pharmacy()
            ->name($pharmacy->name)
            ->address(
                \Spatie\SchemaOrg\Schema::postalAddress()
                    ->streetAddress($pharmacy->address)
                    ->addressRegion($pharmacy->region)
                    ->addressCountry('Cyprus')
            )
            ->telephone($pharmacy->phone)
            ->latitude($pharmacy->lat)
            ->longitude($pharmacy->lng)
            ->contactPoint(\Spatie\SchemaOrg\Schema::contactPoint()->areaServed('Cyprus'))
            ->toScript();
    @endphp
</x-guest-layout>
