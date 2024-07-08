<section class="mt-10">
    <h3 class="text-xl font-medium my-2">Book Your Appointment</h3>

    <form wire:submit.prevent="addToCart">
        <div>
            <h4 class="text-lg font-medium text-gray-900">Select Location</h4>

            <fieldset class="mt-4" x-data="{ locations: @entangle('locations')}">
            <div class="grid grid-cols-4 gap-4" x-data="{ selectedLocation : @entangle('selectedLocation') }">
                    @foreach($locations as $location)
                            <label
                                class="group relative flex items-center text-gray-800 justify-center rounded-md border py-3 px-4 font-text-small font-medium uppercase focus:outline-none sm:flex-1 cursor-pointer shadow-sm"
                                x-bind:class="{
                                'primary-color text-white ': selectedLocation === {{ $location->id }},
                                'surface-color bg-lighter-50 bg-opacity-75  hover:bg-darken-35': selectedLocation !== {{ $location->id }}
                            }"
                            >
                                <input type="radio" name="time-slot-choice"
                                       value="{{ $location->id }}" class="sr-only"
                                       x-on:change="selectedLocation = {{ $location->id }}"

                                       aria-labelledby="time-slot-choice-{{ $location->id }}-label">
                                <span id="time-slot-choice-{{ $location->id }}-label">
                                {{ $location->name }}
                            </span>
                                <span class="pointer-events-none absolute -inset-px rounded-md"
                                      aria-hidden="true"></span>
                            </label>

                    @endforeach
                </div>

            </fieldset>
        </div>
        <div>
            <h4 class="text-lg font-medium text-gray-900">Select a date</h4>
            <fieldset>
                <input type="date" class="rounded py-2 px-4 border border-gray-300" wire:model="selectedDate"
                       min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       max="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}" required>

            </fieldset>
        </div>



        <div class="mt-5">
            <h4 class="font-text-small font-medium text-gray-900">Time Slots</h4>
            <fieldset class="mt-4" x-data="{ timeSlots: @entangle('timeSlots')}">
                <legend class="sr-only">Select a time</legend>

                <div class="grid grid-cols-3 gap-4" x-data="{ selectedTimeSlot : @entangle('selectedTimeSlot').defer }">
                    @foreach($timeSlots as $timeSlot)

                        @if($timeSlot->available == true)
                        <label
                            class="group relative flex items-center text-gray-800 justify-center rounded-md border py-3 px-4 font-text-small font-medium uppercase focus:outline-none sm:flex-1 cursor-pointer shadow-sm"
                            x-bind:class="{
                                'primary-color text-white ': selectedTimeSlot === {{ $timeSlot->id }},
                                'surface-color bg-lighter-50 bg-opacity-75 hover:bg-darken-35': selectedTimeSlot !== {{ $timeSlot->id }},
                            }"
                        >
                            <input type="radio" name="time-slot-choice"
                                   value="{{ $timeSlot->id }}" class="sr-only"
                                   x-on:change="selectedTimeSlot = {{ $timeSlot->id }}"

                                   aria-labelledby="time-slot-choice-{{ $timeSlot->id }}-label">
                            <span id="time-slot-choice-{{ $timeSlot->id }}-label">
                                {{ date('g:i a', strtotime($timeSlot->start_time)) }}
                                -
                                {{ date('g:i a', strtotime($timeSlot->end_time)) }}
                            </span>
                            <span class="pointer-events-none absolute -inset-px rounded-md"
                                  aria-hidden="true"></span>
                        </label>
                        @else

                        <label
                            class="group relative flex items-center justify-center rounded-md border py-3 px-4 font-text-small font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 cursor-not-allowed bg-gray-50 text-gray-200">
                            <input type="radio" name="time-slot-choice"
                                   value="{{ $timeSlot->id }}" disabled class="sr-only"
                                   aria-labelledby="size-choice-7-label">
                            <span id="size-choice-7-label">
                                {{ date('g:i a', strtotime($timeSlot->start_time)) }}
                                -
                                {{ date('g:i a', strtotime($timeSlot->end_time)) }}
                            </span>
                            <span aria-hidden="true"
                                   class="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-200">
                                   <svg class="absolute inset-0 h-full w-full stroke-2 text-gray-200" viewBox="0 0 100 100"
                                     preserveAspectRatio="none" stroke="currentColor">
                                    <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke"/>
                                </svg>
                            </span>
                        </label>
                        @endif

                    @endforeach
                </div>
            </fieldset>
        </div>

        <button type="submit"
                class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent primary-color px-8 py-3 text-base font-medium text-white hover:bg-darken-35 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Add to cart
        </button>
    </form>
</section>
