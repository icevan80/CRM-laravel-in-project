<ul>
    <li>
        <x-nav-link href="{{ route('manage.appointments') }}" :active="request()->routeIs('manage.appointments')">
            <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24" data-name="Layer 1"
                 id="Layer_1" xmlns="http://www.w3.org/2000/svg"><title/>
                <path
                    d="M18,5V3a1,1,0,0,0-2,0V5H8V3A1,1,0,0,0,6,3V5H2V21H22V5Zm2,14H4V7H20Zm-7-9H11v2h2Zm4,0H15v2h2ZM9,14H7v2H9Zm4,0H11v2h2Z"/>
            </svg>
            <p>{{ __('Appointments') }}</p>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{ route('manage.users') }}" :active="request()->routeIs('manage.users')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <p>{{ __('Users') }}</p>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{ route('manage.locations') }}" :active="request()->routeIs('manage.locations')">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15 14V17.6C15 18.4401 15 18.8601 14.8365 19.181C14.6927 19.4632 14.4632 19.6927 14.181 19.8365C13.8601 20 13.4401 20 12.6 20H7.40001C6.55994 20 6.1399 20 5.81903 19.8365C5.53679 19.6927 5.30731 19.4632 5.1635 19.181C5.00001 18.8601 5.00001 18.4401 5.00001 17.6V10M19 10V20M5.00001 16H15M5.55778 4.88446L3.5789 8.84223C3.38722 9.22559 3.29138 9.41727 3.3144 9.57308C3.3345 9.70914 3.40976 9.8309 3.52246 9.90973C3.65153 10 3.86583 10 4.29444 10H19.7056C20.1342 10 20.3485 10 20.4776 9.90973C20.5903 9.8309 20.6655 9.70914 20.6856 9.57308C20.7086 9.41727 20.6128 9.22559 20.4211 8.84223L18.4422 4.88446C18.2817 4.5634 18.2014 4.40287 18.0817 4.28558C17.9758 4.18187 17.8482 4.10299 17.7081 4.05465C17.5496 4 17.3701 4 17.0112 4H6.98887C6.62991 4 6.45043 4 6.29198 4.05465C6.15185 4.10299 6.02422 4.18187 5.91833 4.28558C5.79858 4.40287 5.71832 4.5634 5.55778 4.88446Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"/>
            </svg>
            <p>{{ __('Locations') }}</p>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{ route('manage.services') }}" :active="request()->routeIs('manage.services')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <p>{{ __('Services') }}</p>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{ route('manage.categories') }}" :active="request()->routeIs('manage.categories')">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <p>{{ __('Categories') }}</p>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{ route('manage.deals') }}" :active="request()->routeIs('manage.deals')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-award" viewBox="0 0 16 16">
                <path
                    d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z"/>
                <path
                    d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
            </svg>
            <p>{{ __('Deals') }}</p>
        </x-nav-link>
    </li>
</ul>
