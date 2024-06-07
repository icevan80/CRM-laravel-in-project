<div>
    <x-inputs.text label="{{ __('Name') }}" id="name" type="text"
                   wire:model.debounce.500ms="newAppointment.receiving_name">
    </x-inputs.text>
    <inputs.textarea {{ __('Description') }} id="description"
                     wire:model.debounce.500ms="newAppointment.receiving_description">
    </inputs.textarea>

    <x-inputs.label for="implementer">{{ __('Implementer') }}</x-inputs.label>
    @if(auth()->user()->hasPermission('edit_other_appointment'))
        <x-inputs.select id="implementer"
                         wire:model="newAppointment.implementer_id">
            @foreach ($masters as $master)
                <option value={{$master->id}}>{{$master->user->name}}</option>
            @endforeach
        </x-inputs.select>
    @else
        <p>{{ auth()->user()->name }}</p>
    @endif
    <x-inputs.select id="service"
                     label="{{ __('Service') }}"
                     wire:model="newAppointment.service_id">
        @foreach ($services as $service)
            <option value={{$service->id}}>{{$service->name}}</option>
        @endforeach
    </x-inputs.select>

    <x-inputs.date id="date" type="date"
                   label="{{ __('Date') }}"
                   wire:model="newAppointment.date"
                   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                   max="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
    </x-inputs.date>
    <x-inputs.label for="time">{{ __('Time') }}</x-inputs.label>
    <div class="time-block">
        <x-inputs.select id="time"
                         wire:model="newAppointment.start_time">
            @for ($i = today()->hour(8); $i <= today()->hour(20); $i->addMinutes(15))
                @if($i->lessThan(now()))
                    @continue
                @endif
                <option value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
            @endfor
        </x-inputs.select>
        <x-inputs.select id="time"
                         wire:model="newAppointment.end_time">
            @for ($i = today()->setDateFrom($this->newAppointment['date'])->setTimeFrom($this->newAppointment['start_time'])->addMinutes(15); $i <= today()->setDateFrom($this->newAppointment['date'])->hour(20); $i->addMinutes(15))
                <option value="{{$i->toTimeString()}}">{{$i->isoFormat('HH : mm')}}</option>
            @endfor
        </x-inputs.select>
    </div>
    <x-inputs.select id="location"
                     label="{{ __('Location') }}"
                     wire:model="newAppointment.location_id">
        @foreach ($locations as $location)
            <option value={{$location->id}}>{{$location->name}} - {{$location->address}}</option>
        @endforeach
    </x-inputs.select>
</div>
