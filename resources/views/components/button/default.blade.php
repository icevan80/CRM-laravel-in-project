{{--<div style="background-color: black;">--}}
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 primary-color border border-transparent rounded-md font-semibold text-xs text-on-primary-color primary-color hover:bg-darken-35 uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
{{--</div>--}}

<style>
    /*[class~=class_name] {*/
    /*    */
    /*}*/

    .testiki-color{
        /*--tw-bg-opacity: 1;
        --bg-color-s: var(--primary-s);
        --bg-color-l: var(--primary-l);
        background-color: hsl(var(--primary-h) var(--bg-color-s) var(--bg-color-l, var(--primary-l)) / var(--tw-bg-opacity));*/
        /*--tw-bg-opacity: 1;*/
        /*!*--bg-color-s: var(--primary-variant-s);*!*/
        /*--bg-color-s: var(class_name);*/
        /*--bg-color-l: var(--primary-variant-l);*/
        /*background-color: hsl(var(--primary-variant-h) var(--bg-color-s) var(--bg-color-l) / var(--tw-bg-opacity));*/
    }


    .testiki:hover {
        /*--bg-color-l: 25;*/
        /*--bg-color-s: 75;*/
        /*counter-increment: testim 20;*/
        /*--bg-color-l: calc(var(--bg-color-l) + 15);*/
        /*--bg-color-l: var(--bg-color-l);*/
        /*--i: 1;
        z-index: var(--i);
        --i: calc(var(--i) + 1);
        z-index: var(--i);*/
    }
</style>
