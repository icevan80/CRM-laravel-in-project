<div>
    <div class="w-1/3 float-right m-1">
        <x-widgets.search placeholder="Search Deals..."></x-widgets.search>
    </div>

    <x-table.default>
        <x-slot name="thead">
            <tr>
                <x-table.column scope="col" class="">Id</x-table.column>
                <x-table.column scope="col" class="">Name</x-table.column>
                <x-table.column scope="col" class="w-full">Description</x-table.column>
                <x-table.column scope="col" class="">Discount</x-table.column>
                <x-table.column scope="col" class="">Date Start</x-table.column>
                <x-table.column scope="col" class="">Date End</x-table.column>
                <x-table.column scope="col" class="">Is Hidden</x-table.column>
                <x-table.column scope="col" class="">Actions</x-table.column>
            </tr>
        </x-slot>
        <x-slot name="tbody">


            @foreach ($deals as $deal)
                <x-table.row class="surface-color hover:bg-light-90 text-on-surface-color text-light-40 font-text-mini">
                    <x-table.column class="max-w-0">{{ $deal->id }}</x-table.column>
                    <x-table.column class="">{{ $deal->name }}</x-table.column>
                    <x-table.column class="">{{ $deal->description }}</x-table.column>
                    <x-table.column class="">{{ $deal->discount }}</x-table.column>
                    <x-table.column class="">{{ $deal->start_date }}</x-table.column>
                    <x-table.column class="">{{ $deal->end_date }}</x-table.column>
                    <x-table.column class="">
                        <div>
                            @if($deal->is_hidden == true)
                                <span
                                    class="inline-flex items-center gap-4 rounded-full error-color bg-darken-20 bg-paler-50 bg-lighter-90 bg-opacity-75  px-2 py-1 font-medium text-error-color text-darken-35">
                                <span class="h-4 w-4 rounded-full error-color"></span>
                            Hidden
                            </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-4 rounded-full success-color bg-darken-20 bg-lighter-90 bg-opacity-75  px-2 py-1 font-medium text-success-color text-darken-35">
                                <span class="h-4 w-4 rounded-full success-color"></span>
                            Visible
                            </span>
                            @endif
                        </div>
                    </x-table.column>
                    <x-table.column class="flex gap-1">
                        {{--<x-button.default wire:click="confirmDealEdit({{ $deal->id }})" wire:loading.attr="disabled">
                            {{ __('Edit') }}
                        </x-button.default>--}}
                        <x-button.danger wire:click="confirmDeleteDeal({{ $deal->id }})">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </x-table.column>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table.default>

    <div class="px-2 py-1">
        {{ $deals->links() }}
    </div>

    <form action="{{route('manage.deals.destroy', ['id' => $this->confirmingDeleteDeal])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmingDeleteDeal">
            <x-slot name="title">
                {{ __('Delete Deal') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the deal?') }}
            </x-slot>

            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.danger type="submit">
                        {{ __('Delete') }}
                    </x-button.danger>
                    <x-button.secondary wire:click="$set('confirmingDeleteDeal', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>
</div>
