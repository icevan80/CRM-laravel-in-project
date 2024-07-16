<div class="font-text-small">
    <div>
        <h1>Color scheme</h1>
        <div><p>Examples: yellow/#000000/rgb(255 255 255)</p></div>
        <form action="{{route('settings.salon.updateScheme')}}" method="post">
            @csrf
            @method('PUT')
            <x-inputs.color color="primary_variant_color"></x-inputs.color>
            <x-inputs.color color="primary_color"></x-inputs.color>
            <x-inputs.color color="on_primary_color"></x-inputs.color>
            <x-inputs.color color="secondary_variant_color"></x-inputs.color>
            <x-inputs.color color="secondary_color"></x-inputs.color>
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
    <div>
        <h1 class="my-2">Fonts</h1>
        <form action="{{route('settings.salon.updateFonts')}}" method="post">
            @csrf
            @method('PUT')
            <x-inputs.text label="{{ __('Primary font name') }}" id="primary_font_name" name="primary_font_name" value="{{$this->fonts['primary_font_name']}}"></x-inputs.text>
            <p class="primary-font">Primary font example</p>
            <x-inputs.text label="{{ __('Primary font url') }}" class="w-1/2" id="primary_font_url" name="primary_font_url" value="{{$this->fonts['primary_font_url']}}"></x-inputs.text>
            <x-inputs.text label="{{ __('Secondary font name') }}" id="secondary_font_name" name="secondary_font_name" value="{{$this->fonts['secondary_font_name']}}"></x-inputs.text>
            <p class="secondary-font">Secondary font example</p>
            <x-inputs.text label="{{ __('Secondary font url') }}" class="w-1/2" id="secondary_font_url" name="secondary_font_url" value="{{$this->fonts['secondary_font_url']}}"></x-inputs.text>
            <div class="my-1">
            <x-button.default>Изменить</x-button.default>
            </div>
        </form>
    </div>
    <div>
        <h1 class="my-2">Logo</h1>
        <form action="{{route('settings.salon.updateLogo')}}" method="post">
            @csrf
            @method('PUT')
            <livewire:components.upload-photo :tag="'logo_url'" :source="$this->logoUrl" :name-output="'logo.png'" :storage-output="'salon'"/>
            <div class="my-1">
                <x-button.default>Сохранить</x-button.default>
            </div>
        </form>
    </div>
    <div>
        <h1 class="my-2">About</h1>
        <form action="{{route('settings.salon.updateAbout')}}" method="post">
            @csrf
            @method('PUT')
            <x-inputs.textarea label="{{ __('About us') }}" id="about_salon" name="about_salon" value="{{$salon->about}}"></x-inputs.textarea>
            <div class="my-1">
                <x-button.default>Сохранить</x-button.default>
            </div>
        </form>
    </div>
    <div>
        <h1 class="my-2">Base information</h1>
        <form action="{{route('settings.salon.updateInformation')}}" method="post">
            @csrf
            @method('PUT')
            <x-inputs.text label="{{ __('Primary font name') }}" id="primary_font_name" name="primary_font_name" value="{{$this->fonts['primary_font_name']}}"></x-inputs.text>
            <div class="my-1">
                <x-button.default>Сохранить</x-button.default>
            </div>
        </form>
    </div>
</div>
