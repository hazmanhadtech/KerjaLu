<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('I want to')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="employee">Work (Employee)</option>
                <option value="employer">Hire (Employer)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Dual Role Option -->
        <div class="mt-4">
            <label for="can_switch_role" class="inline-flex items-center">
                <input id="can_switch_role" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="can_switch_role" value="1" {{ old('can_switch_role') ? 'checked' : '' }}>
                <span class="ms-2 text-sm text-gray-600">{{ __('I want to be both Employee and Employer') }}</span>
            </label>
            <x-input-error :messages="$errors->get('can_switch_role')" class="mt-2" />
        </div>

        <hr class="my-6 border-gray-200">
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Home Location (For Job Matching)</h3>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Home Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required placeholder="Enter your full home address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Lat/Lng -->
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="latitude" :value="__('Latitude')" />
                <x-text-input id="latitude" class="block mt-1 w-full bg-gray-100" type="text" name="latitude" :value="old('latitude')" readonly required />
            </div>
            <div>
                <x-input-label for="longitude" :value="__('Longitude')" />
                <x-text-input id="longitude" class="block mt-1 w-full bg-gray-100" type="text" name="longitude" :value="old('longitude')" readonly required />
            </div>
        </div>

        <div class="mt-4">
            <button type="button" onclick="getLocation()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Get My Current Location') }}
            </button>
            <p class="text-[10px] text-gray-500 mt-1 italic">{{ __('We use your coordinates to find gigs near you.') }}</p>
        </div>

        <script>
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                    }, function(error) {
                        alert("Error getting location: " + error.message);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }
        </script>

        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-100">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
