<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Manage Appointments</h2>
    </div>
    {{--    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">--}}
    <div class="m-4">
        <livewire:manage.appointments :locations="$locations" :masters="$masters" :services="$services"/>
{{--        <livewire:manage.appointments />--}}
    </div>
{{--    <livewire:manage-appointments :select-filter="'upcoming'"/>--}}
</x-dashboard.shell>
