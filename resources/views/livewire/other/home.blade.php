<div>
    <h1>WELCOME TO SERVER SHIZOFRENIYA Taalk</h1>
    @if(auth()->user()->name == 'Admin')
    <x-button.default wire:click="fillBD">
        <p>Заполнить БД</p>
    </x-button.default>
    @endif
</div>
