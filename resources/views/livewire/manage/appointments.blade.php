<div>
    <div class="mobile-filters">
        <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="viewFilter">
            <option value="table_two_weeks">{{ __('Two weeks') }}</option>
            <option value="table_one_week">{{ __('Week') }}</option>
            <option value="table_today_tomorrow">{{ __('Today - tomorrow') }}</option>
            <option value="rows">{{ __('Rows') }}</option>
        </select>
        @if($this->allowOthers)
            <h2 class="text-2xl font-bold px-4">-</h2>
            <select class="border text-gray-900  border-gray-300 rounded-lg" wire:model="followFilter">
                <option value="salon">{{ __('Salon') }}</option>
                <option value="master">{{ __('Current master') }}</option>
                <option value="self">{{ __('My appointments') }}</option>
                <option value="all">{{ __('Without filters') }}</option>
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
                    <option value="0">{{ __('All masters') }}</option>
                    @foreach ($masters as $master)
                        <option value="{{$master->id}}">{{$master->name}}</option>
                    @endforeach
                </select>
            @endif
        @endif
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md my-4">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
            <thead class="bg-gray-50">
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

    @this.call('reorder', idForm, idTo, currentAppointment)
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
