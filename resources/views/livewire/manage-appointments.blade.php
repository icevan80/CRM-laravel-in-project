<div>
    <div class="flex justify-between mx-7">
        <h2 class="text-2xl font-bold">

            {{--            @if ($selectFilter == 'upcoming')--}}
            {{--                Ожидающиеся--}}
            {{--            @elseif ($selectFilter == 'previous')--}}
            {{--                Старые--}}
            {{--            @elseif ($selectFilter == 'cancelled')--}}
            {{--                Отменененые--}}
            {{--            @endif--}}


            Менеджер записей</h2>

        {{--        <x-button wire:click="confirmAppointmentAdd"--}}
        {{--                  class="px-5 py-2 text-white bg-pink-500 rounded-md hover:bg--600">--}}
        {{--            Create--}}
        {{--        </x-button>--}}
    </div>
    <div class="mt-4">
        @if (session()->has('message'))
            <div class="px-4 py-2 text-white bg-green-500 rounded-md">
                {{ session('message') }}

            </div>
        @endif
    </div>

    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">

        {{-- <div class="w-full m-4 flex">

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
         </div>--}}

        <h1>{{ $this->selectedDay  }}</h1>
        <h1>{{ \Carbon\Carbon::now()  }}</h1>
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="w-0 py-4 text-center font-medium text-gray-900 border p-2">
                    <x-input wire:model="selectedDay" type="date"
                             class="border text-gray-900  border-gray-300 rounded-lg"></x-input>
                </th>
                @foreach($tableCells as $cellDay)
                    <th scope="col"
                        class="{{$cellDay['day'] == $this->dateRange['now']->toDateString() ? 'bg-pink-600 text-white' : 'text-gray-900'}} py-4 text-center font-medium border p-2">{{
                                \Carbon\Carbon::parse($cellDay['day'])->isoFormat('MMM. D') }}
                        <br/>{{ \Carbon\Carbon::parse($cellDay['day'])->isoFormat('ddd') }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody drag-root class="bg-gray-50">
            @foreach($tableCells[0]['schedule'] as $minutes)
                @if($loop->odd)
                    <tr>
                        <th scope="col" rowspan="2" class="w-0 pl-6 font-medium text-gray-900 border p-2">{{
                                \Carbon\Carbon::parse($minutes['minutes'])->isoFormat('HH : mm') }}</th>
                        @endif
                        @foreach($tableCells as $cellDay)
                            @foreach($cellDay['schedule'] as $cellMinute)
                                @if($cellMinute['minutes'] == $minutes['minutes'])
                                    @if($cellMinute['appointment'] != null)
                                        <th drag-item="{{ $cellMinute['id'] }}"
                                            draggable="{{ \Carbon\Carbon::parse($cellDay['day'])->setTimeFrom($cellMinute['minutes'])->greaterThan(now()) && $cellMinute['appointment']['status'] == 1 ? 'true' : 'false' }}"
                                            wire:key="{{ $cellMinute['id'] }}"
                                            rowspan="{{$cellMinute['range']}}"
                                            wire:click="setSelectedAppointment({{ $cellMinute['appointment'] }})"
                                            scope="col"
                                            class="selected-slot text-white {{ $cellMinute['appointment']['status'] == 1 ? 'bg-pink-600' : 'bg-green-600' }}  font-medium border p-2">
                                            <p
                                                class="time-slot">{{
                                        \Carbon\Carbon::parse($cellMinute['appointment']->start_time)->isoFormat('HH:mm') }}</p>
                                            <p class="client-name-slot">{{
                                        $cellMinute['appointment']->creator->name }}</p>
                                            <p class="appointment-name-slot">{{
                                        $cellMinute['appointment']->service->name }}</p></th>
                                    @elseif($cellMinute['collapse'] == true)
                                        <th wire:key="{{ $cellMinute['id'] }}"
                                            wire:click="confirmAppointmentCreate('{{ $cellMinute['minutes'] }}')"
                                            scope="col" style="display: none">
                                        </th>
                                    @else
                                        @if(\Carbon\Carbon::parse($cellDay['day'])->setTimeFrom($cellMinute['minutes'])->greaterThan(now()))
                                            <th drag-item="{{ $cellMinute['id'] }}" wire:key="{{ $cellMinute['id'] }}"
                                                wire:click="confirmAppointmentCreate('{{ \Carbon\Carbon::parse($cellDay['day'])->setTimeFrom($cellMinute['minutes']) }}')"
                                                scope="col" class="empty-spot text-center font-medium border py-2">
                                                <p>{{ \Carbon\Carbon::parse($cellMinute['minutes'])->isoFormat('HH : mm') }}</p>
                                            </th>
                                        @else
                                            <th drag-item="{{ $cellMinute['id'] }}" wire:key="{{ $cellMinute['id'] }}"
                                                scope="col" class="past-spot text-center font-medium border py-2">
                                                <p>{{ \Carbon\Carbon::parse($cellMinute['minutes'])->isoFormat('HH : mm') }}</p>
                                            </th>
                                        @endif
                                    @endif
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
                @if($appointment != null)
                    <div>
                        <h1>{{ $appointment->service->name }}</h1>
                        <h1>{{ $appointment->date }}</h1>
                        <h1>{{ $appointment->start_time }}</h1><br>
                        <h1>{{ $appointment->creator->name}}</h1>
                        <h1>{{ $appointment->creator->phone_number}}</h1>
                        <h1>{{ $appointment->creator->email}}</h1>
                    </div>
                @endif
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    @if ($appointment != null && $appointment->status == 1)
                        <x-danger-button
                            wire:click="confirmAppointmentCancellation({{ $appointment->id }})"
                            wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-danger-button>
                    @endif
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

        <x-dialog-modal wire:model="notificationAppointmentSwapped">
            <x-slot name="title">
                Статус создания
            </x-slot>
            <x-slot name="content">
                <p>Объявление было назначено на другое время!</p>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('notificationAppointmentSwapped', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Ok') }}
                    </x-secondary-button>
                </div>

            </x-slot>
        </x-dialog-modal>

        <div class="p-5">
            {{ $appointments->links() }}
        </div>

        <x-dialog-modal wire:model="notificationAppointmentSwappedError">
            <x-slot name="title">
                Статус создания
            </x-slot>
            <x-slot name="content">
                <p>Объявление не было перемещено, т.к. выбранный промежуток времени уже занят</p>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('notificationAppointmentSwappedError', false)"
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
                @if($this->newAppointment['creator_id'] != null)
                    <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                    <x-input id="name" type="text" wire:model="newAppointment.receiving_name" class="border text-gray-900  border-gray-300 rounded-lg">
                    </x-input>
                    <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                    <textarea id="description" wire:model="newAppointment.receiving_description" class="border text-gray-900  border-gray-300 rounded-lg"></textarea>
                    <label for="service" class="block text-sm font-medium text-gray-700">Sevice</label>
                    <select id="service" class="border text-gray-900  border-gray-300 rounded-lg"
                            wire:model="newAppointment.service_id">
                        @foreach ($services as $service)
                            <option value={{$service->id}}>{{$service->name}}</option>
                        @endforeach
                    </select>

                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <x-input id="date" type="date" class="border text-gray-900  border-gray-300 rounded-lg"
                             wire:model="newAppointment.date"
                             min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                             max="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
                    </x-input>
                    <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                    <div class="time-block">
                        <select id="time" class="border text-gray-900  border-gray-300 rounded-lg"
                                wire:model="newAppointment.start_time">
                            @for ($i = today()->setDateFrom($selectedDay)->hour(8); $i <= today()->setDateFrom($selectedDay)->hour(20); $i->addMinutes(15))
                                <option value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
                            @endfor
                        </select>
                        <p class="block text-center text-sm font-medium text-gray-700">
                            - {{ today()->setTimeFrom($this->newAppointment['start_time'])->addMinutes(60)->isoFormat('HH:mm') }}</p>
                    </div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <select id="location"
                            class="border text-gray-900  border-gray-300 rounded-lg"
                            wire:model="newAppointment.location_id">
                        @foreach ($locations as $location)
                            <option value={{$location->id}}>{{$location->name}} - {{$location->address}}</option>
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
                        wire:click="createAppointment">
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

                    <x-danger-button wire:click="cancelAppointment({{ $appointment }})"
                                     wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-danger-button>
                </div>

            </x-slot>
        </x-dialog-modal>
    </div>
</div>

<script>
    let root = document.querySelector('[drag-root]');

    currentElem = 0;
    root.querySelectorAll('[drag-item]').forEach(el => {
        el.addEventListener('dragstart', e => {
            e.target.setAttribute('dragging', true)
            currentElem = el.getAttribute('drag-item');
        })
        el.addEventListener('drop', e => {
            e.target.classList.remove('bg-pink-500')

            let draggingEl = root.querySelector('[dragging]')

            e.target.before(draggingEl)

            let id2 = e.target.getAttribute('drag-item')

        @this.call('reorder', currentElem, id2)

        })
        el.addEventListener('dragenter', e => {
            e.target.classList.add('bg-pink-500')

            e.preventDefault()
        })

        el.addEventListener('dragover', e => e.preventDefault())

        el.addEventListener('dragleave', e => {
            e.target.classList.remove('bg-pink-500')
        })
        el.addEventListener('dragend', e => {
            e.target.removeAttribute('dragging')
        })
    })
</script>

<style>
    .selected-slot {
        width: calc(100% / 7);
    }

    .selected-slot .client-name-slot {
        margin: 16px 0;
    }

    .selected-slot .appointment-name-slot {
        overflow: hidden;
        max-lines: 2;
    }

    .selected-slot:hover {
        background-color: red;
    }

    .empty-spot, .past-spot {
        width: calc(100% / 7);
        height: 37px;
    }

    .empty-spot p, .past-spot p {
        display: none;
    }


    .empty-spot:hover {
        background-color: rgb(219 39 119 / 0.5);
        color: black;
        cursor: pointer;
    }

    .past-spot:hover {
        background-color: rgb(229 231 235 / 1);
        color: black;
        /*cursor: pointer;*/
    }

    .past-spot:hover p {
        display: block;
        /*cursor: pointer;*/
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
