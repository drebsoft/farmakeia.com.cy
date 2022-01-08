<x-guest-layout>
    <x-slot name="headerSlot">
        <title>Ψάχνεις τα εφημερέυοντα φαρμακεία για σήμερα; - farmakeia.com.cy</title>
        <meta name="description"
              content="Ψάχνεις τα εφημερέυοντα φαρμακεία για σήμερα ή απλά τα φαρμακεία της περιοχής σου; Το farmakeia.com.cy μπορεί να σε βοηθήσει!">
    </x-slot>

    <div class="max-w-screen-xl mx-auto py-8 px-4 sm:py-12 sm:px-6 lg:px-8 lg:pb-5">
        <div class="text-center">
            <h1 class="mt-1 text-xl leading-10 font-extrabold text-gray-900 sm:text-xl sm:leading-none sm:tracking-tight md:text-2xl lg:text-4xl">
                {{ __('homepage.headline') }}
            </h1>
            <p class="max-w-xl md:mt-5 mx-auto text-lg leading-7 text-gray-500">
                {{ __('homepage.subline') }}
            </p>
        </div>
    </div>

    @include('homepage.partials._cyprusmap')

    <div class="max-w-screen-xl mx-auto py-8 px-4 sm:py-12 sm:px-6 lg:px-8 lg:pb-5">
        <div class="text-center">
            <p class="max-w-xl md:mt-5 mx-auto text-lg leading-7">
                {{ __('homepage.map_text_version') }}
            </p>
            <a href="{{ route('farmakeia', ['region' => 'lefkosia']) }}" class="text-lg text-green-500">{{ __('general.lefkosia') }}</a> |
            <a href="{{ route('farmakeia', ['region' => 'lemesos']) }}" class="text-lg text-green-500">{{ __('general.lemesos') }}</a> |
            <a href="{{ route('farmakeia', ['region' => 'larnaka']) }}" class="text-lg text-green-500">{{ __('general.larnaka') }}</a> |
            <a href="{{ route('farmakeia', ['region' => 'paphos']) }}" class="text-lg text-green-500">{{ __('general.paphos') }}</a> |
            <a href="{{ route('farmakeia', ['region' => 'paralimni']) }}" class="text-lg text-green-500">{{ __('general.paralimni') }}</a>
        </div>
    </div>
    <div class="max-w-screen-xl mx-auto py-8 px-4 sm:py-12 sm:px-6 lg:px-8 lg:pb-5">
        <div class="text-center">
            <p class="md:mt-5 mx-auto text-sm leading-7 text-gray-400 italic">
                {{ __('homepage.home_disclaimer') }}
            </p>
        </div>
    </div>

    @php
        echo \Spatie\SchemaOrg\Schema::webSite()
            ->name('farmakeia.com.cy')
            ->email('support@farmakeia.com.cy')
            ->contactPoint(\Spatie\SchemaOrg\Schema::contactPoint()->areaServed('Cyprus'))
            ->toScript();
    @endphp
</x-guest-layout>
