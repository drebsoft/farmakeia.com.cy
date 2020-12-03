<div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 py-2">
    <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-no-wrap">
        <div class="ml-4 mt-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-12 w-12 rounded-full"
                         src="https://ui-avatars.com/api/?name={{ urlencode($pharmacy->name) }}&color=7F9CF5&background=EBF4FF"
                         alt="">
                </div>
                <div class="ml-4">
                    <a href="{{ route('farmakeio', ['am' => $pharmacy->am, 'name' => \Str::slug($pharmacy->name)]) }}">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Φαρμακείο {{ $pharmacy->name }}
                        </h3>
                    </a>
                    <p class="text-sm leading-5 text-gray-500">
                        {{ $pharmacy->area }} ({{ $pharmacy->address }} - {{ $pharmacy->additional_address }})
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
                        Phone
                      </span>
                    </a>
                  </span>
            @endif

            @if($pharmacy->home_phone)
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <a href="tel:{{ $pharmacy->home_phone }}"
                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-50 active:text-gray-800"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg"
                        ><path
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            ></path>
                        </svg>
                        <span>Home phone</span>
                    </a>
                  </span>
            @endif
        </div>
    </div>
</div>
