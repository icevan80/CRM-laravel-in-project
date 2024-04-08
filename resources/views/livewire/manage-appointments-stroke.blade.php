<div>
    <div class="flex justify-between mx-7">
        <h2 class="text-2xl font-bold">
            Менеджер записей - <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="typeOfView">
                <option value="TableCrmTwoWeeks">Две недели</option>
                <option value="TableCrmTodayTomorrow">Сегодня - завтра</option>
                <option value="TableRows">Строки</option>
            </select></h2>
    </div>
    <div class="w-full m-4 flex">

        <div class="w-1/2 mx-2">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" wire:model="search" id="default-search" name="search"
                       class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Искать запись...">
                <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-pink-600 hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-4 py-2">
                    Искать
                </button>
            </div>
        </div>
        <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="selectFilter">
            <option value="upcoming">Новые</option>
            <option value="previous">Старые</option>
            <option value="cancelled">Отменены</option>
        </select>
    </div>
    <table
        class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="pl-6 py-4 font-medium text-gray-900">Code</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Услуга</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Дата</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Время</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Где</th>
            @if(auth()->user()->role->name == 'Customer')
                <th scope="col" class="px-4 py-4 font-medium text-gray-900">Адрес</th>
                <th scope="col" class="px-4 py-4 font-medium text-gray-900">Телефон</th>

            @elseif (auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Employee')
                <th scope="col" class="px-4 py-4 font-medium text-gray-900">Клиент</th>
                <th scope="col" class="px-4 py-4 font-medium text-gray-900">Телефон</th>
                <th scope="col" class="px-4 py-4 font-medium text-gray-900">Email</th>

            @endif
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Действия</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
        @if($appointments->count() == 0)
            <tr class="hover:bg-gray-50 text-center">
                <td class="pl-6 py-4  max-w-0
                    " colspan="9">Записей не нашлось
                </td>
            </tr>
        @else
            @foreach ($appointments as $appointment)
                <tr class="hover:bg-gray-50">
                    <td class="pl-6 py-4  max-w-0">{{ $appointment->appointment_code }}</td>

                    <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->service->name}}</td>
                    <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->date}}</td>
                    <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->start_time
                        }} - {{ $appointment->end_time }}</td>
                    <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->location->name}}</td>

                    @if(auth()->user()->role->name == 'Customer')
                        <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->location->address}}
                        </td>
                        <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{
                        $appointment->location->telephone_number}}</td>

                    @elseif (auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Employee')
                        <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->creator->name}}</td>
                        <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->creator->phone_number}}
                        </td>
                        <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->creator->email}}</td>
                    @endif


                    <td>
                        <div class="flex gap-1 mt-5">
{{--                            <x-button wire:click="confirmAppointmentEdit({{ $appointment->id }})"--}}
{{--                                      wire:loading.attr="disabled">--}}
{{--                                {{ __('Edit') }}--}}
{{--                            </x-button>--}}

                            @if ($appointment->date >= today())
                                <x-danger-button
                                    wire:click="confirmAppointmentCancellation({{ $appointment->id }})"
                                    wire:loading.attr="disabled">
                                    {{ __('Cancel') }}
                                </x-danger-button>
                            @endif


                        </div>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
