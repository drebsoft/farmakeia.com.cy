<x-guest-layout>
    <div class="py-10">
        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="my-4 w-full inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium leading-5 bg-red-100 text-red-800">
                    Το φαρμακείο που αναζητείτε δεν βρέθηκε
                </div>
                <div class="mt-4 flex justify-center md:mt-0 md:ml-4">
                    <span class="shadow-sm rounded-md">
                        <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out"
                           href="{{ route('homepage') }}"
                        >
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Επιστροφή στην αρχική</span>
                        </a>
                    </span>
                </div>
            </div>
        </main>
    </div>
</x-guest-layout>
