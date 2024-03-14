<div>
    <div class="flex justify-between mx-7">
        <h2 class="text-2xl font-bold">
            Менеджер записей -
            <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="typeOfView">
                <option value="TableCrmWeek">Неделя</option>
                <option value="TableCrmTodayTomorrow">Сегодня - завтра</option>
                <option value="TableRows">Строки</option>
            </select> -
            <select class="border text-gray-900  border-gray-300 rounded-lg">
                <option value="Select">Салон</option>
                <option value="CurrentMaster">Конкретный мастер</option>
                <option value="SelfAppointment">Мои записи</option>
            </select> -
            <select class="border text-gray-900  border-gray-300 rounded-lg">
                @foreach ($locations as $location)
                    <option value={{$location->id}}>{{$location->name}} - {{$location->address}}</option>
                @endforeach
            </select> -
            <select class="border text-gray-900  border-gray-300 rounded-lg">
                <option value="1">Маша</option>
                <option value="2">Машенька</option>
                <option value="3">Машуля</option>
                <option value="4">Мышенька</option>
                <option value="5">Машка</option>
                <option value="6">Мышьяк</option>
            </select>
        </h2>
    </div>
    <div class="mt-4">
        @if (session()->has('message'))
            <div class="px-4 py-2 text-white bg-green-500 rounded-md">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">
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
                                    @if(\Carbon\Carbon::parse($cellDay['day'])->setTimeFrom($cellMinute['minutes'])->greaterThan(now()))
                                        <th x-data="{ appointHover = false }"
                                            x-on:click="$wire.confirmAppointmentCreate('{{ \Carbon\Carbon::parse($cellDay['day'])->setTimeFrom($cellMinute['minutes']) }}', appointHover)"
                                            scope="col"
                                            class="time-slot text-center font-medium border py-2">
                                            <p class="time-slot-time">{{ \Carbon\Carbon::parse($cellMinute['minutes'])->isoFormat('HH : mm') }}</p>
                                            <div drag-item="{{ $cellMinute['id'] }}"
                                                 class="appointment-container">
                                                @foreach($cellMinute['appointments'] as $appointmentData)
                                                    <div
                                                        x-on:mouseover="appointHover = true"
                                                        x-on:mouseout="appointHover = false"
                                                        drag-item="{{ $appointmentData['data']['appointment_code'] }}"
                                                        draggable="{{ $appointmentData['available'] ? 'true' : 'false' }}"
                                                        x-on:click="$wire.setSelectedAppointment({{ $appointmentData['data'] }})"
                                                        class="appointment-slot text-white {{ $appointmentData['data']['complete'] ? 'bg-green-600' : 'bg-pink-600' }}  font-medium border"
                                                        style="height: calc(102% * {{$appointmentData['range']}})">
                                                        <p class="appointment-slot-info">{{\Carbon\Carbon::parse($appointmentData['data']->start_time)->isoFormat('HH:mm') }}</p>
                                                        <p class="appointment-slot-info">{{ $appointmentData['data']['appointment_code'] }}</p>
                                                        <p class="appointment-slot-info">{{ $appointmentData['data']['receiving_name'] }}</p>
                                                        <p class="appointment-slot-info last">{{\Carbon\Carbon::parse($appointmentData['data']->end_time)->isoFormat('HH:mm') }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </th>
                                    @else
                                        <th
                                            scope="col"
                                            class="past-time-slot text-center font-medium border py-2">
                                            @if(\Carbon\Carbon::parse($cellDay['day'])->setTimeFrom($cellMinute['minutes'])->addMinutes(15)->greaterThan(now()))
                                                <timeline id="time-line" class="time-line"></timeline>
                                            @endif
                                            <p class="time-slot-time">{{ \Carbon\Carbon::parse($cellMinute['minutes'])->isoFormat('HH : mm') }}</p>
                                            <div
                                                class="appointment-container"
                                            >
                                                @foreach($cellMinute['appointments'] as $appointmentData)
                                                    <div
                                                        wire:click="setSelectedAppointment({{ $appointmentData['data'] }})"
                                                        class="appointment-slot past text-white {{ $appointmentData['data']['complete'] ? 'bg-green-600' : 'bg-pink-600' }}  font-medium border"
                                                        style="height: calc(102% * {{$appointmentData['range']}})"
                                                    >
                                                        <p class="appointment-slot-info">{{\Carbon\Carbon::parse($appointmentData['data']->start_time)->isoFormat('HH:mm') }}</p>
                                                        <p class="appointment-slot-info">{{ $appointmentData['data']['appointment_code'] }}</p>
                                                        <p class="appointment-slot-info">{{ $appointmentData['data']['receiving_name'] }}</p>
                                                        <p class="appointment-slot-info last">{{\Carbon\Carbon::parse($appointmentData['data']->end_time)->isoFormat('HH:mm') }}</p>
                                                    </div>


                                                @endforeach
                                            </div>
                                        </th>

                                    @endif
                                    {{--                                    @endif--}}
                                @endif
                            @endforeach
                        @endforeach
                        @if($loop->odd)
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>


        <x-dialog-modal wire:model="confirmingAppointmentSelect">
            <x-slot name="title">
                @if($appointment != null) <h1>{{ $appointment->service->name }}
                    - {{ today()->setTimeFrom($appointment->start_time)->isoFormat('HH:mm') }}</h1>@endif
            </x-slot>
            <x-slot name="content">
                @if($appointment != null)
                    <div>
                        <h2>{{ $appointment->date }}
                            - {{ today()->setTimeFrom($appointment->start_time)->isoFormat('HH:mm') }}</h2>
                        <h2>Создатель: {{ $appointment->creator->name}} - По реферальной
                            ссылке? {{ $appointment->referral ? 'Да' : 'Нет' }} </h2>
                        <h3>Где: {{ $appointment->location->name}} - {{ $appointment->location->address}}</h3>
                        <h3>Кого: {{ $appointment->receiving_name}}</h3>
                        <p>Описание: {{ $appointment->receiving_description}}</p>
                    </div>
                @endif
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    @if ($appointment != null && (auth()->user()->role->name == 'Admin' || auth()->user()->id == $appointment->creator_id))
                        <x-danger-button
                            wire:click="confirmAppointmentDelete({{ $appointment->id }})"
                            wire:loading.attr="disabled">
                            {{ __('Delete') }}
                        </x-danger-button>
                    @endif
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
                    <x-input id="name" type="text" wire:model.debounce.500ms="newAppointment.receiving_name"
                             class="border text-gray-900  border-gray-300 rounded-lg">
                    </x-input>
                    <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                    <textarea id="description" wire:model.debounce.500ms="newAppointment.receiving_description"
                              class="border text-gray-900  border-gray-300 rounded-lg"></textarea>
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

        <x-dialog-modal wire:model="confirmingAppointmentDelete">
            <x-slot name="title">
                {{ __('Delete Appointment') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the appointment?') }}

            </x-slot>

            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-secondary-button wire:click="$set('confirmingAppointmentDelete', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Back') }}
                    </x-secondary-button>

                    <x-danger-button wire:click="deleteAppointment({{ $appointment }})"
                                     wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
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
    let timeLineElement = document.getElementById('time-line');

    function moveLine() {
        let now = new Date();
        let current = now.getMinutes() % 15;
        let unit = 100 / 15;
        let iteration = Math.round(now.getSeconds() / 3);
        let parent = timeLineElement.parentElement;
        timeLineElement.style.top = unit * current + '%';
        let timerId = setInterval(() => {
            if (now.getHours() === 20) {
                clearInterval(timerId);
            }
            if (iteration++ % 20 === 0) {
                current++;
                now.setMinutes(now.getMinutes() + 1)
            }
            if (parent !== timeLineElement.parentElement) {
                parent = timeLineElement.parentElement;
                current = now.getMinutes() % 15;
            }
            timeLineElement.style.top = unit * current + '%';

        }, 3000);

    }

    moveLine();

    let root = document.querySelector('[drag-root]');

    root.querySelectorAll('[drag-item]').forEach(el => {
        el.addEventListener('dragstart', e => {
            e.target.setAttribute('dragging', true)
        })
        el.addEventListener('drop', e => {
            e.target.classList.remove('bg-pink-500')

            let draggingEl = root.querySelector('[dragging]')

            let currentAppointment = draggingEl.getAttribute('drag-item')
            let idForm = draggingEl.parentElement.getAttribute('drag-item');
            let idTo;
            if (e.target.parentElement.tagName === 'DIV') {
                e.target.parentElement.appendChild(draggingEl)
                idTo = e.target.parentElement.getAttribute('drag-item')
            } else {
                e.target.appendChild(draggingEl)
                idTo = e.target.getAttribute('drag-item')
            }

        @this.call('reorder', idForm, idTo, currentAppointment)
        })
        el.addEventListener('dragenter', e => {
            if (e.target.tagName !== 'P') {
                e.target.classList.add('bg-pink-500')
            }

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
    .time-line {
        width: 100%;
        height: 2px;
        top: 0;
        left: 0;
        position: absolute;
        background-color: #2d3748;
        z-index: 10;
    }

    .time-slot, .past-time-slot {
        position: relative;
        height: 37px;
    }

    .time-slot-time {
        display: none;
    }

    .time-slot:hover {
        background-color: #de5c9d;
        z-index: 3;
        cursor: pointer;
    }

    .past-time-slot:hover {
        background-color: #718096;
        z-index: 3;
    }

    .time-slot:hover .time-slot-time, .past-time-slot:hover .time-slot-time {
        display: block;
        color: white;
    }

    .appointment-slot-info {
        display: none;
        overflow: hidden;
        /*left: 30%;*/
    }

    .appointment-slot-info.last {
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .appointment-slot {
        z-index: 1;
        width: 100%;
        top: 0;
        left: 0;
        border-top-left-radius: .750rem;
        border-top-right-radius: .750rem;
        position: relative;
    }

    .appointment-slot:hover {
        min-width: 70%;
        background-color: mediumvioletred;
        cursor: grab;
    }

    .appointment-slot.past:hover {
        min-width: 70%;
        background-color: mediumvioletred;
        cursor: pointer;
    }

    .appointment-slot:hover .appointment-slot-info {
        display: block;
    }

    .appointment-container {
        position: absolute;
        display: flex;
        overflow: paged-x;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        padding-right: 10%;
    }
</style>
