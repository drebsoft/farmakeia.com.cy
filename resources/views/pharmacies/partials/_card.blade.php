<div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 py-2">
    <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-no-wrap">
        <div class="ml-4 mt-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-12 w-12 rounded-full"
                         src="https://ui-avatars.com/api/?name={{ urlencode($pharmacy->name) }}&color=7F9CF5&background=EBF4FF"
                         alt="{{ $pharmacy->name }}"
                         title="{{ $pharmacy->name }}"
                         loading="lazy"
                    >
                </div>
                <div class="ml-4">
                    <a href="{{ $pharmacy->seo_url }}">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">
                            Φαρμακείο {{ $pharmacy->name }}
                            @if($pharmacy->next_availability === now()->format('Y-m-d'))
                                <span
                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium leading-5 bg-green-100 text-green-800"
                                >
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                         viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"></circle>
                                    </svg>
                                    Εφημερεύει
                                </span>
                            @endif
                            @if($pharmacy->does_rapid_tests)
                                <span
                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium leading-5 bg-pink-100 text-pink-800"
                                >
                                    Διενεργεί Rapid tests
                                </span>
                            @endif
                        </h2>
                    </a>
                    <p class="text-sm leading-5 text-gray-500">
                        {{ $pharmacy->area }} {{ $pharmacy->address }}{{ $pharmacy->additional_address ? ' - ' . $pharmacy->additional_address : '' }}
                    </p>
                </div>
            </div>
        </div>
        <div class="ml-4 mt-4 flex-shrink-0 flex">
            @if($pharmacy->phone)
                <span class="inline-flex rounded-md shadow-sm">
                    <a href="tel:{{ $pharmacy->phone }}"
                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-50 active:text-gray-800"
                    >
                      <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                           viewBox="0 0 20 20"
                           fill="currentColor">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"
                        />
                      </svg>
                      <span>
                        Τηλέφωνο
                      </span>
                    </a>
                  </span>
            @endif

            @if($pharmacy->lat && $pharmacy->lng)
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pharmacy->lat . ',' . $pharmacy->lng }}"
                       target="_blank"
                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-50 active:text-gray-800"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg"
                        ><path
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                            ></path>
                        </svg>
                        <span>Οδηγίες</span>
                    </a>
                  </span>
            @endif
        </div>
    </div>
</div>
