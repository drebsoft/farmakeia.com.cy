<div x-data="{ mobileMenuOpen: false }" class="z-10 relative bg-white">
    <div class="relative z-10 shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-5 sm:px-6 sm:py-4 lg:px-8 md:justify-start md:space-x-10">
            <div>
                <a href="{{ route('homepage') }}" class="flex">
                    <span class="sr-only">Farmakeia</span>
                    <img class="h-8 w-auto sm:h-10" src="{{ url('/logo.png') }}" alt="Farmakeia.com.cy logo" title="The logo of farmakeia.com.cy" loading="eager">
                </a>
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <button @click="mobileMenuOpen = true" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" x-description="Heroicon name: menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                <nav class="flex space-x-10">
                    <a href="{{ route('homepage') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Αρχική
                    </a>
                    <a href="{{ route('map') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Προβολή Χάρτη
                    </a>
                    <a href="{{ route('rapid-tests') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Χάρτης Rapid Test
                    </a>
                    <a href="{{ route('how-it-works') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Πώς Λειτουργεί
                    </a>
                </nav>
                @auth
                    <div class="flex items-center md:ml-12">
                        <a href="{{ route('profile.show') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                            {{ auth()->user()->name }}
                        </a>
                    </div>
                @elseauth
                    <div class="flex items-center md:ml-12">
                        <a href="{{ route('login') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="ml-8 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div x-description="Mobile menu, show/hide based on mobile menu state." x-show="mobileMenuOpen" x-transition:enter="duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-100 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-20 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
            <div class="pt-5 pb-6 px-5 sm:pb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <img class="h-8 w-auto" src="{{ url('/logo.png') }}" alt="Farmakeia.com.cy logo" title="The logo of farmakeia.com.cy" loading="eager">
                    </div>
                    <div class="-mr-2">
                        <button @click="mobileMenuOpen = false" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-6 sm:mt-8">
                    <nav>
                        <div class="grid gap-7 sm:grid-cols-2 sm:gap-y-8 sm:gap-x-4">

                            <a href="{{ route('homepage') }}" class="-m-3 flex items-center p-3 rounded-lg hover:bg-gray-50">
                                <div class="ml-4 text-base font-medium text-gray-900">
                                    Αρχική
                                </div>
                            </a>

                            <a href="{{ route('map') }}" class="-m-3 flex items-center p-3 rounded-lg hover:bg-gray-50">
                                <div class="ml-4 text-base font-medium text-gray-900">
                                    Προβολή Χάρτη
                                </div>
                            </a>

                            <a href="{{ route('rapid-tests') }}" class="-m-3 flex items-center p-3 rounded-lg hover:bg-gray-50">
                                <div class="ml-4 text-base font-medium text-gray-900">
                                    Χάρτης Rapid Test
                                </div>
                            </a>

                            <a href="{{ route('how-it-works') }}" class="-m-3 flex items-center p-3 rounded-lg hover:bg-gray-50">
                                <div class="ml-4 text-base font-medium text-gray-900">
                                    Πώς Λειτουργεί
                                </div>
                            </a>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
