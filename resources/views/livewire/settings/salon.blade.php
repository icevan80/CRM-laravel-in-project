<div>
    <h1 class="store-primary-color">ABOBA</h1>
    <h1 class="store-secondary-color">ABOBA</h1>
    <h1 class="store-surface-color">ABOBA</h1>
    <h1>{{$this->primary}}</h1>
    <form action="{{route('settings.salon.update')}}" method="post">
        @csrf
        @method('PUT')
        <x-input name="primary_color" wire:model="primary"></x-input>
        <x-input name="secondary_color" wire:model="secondary"></x-input>
        <x-input name="surface_color" wire:model="surface"></x-input>
        <x-button.default>Изменить</x-button.default>
    </form>
</div>
