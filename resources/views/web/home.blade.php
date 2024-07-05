<x-app-layout>
    {{--    <x-slot name="mainLogoRoute">--}}
    {{--        {{ route('home') }}--}}
    {{--    </x-slot>--}}


    <div class="relative">
    {{-- <img class="w-full" src="{{ asset('images\banner-salon.png') }}" alt="Banner image"> --}}
    {{-- <img class="max-h-fit w-full" src="{{ asset('images\salon1.png') }}" alt="Banner image"> --}}
    <!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
-->
        <section>
            <x-blocks.preview-block></x-blocks.preview-block>
        </section>
        <section>
            <x-blocks.categories-block :categories="$categories"></x-blocks.categories-block>
        </section>
        <section>
            <x-blocks.specials-block></x-blocks.specials-block>
        </section>
        <section>
            <x-blocks.about-block></x-blocks.about-block>
        </section>
        <section>
            <x-blocks.masters-block></x-blocks.masters-block>
        </section>
        <section>
            <x-blocks.reviews-block></x-blocks.reviews-block>
        </section>
        <section>
            <x-blocks.map-block></x-blocks.map-block>
        </section>
        <section>
            <x-blocks.feedback-block></x-blocks.feedback-block>
        </section>
        <section>
            <x-blocks.footer-block></x-blocks.footer-block>
        </section>
    </div>
</x-app-layout>
