@props(['id' => null, 'maxWidth' => null])

<x-dialog.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-on-surface-color text-darken-15">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-on-surface-color text-darken-25">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 background-color bg-lighter-85 bg-opacity-75 text-right">
        {{ $footer }}
    </div>
</x-dialog.modal>
