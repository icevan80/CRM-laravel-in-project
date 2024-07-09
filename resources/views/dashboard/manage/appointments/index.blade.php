<x-dashboard.shell>
    <div class="flex justify-between mx-2 pt-2">
        <h2 class="font-text-normal font-bold">Manage Appointments</h2>
    </div>
    <div class="m-2">
        <livewire:manage.appointments :locations="$locations" :masters="$masters" :services="$services"/>
    </div>
</x-dashboard.shell>
