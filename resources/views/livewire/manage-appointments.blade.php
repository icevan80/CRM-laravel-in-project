<div>
    <div class="flex justify-between mx-7">
        <h2 class="text-2xl font-bold">

            @if ($selectFilter == 'upcoming')
                Ожидающиеся
            @elseif ($selectFilter == 'previous')
                Старые
            @elseif ($selectFilter == 'cancelled')
                Отменененые
            @endif


            записи</h2>

        <x-button wire:click="confirmAppointmentAdd"
                  class="px-5 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
            Create
        </x-button>
    </div>
    <div class="mt-4">
        @if (session()->has('message'))
            <div class="px-4 py-2 text-white bg-green-500 rounded-md">
                {{ session('message') }}

            </div>
        @endif
    </div>

    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">

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

        <h1>{{ $this->selectedDay  }}</h1>
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="w-0 py-4 text-center font-medium text-gray-900 border p-2">

{{--                    <input type="date" wire:model="dateRange.now">--}}
                    <x-input wire:model="selectedDay" type="date"
                           class="border text-gray-900  border-gray-300 rounded-lg"
                           value="{{ Carbon\Carbon::parse($selectedDay)->format('Y-m-d') }}"
                    ></x-input>
{{--                    <input type="date" wire:model="startDate"--}}
{{--                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"--}}
{{--                           value="{{ Carbon\Carbon::parse($startDate)->format('Y-m-d') }}">--}}

                </th>
                @foreach($this->tableCells as $cellDay)
                    <th scope="col"
                        class="{{$cellDay['day']->toDateString() == $this->dateRange['now']->toDateString() ? 'bg-pink-600 text-white' : 'text-gray-900'}} py-4 text-center font-medium border p-2">{{
                                $cellDay['day']->isoFormat('MMM. D') }}<br/>{{ $cellDay['day']->isoFormat('ddd') }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody class="bg-gray-50">
            @foreach($this->tableCells[0]['schedule'] as $minutes)
                @if($loop->odd)
                    <tr>
                        <th scope="col" rowspan="2" class="pl-6 font-medium text-gray-900 border p-2">{{
                                $minutes['minutes']->isoFormat('HH : mm') }}</th>
                        @endif
                        @foreach($this->tableCells as $cellDay)
                            @foreach($cellDay['schedule'] as $cellMinute)
                                @if($cellMinute['minutes']->toTimeString() == $minutes['minutes']->toTimeString())
                                    <th wire:click="confirmAppointmentCreate('{{ $cellMinute['minutes'] }}')"
                                        scope="col" class="empty-spot text-center font-medium border py-2">
                                        <p>{{ $cellMinute['minutes']->isoFormat('HH : mm') }}</p>
                                    </th>
                                @endif
                            @endforeach
                        @endforeach
                        @if($loop->odd)
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        {{--<table
            class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class=" py-4 text-center font-medium text-gray-900 border p-2">
                    <input type="date" class="border text-gray-900  border-gray-300 rounded-lg"
                           wire:model="selectedDay">
                </th>
                @for ($i = today()->setDateFrom($selectedDay)->setDaysFromStartOfWeek(1); $i < today()->
                    setDateFrom($selectedDay)->setDaysFromStartOfWeek(1)->addWeeks(2); $i->addDay(1))
                    <th scope="col"
                        class="{{$i->toDateString() == $selectedDay ? 'bg-pink-600 text-white' : 'text-gray-900'}} py-4 text-center font-medium border p-2">{{
                                $i->isoFormat('MMM. D') }}<br/>{{ $i->isoFormat('ddd') }}</th>
                @endfor
            </tr>
            @for ($i = today()->setDateFrom($selectedDay)->setDaysFromStartOfWeek(1)->hour(8); $i <= today()->
                setDateFrom($selectedDay)->setDaysFromStartOfWeek(1)->hour(20); $i->addMinutes(15))
                <tr>
                    @if ($i->minute == 0 || $i->minute == 30)
                        <th scope="col" rowspan="2" class="pl-6 font-medium text-gray-900 border p-2">{{
                                $i->isoFormat('HH : mm') }}</th>
                    @endif
                    @for ($k = $i->copy(); $k < $i->copy()->addWeeks(2); $k->addDay(1))
                        @forelse ($appointments as $appointment)
                            @if($appointment->date == $k->toDateString() && ($appointment->start_time <=
                                $i->toTimeString() && $appointment->end_time > $i->toTimeString()))
                                @if($appointment->start_time == $i->toTimeString())
                                    <th rowspan="{{ today()->setTimeFromTimeString($appointment->end_time)->diffInHours($appointment->start_time) * 60  / 15 }}"
                                        wire:click="setSelectedAppointment({{ $appointment }})" scope="col"
                                        class="selected-slot text-white bg-pink-600 font-medium border p-2"><p
                                            class="time-slot">{{
                                        today()->setTimeFromTimeString($appointment->start_time)->isoFormat('HH:mm') }}</p>
                                        <p class="client-name-slot">{{
                                        $appointment->creator->name }}</p>
                                        <p class="appointment-name-slot">{{
                                        $appointment->service->name }}</p></th>
                                @endif
                                @break
                            @endif
                            @if($loop->last)
                                <th wire:click="confirmAppointmentCreate('{{ $k }}')" scope="col"
                                    class="empty-spot text-center font-medium border py-2">
                                    <p>{{ $i->isoFormat('HH : mm') }}</p>
                                </th>
                            @endif
                        @empty
                            <th wire:click="confirmAppointmentCreate('{{ $k }}')" scope="col"
                                class="empty-spot text-center font-medium border py-2">
                                <p>{{ $i->isoFormat('HH : mm') }}</p>
                            </th>
                        @endforelse
                    @endfor
                </tr>
            @endfor
            </thead>
        </table>--}}
        {{--<table
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
                            <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->user->name}}</td>
                            <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->user->phone_number}}
                            </td>
                            <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $appointment->user->email}}</td>
                        @endif

                        <td>
                            <div class="flex gap-1 mt-5">
                                --}}{{-- <x-button wire:click="confirmAppointmentEdit({{ $appointment->id }})"
                                    wire:loading.attr="disabled">--}}{{--
                                --}}{{-- {{ __('Edit') }}--}}{{--
                                --}}{{-- </x-button>--}}{{--

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
        </table>--}}


        <x-dialog-modal wire:model="confirmingAppointmentSelect">
            <x-slot name="title">
                Aboba
            </x-slot>
            <x-slot name="content">
                @if($selectedAppointment != null)
                    <div>
                        <h1>{{ $selectedAppointment->service->name }}</h1>
                        <h1>{{ $selectedAppointment->date }}</h1>
                        <h1>{{ $selectedAppointment->start_time }}</h1><br>
                        <h1>{{ $selectedAppointment->receiving->name}}</h1>
                        <h1>{{ $selectedAppointment->receiving->phone_number}}</h1>
                        <h1>{{ $selectedAppointment->receiving->email}}</h1><br>
                        <h1>{{ $selectedAppointment->creator->name}}</h1>
                        <h1>{{ $selectedAppointment->creator->phone_number}}</h1>
                        <h1>{{ $selectedAppointment->creator->email}}</h1>
                    </div>
                @endif
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('confirmingAppointmentSelect', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Back') }}
                    </x-secondary-button>
                </div>

            </x-slot>
        </x-dialog-modal>


        <x-dialog-modal wire:model="notificationAppointmentCreated">
            <x-slot name="title">
                Статус создания
            </x-slot>
            <x-slot name="content">
                <p>Объявление успешно создано</p>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('notificationAppointmentCreated', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Ok') }}
                    </x-secondary-button>
                </div>

            </x-slot>
        </x-dialog-modal>

        <x-dialog-modal wire:model="notificationAppointmentCreatedError">
            <x-slot name="title">
                Статус создания
            </x-slot>
            <x-slot name="content">
                <p>Объявление не было создано, т.к. этот промежуток времени уже занят</p>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('notificationAppointmentCreatedError', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Ok') }}
                    </x-secondary-button>
                </div>

            </x-slot>
        </x-dialog-modal>

        <div class="p-5">
            {{ $appointments->links() }}
        </div>


        <x-dialog-modal wire:model="confirmingAppointmentCreate">
            <x-slot name="title">
                {{ __('Create Appointment') }}
            </x-slot>
            <x-slot name="content">
                @if($selectedCreateTime != null)
                    <label for="service" class="block text-sm font-medium text-gray-700">Sevice</label>
                    <select id="service" class="border text-gray-900  border-gray-300 rounded-lg"
                            wire:model="selectedCreateService">
                        <option selected="selected" disabled value="">Select a service</option>
                        @foreach ($services as $service)
                            <option value="{{$service}}">{{$service->name}}</option>
                        @endforeach
                    </select>

                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input id="date" type="date" class="border text-gray-900  border-gray-300 rounded-lg"
                           wire:model="selectedCreateDay"
                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                           max="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
                    <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                    <div class="time-block">
                        <select id="time" class="border text-gray-900  border-gray-300 rounded-lg"
                                wire:model="selectedCreateTime">
                            @for ($i = today()->setDateFrom($selectedDay)->hour(8); $i <= today()->setDateFrom($selectedDay)->hour(20); $i->addMinutes(15))
                                <option value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
                            @endfor
                        </select>
                        <p class="block text-center text-sm font-medium text-gray-700">
                            - {{ today()->setTimeFrom($selectedCreateTime)->addMinutes(60)->isoFormat('HH:mm') }}</p>
                    </div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <select id="location"
                            class="border text-gray-900  border-gray-300 rounded-lg"
                            wire:model="selectedCreateLocation">
                        <option selected="selected" disabled value="">Select a location</option>
                        @foreach ($locations as $location)
                            <option value="{{$location}}">{{$location->name}} - {{$location->address}}</option>
                        @endforeach
                    </select>
                @endif
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('confirmingAppointmentCreate', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Back') }}
                    </x-secondary-button>
                    <x-button
                        wire:click="createAppointment({{ $selectedCreateService }}, {{ $selectedCreateLocation }}, '{{ $selectedCreateTime }}', '{{ $selectedCreateDay }}')">
                        Create
                    </x-button>
                </div>

            </x-slot>
        </x-dialog-modal>

        <x-dialog-modal wire:model="confirmingAppointmentCancellation">
            <x-slot name="title">
                {{ __('Cancel Appointment') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to cancel the appointment?') }}

            </x-slot>

            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('confirmingAppointmentCancellation', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Back') }}
                    </x-secondary-button>

                    <x-danger-button wire:click="cancelAppointment({{ $confirmingAppointmentCancellation }})"
                                     wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-danger-button>
                </div>

            </x-slot>
        </x-dialog-modal>
        <x-dialog-modal wire:model="confirmingAppointmentAdd">
            <x-slot name="title">
                {{ isset($this->appointment->id) ? 'Edit Appointment' : 'Add Appointment' }}
            </x-slot>

            <x-slot name="content">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="appointment.name" id="name"
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    @error('appointment.name') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>

                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                    <div class="flex justify-end mt-4 gap-2">
                        <x-secondary-button wire:click="$set('confirmingAppointmentAdd', false)"
                                            wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-button wire:click="saveAppointment">Save</x-button>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
            </x-slot>
        </x-dialog-modal>
    </div>
</div>

<style>
    .selected-slot p {
        max-width: 60px;
    }

    .selected-slot .client-name-slot {
        margin: 16px 0;
    }

    .selected-slot .appointment-name-slot {
        max-height: 148px;
        overflow: hidden;
        max-lines: 2;
    }

    .selected-slot:hover {
        background-color: red;
    }

    .empty-spot {
        height: 37px;
    }

    .empty-spot p {
        display: none;
    }

    .empty-spot:hover {
        background: gray;
        color: black;
        cursor: pointer;
    }

    .empty-spot:hover p {
        display: block;
        cursor: pointer;
    }

    .time-block {
        display: flex;
    }

    .time-block p {
        margin: auto 16px;
    }
</style>
