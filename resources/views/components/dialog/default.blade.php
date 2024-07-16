@props(['id' => null, 'maxWidth' => null])

<x-dialog.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-2 py-1">
        <div class="font-text-small-plus font-medium text-on-surface-color text-darken-15">
            {{ $title }}
        </div>

        <div class="mt-2 font-text-small text-on-surface-color text-darken-25">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-2 py-1 background-color bg-darken-10 text-right">
        {{ $footer }}
    </div>
</x-dialog.modal>
