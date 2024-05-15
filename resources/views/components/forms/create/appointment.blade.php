<div>
    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
    <x-input id="name" type="text" wire:model.debounce.500ms="newAppointment.receiving_name"
             class="border text-gray-900  border-gray-300 rounded-lg">
    </x-input>
    <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
    <textarea id="description" wire:model.debounce.500ms="newAppointment.receiving_description"
              class="border text-gray-900  border-gray-300 rounded-lg"></textarea>

    <label for="implementer" class="block text-sm font-medium text-gray-700">{{ __('Implementer') }}</label>
    @if(auth()->user()->hasPermission('edit_other_appointment'))
        <select id="implementer" class="border text-gray-900  border-gray-300 rounded-lg"
                wire:model="newAppointment.implementer_id">
            @foreach ($masters as $master)
                <option value={{$master->id}}>{{$master->user->name}}</option>
            @endforeach
        </select>
    @else
        <p>{{ auth()->user()->name }}</p>
    @endif
    <label for="service" class="block text-sm font-medium text-gray-700">{{ __('Service') }}</label>
    <select id="service" class="border text-gray-900  border-gray-300 rounded-lg"
            wire:model="newAppointment.service_id">
        @foreach ($services as $service)
            <option value={{$service->id}}>{{$service->name}}</option>
        @endforeach
    </select>

    <label for="date" class="block text-sm font-medium text-gray-700">{{ __('Date') }}</label>
    <x-input id="date" type="date" class="border text-gray-900  border-gray-300 rounded-lg"
             wire:model="newAppointment.date"
             min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
             max="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
    </x-input>
    <label for="time" class="block text-sm font-medium text-gray-700">{{ __('Time') }}</label>
    <div class="time-block">
        <select id="time" class="border text-gray-900  border-gray-300 rounded-lg"
                wire:model="newAppointment.start_time">
            @for ($i = today()->hour(8); $i <= today()->hour(20); $i->addMinutes(15))
                @if($i->lessThan(now()))
                    @continue
                @endif
                <option value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
            @endfor
        </select>
        <select id="time" class="border text-gray-900  border-gray-300 rounded-lg"
                wire:model="newAppointment.end_time">
            @for ($i = today()->setDateFrom($this->newAppointment['date'])->setTimeFrom($this->newAppointment['start_time'])->addMinutes(15); $i <= today()->setDateFrom($this->newAppointment['date'])->hour(20); $i->addMinutes(15))
                <option value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
            @endfor
        </select>
    </div>
    <label for="location" class="block text-sm font-medium text-gray-700">{{ __('Location') }}</label>
    <select id="location"
            class="border text-gray-900  border-gray-300 rounded-lg"
            wire:model="newAppointment.location_id">
        @foreach ($locations as $location)
            <option value={{$location->id}}>{{$location->name}} - {{$location->address}}</option>
        @endforeach
    </select>
</div>
