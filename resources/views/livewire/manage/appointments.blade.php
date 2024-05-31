<div>
    <div class="mobile-filters">
        <select wire:model="list" class="border text-gray-900  border-gray-300 rounded-lg">
            <option
                value="two_weeks">{{ __('Two weeks') }}</option>
            <option
                value="one_week">{{ __('Week') }}</option>
            <option
                value="today_tomorrow">{{ __('Today - tomorrow') }}</option>
            <option
                value="rows">{{ __('Rows') }}</option>
        </select>
        {{-- TODO: добавить разрешение view_other_appointemnt --}}
        @if(auth()->user()->hasPermission('edit_other_appointment'))
            <h2 class="text-2xl font-bold px-4">-</h2>
            <select wire:model="view" class="border text-gray-900  border-gray-300 rounded-lg">
                <option value="salon">{{ __('Salon') }}</option>
                <option value="master">{{ __('Current master') }}</option>
                <option value="self">{{ __('My appointments') }}</option>
                <option value="all">{{ __('Without filters') }}</option>
            </select>
            @if($view == 'salon' && $locations)
                <h2 class="text-2xl font-bold px-4">-</h2>
                <select wire:model="follow" class="border text-gray-900  border-gray-300 rounded-lg">
                    @foreach ($locations as $location)
                        <option
                            value={{$location->id}}>{{$location->name}} - {{$location->address}}</option>
                    @endforeach
                </select>
            @elseif($view == 'master' && $masters)
                <h2 class="text-2xl font-bold px-4">-</h2>
                <select wire:model="follow" class="border text-gray-900  border-gray-300 rounded-lg">
                    <option value="0">{{ __('All masters') }}</option>
                    @foreach ($masters as $master)
                        <option
                            value="{{$master->id}}">{{$master->user->name}}</option>
                    @endforeach
                </select>
            @endif
        @endif
        <div class="w-full" x-data="{appDataFalse: false}">
            <div style="float:right;">
                <x-button.default
                    wire:click="confirmAppointmentCreate('{{ \Carbon\Carbon::now() }}', '{{ false }}')"
                    class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                    Create
                </x-button.default>
            </div>
        </div>
    </div>
    <div class="w-full rounded-lg border border-gray-200 shadow-md my-4">
        <table class="w-full border bg-white text-left text-sm text-gray-500 min-w-screen">
            <thead class="table-header bg-gray-50">
            <tr>
                <th scope="col" class="w-0 py-4 text-center font-medium text-gray-900 border p-2">
                    <x-input wire:model="selectedDay" type="date"
                             class="mobile-calendar border text-gray-900  border-gray-300 rounded-lg"></x-input>
                </th>
                @foreach($tableCells as $cellDay)
                    <th scope="col"
                        class="{{$cellDay['day'] == $this->dateRange['now']->toDateString() ? 'bg-pink-600 text-white' : 'text-gray-900'}} day-column py-4 text-center font-medium border p-2">{{
                                \Carbon\Carbon::parse($cellDay['day'])->isoFormat('MMM. D') }}
                        <br/>{{ \Carbon\Carbon::parse($cellDay['day'])->isoFormat('ddd') }}
                        @if($cellDay['count_appointments'] != 0)
                            <div class="appointment-notification">{{ $cellDay['count_appointments'] }}</div>
                        @endif
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody drag-root class="bg-gray-50">
            @foreach($tableCells[0]['schedule'] as $minutes)
                @if($loop->odd)
                    <tr>
                        <th scope="col" rowspan="2"
                            class="time-slot-mobile w-0 pl-6 font-medium text-gray-900 border p-2">{{
                                \Carbon\Carbon::parse($minutes['minutes'])->isoFormat('HH : mm') }}</th>
                        @endif
                        @foreach($tableCells as $cellDay)
                            @foreach($cellDay['schedule'] as $cellMinute)
                                @if($cellMinute['minutes'] == $minutes['minutes'])
                                    @if(\Carbon\Carbon::parse($cellDay['day'])->setTimeFrom($cellMinute['minutes'])->greaterThan(now()))
                                        <th x-data="{ appointHover: false }"
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
                                            <div class="appointment-container">
                                                @foreach($cellMinute['appointments'] as $appointmentData)
                                                    <div
                                                        wire:click="setSelectedAppointment({{ $appointmentData['data'] }})"
                                                        class="appointment-slot past text-white {{ $appointmentData['data']['complete'] ? 'bg-green-600' : 'bg-pink-600' }}  font-medium border"
                                                        style="height: calc(102% * {{$appointmentData['range']}})">
                                                        <p class="appointment-slot-info">{{\Carbon\Carbon::parse($appointmentData['data']->start_time)->isoFormat('HH:mm') }}</p>
                                                        <p class="appointment-slot-info">{{ $appointmentData['data']['appointment_code'] }}</p>
                                                        <p class="appointment-slot-info">{{ $appointmentData['data']['receiving_name'] }}</p>
                                                        <p class="appointment-slot-info last">{{\Carbon\Carbon::parse($appointmentData['data']->end_time)->isoFormat('HH:mm') }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </th>
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

        <x-dialog.default wire:model="confirmSelectAppointment" onLeaveMethod="$wire.unsetSelectedAppointment()">
            <x-slot name="title">
                @if($confirmSelectAppointment) <h1>{{ $confirmSelectAppointment->service->name }}
                    - {{ today()->setTimeFrom($confirmSelectAppointment->start_time)->isoFormat('HH:mm') }}</h1>@endif
            </x-slot>
            <x-slot name="content">
                @if($confirmSelectAppointment)
                    <div>
                        <h2>{{ $confirmSelectAppointment->date }}
                            - {{ today()->setTimeFrom($confirmSelectAppointment->start_time)->isoFormat('HH:mm') }}</h2>
                        <h2>Создатель: {{ $confirmSelectAppointment->creator->name}} - По реферальной
                            ссылке? {{ $confirmSelectAppointment->referral ? 'Да' : 'Нет' }} </h2>
                        @if($this->allowOthers && $confirmSelectAppointment->complete == 0)
                            <form
                                action="{{route('manage.appointments.updateImplementer', ['id' => $confirmSelectAppointment->id])}}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <label>
                                    Исполнитель:
                                    <select class="border text-gray-900  border-gray-300 rounded-lg"
                                            name="implementer_id">
                                        @foreach ($masters as $master)
                                            <option
                                                @if($confirmSelectAppointment->implementer_id == $master->user->id)
                                                selected="selected"
                                                @endif
                                                value={{$master->user->id}}>{{$master->user->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-button.default>
                                        Изменить
                                    </x-button.default>
                                </label>
                            </form>
                        @else
                            <h2>Исполнитель: {{ $confirmSelectAppointment->implementer->name}}</h2>
                        @endif
                        <h3>Где: {{ $confirmSelectAppointment->location->name}}
                            - {{ $confirmSelectAppointment->location->address}}</h3>
                        <h3>Кого: {{ $confirmSelectAppointment->receiving_name}}</h3>
                        <p>Описание: {{ $confirmSelectAppointment->receiving_description}}</p>
                    </div>
                @endif
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    @if($confirmSelectAppointment)
                        @if($confirmSelectAppointment && $confirmSelectAppointment->status == true && ($confirmSelectAppointment->implementer_id == auth()->user()->id || $this->allowOthers))
                            <x-button.danger
                                wire:click="confirmAppointmentDelete"
                                wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-button.danger>
                        @endif
                        @if($confirmSelectAppointment && $confirmSelectAppointment->complete == false && ($confirmSelectAppointment->implementer_id == auth()->user()->id || $this->allowOthers))
                            <x-button.default
                                wire:click="confirmAppointmentCancellation"
                                wire:loading.attr="disabled">
                                {{ __('Close') }}
                            </x-button.default>
                        @endif
                        <a href="{{route('manage.appointments.show', $confirmSelectAppointment->id)}}">
                            <x-button.default>
                                {{ __('Show') }}
                            </x-button.default>
                        </a>
                    @endif

                    <x-button.secondary wire:click="unsetSelectedAppointment"
                                        wire:loading.attr="disabled">
                        {{ __('Back') }}
                    </x-button.secondary>
                </div>

            </x-slot>
        </x-dialog.default>

        <form action="{{route('manage.appointments.store')}}" method="POST">
            @csrf
            @method('PUT')
            <x-dialog.default wire:model="confirmingAppointmentCreate">
                <x-slot name="title">
                    {{ __('Create Appointment') }}
                </x-slot>
                <x-slot name="content">

                    @if($confirmingAppointmentCreate)
                        <div class="flex space-x-4">
                            <div class="w-full">
                                <label for="service"
                                       class="block text-sm font-medium text-gray-700">{{ __('Service') }}</label>
                                <select id="service" class="w-full border text-gray-900  border-gray-300 rounded-lg"
                                        name="appointment_service_id"
                                        wire:model="newAppointment.service_id">
                                    @foreach ($services as $service)
                                        <option value={{$service->id}}>{{$service->name}}</option>
                                    @endforeach
                                </select>
                                {{--<div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                    <div style="width: 600px; position: relative">
                                        <x-input class="w-full" id="name" type="text" name="appointment_name"
                                                 wire:focusout="endSearch"
                                                 wire:focusin="startSearch"
                                                 wire:model.debounce.500ms="searchService"></x-input>
                                        @if($this->searchProcess)
                                            <div class="search-result-list">
                                                @foreach($searchedServices as $service)
                                                    <div class="search-result-item">
                                                        <h1 wire:click="changeName('{{$service->name}}')">
                                                            {{$service->name}}
                                                        </h1>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}
                                <label for="description"
                                       class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                                <textarea id="description" name="appointment_description"
                                          class="w-full border text-gray-900  border-gray-300 rounded-lg"></textarea>

                                <label for="implementer"
                                       class="block text-sm font-medium text-gray-700">{{ __('Implementer') }}</label>
                                @if($this->allowOthers)
                                    <select id="implementer" class="w-full border text-gray-900  border-gray-300 rounded-lg"
                                            name="appointment_implementer_id">
                                        @foreach ($masters as $master)
                                            <option value={{$master->user->id}}>{{$master->user->name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <x-input type="hidden" id="implementer" name="appointment_implementer_id"
                                             value="{{auth()->user()->id}}"></x-input>
                                    <p>{{ auth()->user()->name }}</p>
                                @endif

                                <label for="date"
                                       class="block text-sm font-medium text-gray-700">{{ __('Date') }}</label>
                                <x-input id="date" type="date" class="border text-gray-900  border-gray-300 rounded-lg"
                                         value="{{$confirmingAppointmentCreate->format('Y-m-d')}}"
                                         name="appointment_date"
                                         wire:model="newAppointment.date"
                                         min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                         max="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
                                </x-input>
                                <label for="time"
                                       class="block text-sm font-medium text-gray-700">{{ __('Time') }}</label>
                                <div class="time-block">
                                    <select id="time_start" class="border text-gray-900  border-gray-300 rounded-lg"
                                            name="appointment_start_time"
                                            wire:model="newAppointment.start_time">
                                        @for ($i = today()->setDateFrom($newAppointment['date'])->hour(8); $i <= today()->setDateFrom($newAppointment['date'])->hour(20); $i->addMinutes(15))
                                            @if($i->lessThan(now()))
                                                @continue
                                            @endif
                                            <option
                                                value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
                                        @endfor
                                    </select>
                                    <select id="time_end" class="border text-gray-900  border-gray-300 rounded-lg"
                                            name="appointment_end_time">
                                        @for ($i = today()->setDateFrom($newAppointment['date'])->setTimeFrom($newAppointment['start_time'])->addMinutes($this->getSelectedServiceDuration()); $i <= today()->setDateFrom($newAppointment['date'])->hour(20); $i->addMinutes(15))
                                            @if($i->lessThan(now()->addMinutes($this->getSelectedServiceDuration())))
                                                @continue
                                            @endif
                                            <option value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <label for="location"
                                       class="block text-sm font-medium text-gray-700">{{ __('Location') }}</label>
                                <select id="location"
                                        class="w-full border text-gray-900  border-gray-300 rounded-lg"
                                        name="appointment_location_id">
                                    @foreach ($locations as $location)
                                        <option value={{$location->id}}>{{$location->name}}
                                            - {{$location->address}}</option>
                                    @endforeach
                                </select>
                                <x-input type="hidden" id="creator" name="appointment_creator_id"
                                         value="{{auth()->user()->id}}"></x-input>
                                <x-input type="hidden" id="total" name="appointment_total"
                                         value="{{$this->getSelectedServiceTotal()}}"></x-input>
                            </div>
                            <div class="w-full">


                            </div>
                        </div>
                    @endif
                </x-slot>
                <x-slot name="footer">
                    <div class="flex gap-3">
                        <x-button.default
                            type="submit">
                            Create
                        </x-button.default>
                        <x-button.secondary wire:click="$set('confirmingAppointmentCreate', false)"
                                            wire:loading.attr="disabled">
                            {{ __('Back') }}
                        </x-button.secondary>

                    </div>

                </x-slot>
            </x-dialog.default>
        </form>

        <x-dialog.default wire:model="confirmingAppointmentDelete"
                          onLeaveMethod="$wire.unsetSelectedAppointment()">
            <x-slot name="title">
                {{ __('Delete appointment') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the appointment?') }}

            </x-slot>

            <x-slot name="footer">
                <div class="flex gap-3">
                    @if($confirmSelectAppointment)
                        <form
                            action="{{route('manage.appointments.destroy', ['id' => $confirmSelectAppointment->id])}}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <x-button.danger type="submit" wire:click="unsetSelectedAppointment"
                                             wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-button.danger>
                        </form>
                    @endif
                    <x-button.secondary wire:click="unsetSelectedAppointment"
                                        wire:loading.attr="disabled">
                        {{ __('Back') }}
                    </x-button.secondary>
                </div>

            </x-slot>
        </x-dialog.default>

        <x-dialog.default wire:model="confirmingAppointmentCancellation"
                          onLeaveMethod="$wire.unsetSelectedAppointment()">
            <x-slot name="title">
                {{ __('Cancel appointment') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to cancel the appointment?') }}

            </x-slot>

            <x-slot name="footer">
                <div class="flex gap-3">

                    @if($confirmSelectAppointment)
                        <form
                            action="{{route('manage.appointments.cancel', ['id' => $confirmSelectAppointment->id])}}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <x-button.danger type="submit" wire:click="unsetSelectedAppointment"
                                             wire:loading.attr="disabled">
                                {{ __('Close') }}
                            </x-button.danger>
                        </form>
                    @endif
                    <x-button.secondary wire:click="unsetSelectedAppointment"
                                        wire:loading.attr="disabled">
                        {{ __('Back') }}
                    </x-button.secondary>
                </div>

            </x-slot>
        </x-dialog.default>

        <x-dialog.default wire:model="notificationAppointmentSwapped">
            <x-slot name="title">
                {{ __('Creation status') }}
            </x-slot>
            <x-slot name="content">
                <p>{{ __('Appointment was scheduled for another time!') }}</p>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.secondary wire:click="$set('notificationAppointmentSwapped', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Ok') }}
                    </x-button.secondary>
                </div>

            </x-slot>
        </x-dialog.default>

        <x-dialog.default wire:model="notificationAppointmentSwappedError">
            <x-slot name="title">
                {{ __('Creation status') }}
            </x-slot>
            <x-slot name="content">
                <p>{{ __('Appointment has not been moved because the selected time slot is already occupied') }}</p>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.secondary wire:click="$set('notificationAppointmentSwappedError', false)"
                                        wire:loading.attr="disabled">
                        {{ __('Ok') }}
                    </x-button.secondary>
                </div>

            </x-slot>
        </x-dialog.default>
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

    let eventDragStart = e => {
        e.target.setAttribute('dragging', true)
    }
    let eventDrop = e => {
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

        @this.
        call('reorder', idForm, idTo, currentAppointment)
    }
    let eventDragenter = e => {
        if (e.target.tagName !== 'P') {
            e.target.classList.add('bg-pink-500')
        }

        e.preventDefault()
    }
    let eventDragOver = e => e.preventDefault()
    let eventDragLeave = e => {
        e.target.classList.remove('bg-pink-500')
    }
    let eventDragEnd = e => {
        e.target.removeAttribute('dragging')
    }

    function linkDaDEvents(el) {
        el.addEventListener('dragstart', eventDragStart)
        el.addEventListener('drop', eventDrop)
        el.addEventListener('dragenter', eventDragenter)
        el.addEventListener('dragover', eventDragOver)
        el.addEventListener('dragleave', eventDragLeave)
        el.addEventListener('dragend', eventDragEnd)
    }

    function removeDaDEvents(el) {
        el.removeEventListener('dragstart', eventDragStart)
        el.removeEventListener('drop', eventDrop)
        el.removeEventListener('dragenter', eventDragenter)
        el.removeEventListener('dragover', eventDragOver)
        el.removeEventListener('dragleave', eventDragLeave)
        el.removeEventListener('dragend', eventDragEnd)
    }


    root.querySelectorAll('[drag-item]').forEach(el => {
        linkDaDEvents(el);
    });

    document.addEventListener("DOMContentLoaded", () => {
        let needFlushEvents = false;

        Livewire.hook('element.initialized', (el, component) => {
            if (el.hasAttribute('drag-item')) {
                linkDaDEvents(el);
            }
        })

        Livewire.hook('element.updating', (fromEl, toEl, component) => {
            if (fromEl.hasAttribute('drag-item') && !toEl.hasAttribute('drag-item')) {
                needFlushEvents = true;
            }
        })

        Livewire.hook('element.updated', (el, component) => {
            if (el.hasAttribute('drag-item')) {
                linkDaDEvents(el);
            } else if (needFlushEvents) {
                removeDaDEvents(el);
                needFlushEvents = false;
            }
        })
    });
</script>

<style>
    .table-header {
        position: sticky;
        z-index: 11;
        top: 64px;
    }

    .day-column {
        position: relative;
    }

    .appointment-notification {
        position: absolute;
        width: 20px;
        height: 20px;
        top: 10%;
        right: 5%;
        border-radius: 100%;
        background-color: orange;
        color: white;
    }

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

    .mobile-filters {
        display: flex;
    }

    .search-result-list {
        position: absolute;
        width: calc(100% + 2px);
        max-height: 300px;
        overflow-y: scroll;
        overflow-x: hidden;
        background-color: white;
        left: -1px;
        top: 36px;
    }

    .search-result-item {
        cursor: pointer;
        padding: 6px 12px;
    }

    .search-result-item:hover {
        background-color: darkgray;

    }

    @media (max-width: 640px) {
        .mobile-calendar, .mobile-filters {
            display: none;
        }

        .time-slot-mobile {

            writing-mode: vertical-lr;
            text-orientation: mixed;
        }

    }
</style>
