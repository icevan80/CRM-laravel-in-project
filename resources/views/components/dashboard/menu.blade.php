<div x-data="{ dashboardMenuOpen : screen.width > 640 ? true : false }" id="dashboard-menu" class="dashboard-menu">
    <div @click="dashboardMenuOpen = !dashboardMenuOpen" class="dashboard-menu-drop-button" >Drop</div>
    <div x-show="dashboardMenuOpen" >
        <ul>
            <li>
                <div class="flex flex-row items-center h-8">
                    <div class="px-4 font-light tracking-wide text-gray-500">Menu</div>
                </div>
                <ul>
                    <li>
                        <x-navlink.menu href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <span class="pr-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </span>
                            <p>{{ __('Home page') }}</p>
                        </x-navlink.menu>
                    </li>

                </ul>
            </li>

            <li>
                <div class="flex flex-row items-center h-8">
                    <div class="px-4 font-light tracking-wide text-gray-500">Manage</div>
                </div>
                <x-dashboard.manage.navlinks/>
            </li>

            <li>
                <div class="flex flex-row items-center h-8">
                    <div class="px-4 font-light tracking-wide text-gray-500">Settings</div>
                </div>
                <x-dashboard.settings.navlinks/>
            </li>
        </ul>
    </div>
</div>

<style>
    .dashboard-menu {
        /*max-width: 25%;
        min-width: 10%;*/
        position: relative;
        padding: 8px 0;
        top: 0;
        left: 0;
    }
    .dashboard-menu-drop-button {
        display: none;
        cursor: pointer;
    }
    @media(max-width: 640px) {
        .dashboard-menu-drop-button {
            display: block;
        }
        .dashboard-menu {
            background-color: white;
            max-width: 100%;
            position: fixed;
            margin: 8px;
            top: 64px;
            z-index: 10;
        }
    }


</style>
