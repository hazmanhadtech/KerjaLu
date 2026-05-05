<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-t-blue-600">
                <div class="p-8 text-gray-900">
                    <h3 class="text-2xl font-bold text-blue-900 mb-6">Service Details</h3>
                    
                    <form method="POST" action="{{ route('services.store') }}">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Service Title')" class="font-bold text-gray-700" />
                            <x-text-input id="title" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Professional Logo Design, Lawn Mowing, House Cleaning" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('Description')" class="font-bold text-gray-700" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm bg-gray-50 focus:bg-white transition-colors" rows="6" required placeholder="Describe the service you are offering in detail...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Starting Price ($)')" class="font-bold text-gray-700" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                      <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <x-text-input id="price" class="block w-full pl-7 bg-gray-50 focus:bg-white transition-colors" type="number" step="0.01" min="0" name="price" :value="old('price')" required placeholder="0.00" />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" class="font-bold text-gray-700" />
                                <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm bg-gray-50 focus:bg-white transition-colors">
                                    <option value="">-- Select a Category (Optional) --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-8 border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-4">Service Location</h4>

                        <!-- Location -->
                        <div class="mt-6">
                            <x-input-label for="address" :value="__('Service Area Address')" class="font-bold text-gray-700" />
                            <x-text-input id="address" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors" type="text" name="address" :value="old('address')" required placeholder="Enter the central address where you offer this service" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" class="font-bold text-gray-700" />
                                <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full bg-gray-100" :value="old('latitude')" readonly required />
                            </div>
                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" class="font-bold text-gray-700" />
                                <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full bg-gray-100" :value="old('longitude')" readonly required />
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <button type="button" onclick="getLocation()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                                {{ __('Use My Current Location') }}
                            </button>
                            <p class="text-xs text-gray-500">{{ __('Note: This will set the service area to your current position.') }}</p>
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

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('services.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-900 mr-6 transition-colors">Cancel</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                                {{ __('Offer Service') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
