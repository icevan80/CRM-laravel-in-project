<div>
    <div class="flex justify-between mx-7">
        <div style="display: flex">
            <h2 class="text-2xl font-bold">
                Менеджер записей
            </h2>
            <h2 class="text-2xl font-bold px-2">-</h2>
            <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="viewFilter">
                <option value="table_two_weeks">Две недели</option>
                <option value="table_one_week">Неделя</option>
                <option value="table_today_tomorrow">Сегодня - завтра</option>
                <option value="rows">Строки</option>
            </select>
            <h2 class="text-2xl font-bold px-4">-</h2>
            <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="selectFilter">
                <option value="upcoming">Новые</option>
                <option value="previous">Старые</option>
                <option value="cancelled">Отменены</option>
                <option value="current_month">За этот месяц</option>
                <option value="prev_month">За прошлый месяц</option>
            </select>
            <h2 class="text-2xl font-bold px-4">-</h2>


            <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="followFilter">
                <option value="salon">Салон</option>
                <option value="master">Конкретный мастер</option>
                <option value="self">Мои записи</option>
                <option value="all">Без фильтра</option>
            </select>
            @if($this->followFilter == 'salon')
                <h2 class="text-2xl font-bold px-4">-</h2>
                <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="locationFilter">
                    @foreach ($locations as $location)
                        <option value={{$location->id}}>{{$location->name}} - {{$location->address}}</option>
                    @endforeach
                </select>
            @elseif($this->followFilter == 'master')
                <h2 class="text-2xl font-bold px-4">-</h2>
                <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="masterFilter">
                    <option value="0">Все мастера</option>
                    @foreach ($masters as $master)
                        <option value="{{$master->id}}">{{$master->name}}</option>
                    @endforeach
                </select>
            @endif
        </div>
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
