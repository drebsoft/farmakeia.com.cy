<x-slot name="headerSlot">
    <title>Φαρμακεία {{ __($region . '_with_article') }}</title>
    <meta name="description"
          content="Ψάχνεις τα εφημερέυοντα φαρμακεία {{ __($region . '_with_article') }}; Δες τα όλα μέσα από το farmakeia.com.cy με ένα κλικ!">
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        @if($region)
            <div
                class="pb-5 border-b border-gray-200 space-y-3 sm:flex sm:items-center sm:justify-between sm:space-x-4 sm:space-y-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    Φαρμακεία {{ __($region . '_with_article') }}
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
                                   class="form-input block w-full pl-10 transition ease-in-out duration-150 sm:hidden"
                                   placeholder="Αναζήτηση φαρμακείου"
                                   wire:model="search"
                            >
                            <input id="search_pharmacy_mobile"
                                   class="hidden form-input w-full pl-10 transition ease-in-out duration-150 sm:block sm:text-sm sm:leading-5"
                                   placeholder="Αναζήτηση φαρμακείου"
                                   wire:model="search"
                            >
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <ul>
                @if(isset($pharmacies) && count($pharmacies) > 0)
                    @foreach($pharmacies as $pharmacy)
                        @include('pharmacies.partials._card', $pharmacy)
                    @endforeach
                    {{ $pharmacies->links('vendor.pagination.tailwind') }}
                @else
                    @include('pharmacies.partials._empty')
                @endif
            </ul>
        </div>
        @if(!empty($regionSeo))
            <div class="max-w-screen-xl mx-auto py-8 px-4 sm:py-12 sm:px-6 lg:px-8 lg:pb-5">
                <div class="text-center">
                    <p class="md:mt-5 mx-auto text-sm leading-7 text-gray-400 italic">
                        {{ $regionSeo }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
