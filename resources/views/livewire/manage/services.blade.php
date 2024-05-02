<div>
    <div class="w-1/3 float-right m-4">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <x-input type="search" wire:model.debounce.500ms="search" id="default-search" name="search"
                     class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                     placeholder="Search Services..."></x-input>
            <x-button.default type="submit" class="text-white absolute right-2.5 bottom-2.5 ">Search</x-button.default>
        </div>
    </div>

    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Service</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Photo</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Notes</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Price</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Category</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Visibility</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($services as $service)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4">{{ $service->id }}</td>

                <td class="gap-3 px-6 py-4 font-medium text-gray-700 text-gray-900">

                    {{ $service->name}}

                </td>
                <td class="px-4 py-4">
                    <div class="w-20 h-20 font-medium text-gray-700">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="" class="w-20 h-20 object-cover">
                    </div>
                </td>

                <td class="px-4 py-4 w-full">{{ $service->notes }}</td>

                <td class="px-4 py-4 ">
                    <div class="font-medium text-center text-gray-700">{{ $service->price }} @if(isset($service->max_price))- {{ $service->max_price }}@endif</div>
                </td>
                <td class="px-4 py-4">
                    {{--                    @dd($service->category->name)--}}
                    <div class="font-medium text-gray-700">{{ $service->category?->name}}</div>
                </td>
                <td class="px-4 py-4 ">
                    <div>

                        @if($service->is_hidden == true)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-600"
                            >
                        <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                        Hidden
                      </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-600"
                            >
                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                        Visible
                        </span>
                        @endif

                    </div>
                </td>
                <td>
                    <div class="mt-5 ">
                        <a href="{{ route('view-service', ['slug' => $service->slug ])  }}">
                            <x-button class="m-2">
                                {{ __('View') }}
                            </x-button>

                        </a>
                        <a href="{{route('manage.services.edit', ['id' =>$service->id])}}">
                        <x-button class="m-2" wire:click="confirmServiceEdit({{ $service->id }})" wire:loading.attr="disabled">
                            {{ __('Edit') }}
                        </x-button>
                        </a>
                        <x-danger-button class="m-2" wire:click="confirmServiceDeletion({{ $service->id }})" wire:loading.attr="disabled">
                            {{ __('Delete') }}
                        </x-danger-button>



                        {{--                        <x-button href="">--}}
                        {{--                            <svg width="20" height="20" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M9.00977 21.39H19.0098C20.0706 21.39 21.0881 20.9685 21.8382 20.2184C22.5883 19.4682 23.0098 18.4509 23.0098 17.39V7.39001C23.0098 6.32915 22.5883 5.31167 21.8382 4.56152C21.0881 3.81138 20.0706 3.39001 19.0098 3.39001H7.00977C5.9489 3.39001 4.93148 3.81138 4.18134 4.56152C3.43119 5.31167 3.00977 6.32915 3.00977 7.39001V12.39" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
                        {{--                                <path d="M1.00977 18.39H11.0098" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
                        {{--                                <path d="M1.00977 15.39H5.00977" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
                        {{--                                <path d="M22.209 5.41992C16.599 16.0599 9.39906 16.0499 3.78906 5.41992" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
                        {{--                                <script xmlns=""/></svg>--}}
                        {{--                        </x-button>--}}
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class=" pl-6 pt-4">
        {{ $services->links() }}
    </div>
</div>
