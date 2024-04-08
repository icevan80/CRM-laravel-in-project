<x-dashboard.shell>
    <div x-data="{createPermission : false}" style="display: flex; margin: 16px" class="text-left">
        <h1 class="">Менеджер прав</h1>
    </div>
    <livewire:settings.permissions :permissions="$permissions"/>
</x-dashboard.shell>
