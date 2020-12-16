<x-slot name="headerSlot">
    <title>Φαρμακεία στην {{ __($region) }}</title>
    <meta name="description"
          content="Ψάχνεις τα εφημερέυοντα φαρμακεία στην {{ __($region) }}; Δες τα όλα μέσα από το farmakeia.com.cy με ένα κλικ!">
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        @if($region)
            <div
                class="pb-5 border-b border-gray-200 space-y-3 sm:flex sm:items-center sm:justify-between sm:space-x-4 sm:space-y-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    Φαρμακεία στην {{ __($region) }}
                </h1>
                <div>
                    <label for="search_pharmacy" class="sr-only">Search</label>
                    <div class="flex rounded-md shadow-sm">
                        <div class="relative flex-grow focus-within:z-10">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input id="search_pharmacy"
                                   class="form-input block w-full rounded-none rounded-l-md pl-10 transition ease-in-out duration-150 sm:hidden"
                                   placeholder="Search"
                                   wire:model="search"
                            >
                            <input id="search_pharmacy"
                                   class="hidden form-input w-full rounded-none rounded-l-md pl-10 transition ease-in-out duration-150 sm:block sm:text-sm sm:leading-5"
                                   placeholder="Αναζήτηση φαρμακείου"
                                   wire:model="search"
                            >
                        </div>


                        <div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false"
                             class="relative inline-block text-left">
                            <div class="h-full">
                                  <span class="rounded-md shadow-sm h-full">

                                    <button
                                        @click="open = !open" aria-haspopup="true" x-bind:aria-expanded="open"
                                        aria-expanded="true"
                                        class="h-full -ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-r-md text-gray-700 bg-gray-50 hover:text-gray-500 hover:bg-white focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path
                                                d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                        </svg>
{{--                                        <span class="ml-2">Sort</span>--}}
{{--                                        <svg class="ml-2.5 -mr-1.5 h-5 w-5 text-gray-400"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg"--}}
{{--                                             viewBox="0 0 20 20" fill="currentColor">--}}
{{--                                            <path fill-rule="evenodd"--}}
{{--                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"--}}
{{--                                                  clip-rule="evenodd"/>--}}
{{--                                        </svg>--}}
                                    </button>

                                  </span>
                            </div>

                            <div x-show="open" x-description="Dropdown panel, show/hide based on dropdown state."
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg z-50">
                                <div class="rounded-md bg-white shadow-xs">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                         aria-labelledby="options-menu">
                                        <a href="#"
                                           class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                           role="menuitem">Account settings</a>
                                        <a href="#"
                                           class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                           role="menuitem">Support</a>
                                        <a href="#"
                                           class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                           role="menuitem">License</a>
                                        <form method="POST" action="#">
                                            <button type="submit"
                                                    class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                                    role="menuitem">
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <ul>
                @if(isset($pharmacies) && count($pharmacies) > 0)
                    @foreach($pharmacies as $pharmacy)
                        @include('pages.pharmacies.partials._card', $pharmacy)
                    @endforeach
                @else
                    @include('pages.pharmacies.partials._empty')
                @endif
            </ul>
        </div>
    </div>
</div>
