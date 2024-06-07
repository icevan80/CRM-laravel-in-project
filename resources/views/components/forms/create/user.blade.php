<div>
    <div class="col-span-6 sm:col-span-4 my-2">
        <x-inputs.text label="{{ __('Name') }}" id="user_name" type="text" class="w-full" name="user_name">
        </x-inputs.text>
    </div>

    <!-- Email -->
    <div class="col-span-6 sm:col-span-4 my-2">
        <x-inputs.default label="{{ __('Email') }}" id="email" type="email" class="w-full"
                          name="email"></x-inputs.default>
    </div>

    <!-- Phone Number -->
    <div class="col-span-6 sm:col-span-4 my-2">
        <x-inputs.label for="phone_number">{{ __('Phone Number') }}</x-inputs.label>
        <span class="text-xs">eg: 0112121211</span>
        <x-inputs.default id="phone_number" type="text" class="w-full" name="phone_number"></x-inputs.default>
    </div>

    <!-- Password -->
    <div class="col-span-6 sm:col-span-4 my-2">
        <x-inputs.default label="{{ __('Password') }}" id="password" type="password" class="w-full"
                          name="password"></x-inputs.default>
    </div>

    <!-- Confirm Password -->
    <div class="col-span-6 sm:col-span-4 my-2">
        <x-inputs.default label="{{ __('Confirm Password') }}" id="password_confirmation" type="password"
                          class="mt-1 block w-full" name="password_confirmation"></x-inputs.default>
    </div>

    <!-- Role -->
    <div class="col-span-6 sm:col-span-4 my-2">
        <x-inputs.select label="{{ __('Role') }}" name="role_id" id="role_id">
            @foreach($roles as $role)
                <option value="{{$role->id}}">{{ $role->name }}</option>
            @endforeach
        </x-inputs.select>
    </div>
</div>
