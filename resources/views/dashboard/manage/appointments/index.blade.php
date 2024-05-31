<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Manage Appointments</h2>
    </div>
    <div class="m-4">
        <livewire:manage.appointments :locations="$locations" :masters="$masters" :services="$services"/>
    </div>
</x-dashboard.shell>
