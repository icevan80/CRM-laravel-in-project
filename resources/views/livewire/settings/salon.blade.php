<div class="m-4">
    <div>
        <h1>Color scheme</h1>
        <div><p>Examples: yellow/#000000/rgb(255 255 255)</p></div>
    <form action="{{route('settings.salon.update')}}" method="post">
        @csrf
        @method('PUT')
        <x-inputs.color color="primary_variant_color"></x-inputs.color>
        <x-inputs.color color="primary_color"></x-inputs.color>
        <x-inputs.color color="primary_unselect_color"></x-inputs.color>
        <x-inputs.color color="on_primary_color"></x-inputs.color>
        <x-inputs.color color="secondary_variant_color"></x-inputs.color>
        <x-inputs.color color="secondary_color"></x-inputs.color>
        <x-inputs.color color="secondary_unselect_color"></x-inputs.color>
        <x-inputs.color color="on_secondary_color"></x-inputs.color>
        <x-inputs.color color="surface_color"></x-inputs.color>
        <x-inputs.color color="on_surface_color"></x-inputs.color>
        <x-inputs.color color="background_color"></x-inputs.color>
        <x-inputs.color color="on_background_color"></x-inputs.color>
        <x-inputs.color color="success_color"></x-inputs.color>
        <x-inputs.color color="on_success_color"></x-inputs.color>
        <x-inputs.color color="error_color"></x-inputs.color>
        <x-inputs.color color="on_error_color"></x-inputs.color>
        <x-inputs.color color="text_on_primary_color"></x-inputs.color>
        <x-inputs.color color="text_on_secondary_color"></x-inputs.color>
        <x-inputs.color color="text_on_surface_color"></x-inputs.color>
        <x-button.default>Изменить</x-button.default>
    </form>
    </div>
</div>
