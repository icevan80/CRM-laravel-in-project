<x-dashboard.shell> <div>
        <h1>
    Тут могла быть ваша запись
        </h1>
        <div>
            <h2>{{ $appointment->date }}
                - {{ today()->setTimeFrom($appointment->start_time)->isoFormat('HH:mm') }}</h2>
            <h2>Создатель: {{ $appointment->creator->name}} - По реферальной
                ссылке? {{ $appointment->referral ? 'Да' : 'Нет' }} </h2>
            @if(auth()->user()->hasPermission('edit_other_appointment') && $appointment->complete == 0)
                <form
                    action="{{route('manage.appointments.updateImplementer', ['id' => $appointment->id])}}"
                    method="post">
                    @csrf
                    @method('PUT')

                        <x-inputs.select label="Исполнитель:"
                                name="implementer_id">
                            @foreach ($masters as $master)
                                <option
                                    @if($appointment->implementer_id == $master->user->id)
                                    selected="selected"
                                    @endif
                                    value={{$master->user->id}}>{{$master->user->name}}</option>
                            @endforeach
                        </x-inputs.select>
                        <x-button.default>
                            Изменить
                        </x-button.default>
                </form>
            @else
                <h2>Исполнитель: {{ $appointment->implementer->name}}</h2>
            @endif
            <h3>Где: {{ $appointment->location->name}}
                - {{ $appointment->location->address}}</h3>
            <h3>Кого: {{ $appointment->receiving_name}}</h3>
            <p>Описание: {{ $appointment->receiving_description}}</p>
        </div>
</div>
</x-dashboard.shell>
