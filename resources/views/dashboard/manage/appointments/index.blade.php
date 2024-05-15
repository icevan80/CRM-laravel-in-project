<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Manage Appointments</h2>
        <div x-data="{showCreateAppointments: false}">
            <x-button.default x-on:click="showCreateAppointments = true"
                              class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                Create
            </x-button.default>
            <form action="{{route('manage.appointments.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateAppointments">
                    <x-slot name="title">
                        Создание новой записи
                    </x-slot>

                    <x-slot name="content">
                        <h1>ABOBA</h1>
{{--                        <x-forms.create.appointment :locations="$locations" :masters="$masters" :services="$services"/>--}}
                    </x-slot>

                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreateAppointments = false">
                                Отмена
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    {{--    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">--}}
    <div class="m-5">
        <livewire:manage.appointments :locations="$locations" :masters="$masters" :services="$services"/>
{{--        <livewire:manage.appointments />--}}
    </div>
{{--    <livewire:manage-appointments :select-filter="'upcoming'"/>--}}
</x-dashboard.shell>
