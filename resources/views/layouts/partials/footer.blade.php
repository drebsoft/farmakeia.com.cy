<footer class="bg-white">
    <div class="mx-auto max-w-7xl pt-12 px-4 sm:px-6 lg:px-8">
        <p class="text-center text-base leading-6 text-gray-400">
            {{ __('footer.disclaimer') }}
        </p>
    </div>
    <div class="mx-auto max-w-7xl pt-12 px-4 sm:px-6 lg:px-8">
        <p class="text-center text-base leading-6 text-black-700 font-bold">
            {{ __('footer.call_112') }}
        </p>
    </div>
    <div class="max-w-screen-xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
        <div class="flex justify-center space-x-6 md:order-2">
            <a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-gray-500">
                {{ __('footer.privacy_policy') }}
            </a>
        </div>
        <div class="mt-8 md:mt-0 md:order-1">
            <p class="text-center text-base leading-6 text-gray-400">
                &copy; 2020-{{ date('Y') }} farmakeia.com.cy. {{ __('footer.copyrights') }}
            </p>
        </div>
    </div>
</footer>
