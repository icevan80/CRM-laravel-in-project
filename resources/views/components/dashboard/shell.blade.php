<x-app-layout>
    <div style="display: flex; position: relative">
        <div style="max-width: 25%;min-width: 10%; position: relative; top: 0; left: 0">
            <ul>
                <li>
                    <div>Menu</div>
                    <ul>
                        <li>
                            <div>Home page</div>
                        </li>
                    </ul>
                </li>

                <li>
                    <div>Manage</div>
                    <x-dashboard.manage.navlinks/>
                </li>

                <li>
                    <div>Settings</div>
                    <x-dashboard.settings.navlinks/>

                </li>
            </ul>
        </div>
        <div>
            {{ $slot }}
        </div>
    </div>

</x-app-layout>

<style>

</style>
