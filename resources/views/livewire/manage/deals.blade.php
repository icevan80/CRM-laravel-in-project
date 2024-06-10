<div>
    <div class="w-1/3 float-right m-4">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" wire:model="search" id="default-search" name="search"
                   class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Search Deals...">
            <x-button.default type="submit"
                    class="absolute right-2.5 bottom-2.5">
                Search
            </x-button.default>
        </div>
    </div>

    <table class="w-full border-collapse background-color text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="pl-6 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Name</th>
            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Description</th>
            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Discount</th>
            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Date Start</th>
            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Date End</th>
            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Is Hidden</th>
            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">


        @foreach ($deals as $deal)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4  max-w-0">{{ $deal->id }}</td>

                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $deal->name }}</td>

                <td class="px-4 py-4  max-w-0 font-medium text-gray-700">{{ $deal->description }}</td>

                <td class="px-4 py-4  max-w-0 font-medium text-gray-700">{{ $deal->discount }}</td>

                <td class="px-4 py-4  max-w-0 font-medium text-gray-700">{{ $deal->start_date }}</td>

                <td class="px-4 py-4  max-w-0 font-medium text-gray-700">{{ $deal->end_date }}</td>

                <td class="px-4 py-4 ">
                    <div>
                        @if($deal->is_hidden == true)
                            <span
                                class="inline-flex items-center gap-1 rounded-full error-color bg-lighter-90 bg-opacity-75 px-2 py-1 text-xs font-medium text-error-color">
                            <span class="h-1.5 w-1.5 rounded-full error-color"></span>
                            Hidden
                          </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full success-color bg-lighter-90 bg-opacity-75  px-2 py-1 text-xs font-medium text-green-600"
                            >
                            <span class="h-1.5 w-1.5 rounded-full success-color"></span>
                            Visible
                            </span>
                        @endif

                    </div>
                </td>
                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">
                    <div class="flex gap-1">
                        {{--<x-button.default wire:click="confirmDealEdit({{ $deal->id }})" wire:loading.attr="disabled">
                            {{ __('Edit') }}
                        </x-button.default>--}}
                        <x-button.danger wire:click="confirmDeleteDeal({{ $deal->id }})">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pl-6 pt-4">
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
