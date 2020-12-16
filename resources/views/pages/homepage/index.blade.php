<x-guest-layout>
    <x-slot name="headerSlot">
        <title>Ψάχνεις τα εφημερέυοντα φαρμακεία για σήμερα; - farmakeia.com.cy</title>
        <meta name="description"
              content="Ψάχνεις τα εφημερέυοντα φαρμακεία για σήμερα ή απλά τα φαρμακεία της περιοχής σου; Το farmakeia.com.cy μπορεί να σε βοηθήσει!">
    </x-slot>
    <x-slot name="extrastyles">
        <style>
            #nicosia_svg:hover text,
            #limassol_svg:hover text,
            #larnaca_svg:hover text,
            #ammochostos_svg:hover text,
            #paphos_svg:hover text {
                display: block;
            }

            #nicosia_svg:hover path,
            #limassol_svg:hover path,
            #larnaca_svg:hover path,
            #ammochostos_svg:hover path,
            #paphos_svg:hover path {
                fill: #77b251;
            }
        </style>
    </x-slot>

    <div class="max-w-screen-xl mx-auto py-8 px-4 sm:py-12 sm:px-6 lg:px-8 lg:pb-5">
        <div class="text-center">
            <h1 class="mt-1 text-xl leading-10 font-extrabold text-gray-900 sm:text-xl sm:leading-none sm:tracking-tight md:text-2xl lg:text-4xl">
                Όλα τα εφημερεύοντα φαρμακεια της Κυπρου
            </h1>
            <p class="max-w-xl md:mt-5 mx-auto text-lg leading-7 text-gray-500">
                Επίλεξε επαρχία στον χάρτη για να προχωρήσεις
            </p>
        </div>
    </div>

    @include('pages.homepage.partials._cyprusmap')

    <div class="max-w-screen-xl mx-auto py-8 px-4 sm:py-12 sm:px-6 lg:px-8 lg:pb-5">
        <div class="text-center">
            <p class="max-w-xl md:mt-5 mx-auto text-lg leading-7">
                Αν δεν καταφέρνεις να δεις το χάρτη δοκίμασε τα παρακάτω links
            </p>
            <a href="{{ route('farmakeia', ['region' => 'lefkosia']) }}" class="text-lg text-green-500">Λευκωσία</a> |
            <a href="{{ route('farmakeia', ['region' => 'lemesos']) }}" class="text-lg text-green-500">Λεμεσός</a> |
            <a href="{{ route('farmakeia', ['region' => 'larnaka']) }}" class="text-lg text-green-500">Λάρνακα</a> |
            <a href="{{ route('farmakeia', ['region' => 'paphos']) }}" class="text-lg text-green-500">Πάφος</a> |
            <a href="{{ route('farmakeia', ['region' => 'paralimni']) }}" class="text-lg text-green-500">Παραλίμνι</a>
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
