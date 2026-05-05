<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Gig') }}
            </h2>
            <a href="{{ route('gigs.show', $gig->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">&larr; Back to Gig</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-t-blue-600">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('gigs.update', $gig->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Gig Title')" class="font-bold text-gray-700" />
                            <x-text-input id="title" class="block mt-1 w-full bg-gray-50" type="text" name="title" :value="old('title', $gig->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('Description')" class="font-bold text-gray-700" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm bg-gray-50" rows="6" required>{{ old('description', $gig->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Budget ($)')" class="font-bold text-gray-700" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                      <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <x-text-input id="price" class="block w-full pl-7 bg-gray-50" type="number" step="0.01" min="0" name="price" :value="old('price', $gig->price)" required />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Duration -->
                            <div>
                                <x-input-label for="duration" :value="__('Duration')" class="font-bold text-gray-700" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <x-text-input id="duration" class="block w-full pl-9 bg-gray-50" type="text" name="duration" :value="old('duration', $gig->duration)" required />
                                </div>
                                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mt-6">
                            <x-input-label for="category_id" :value="__('Category')" class="font-bold text-gray-700" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm bg-gray-50">
                                <option value="">-- Select a Category (Optional) --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $gig->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div class="mt-6">
                            <x-input-label for="address" :value="__('Job Location Address')" class="font-bold text-gray-700" />
                            <x-text-input id="address" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors" type="text" name="address" :value="old('address', $gig->address)" required placeholder="Enter the address where the work is located" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" class="font-bold text-gray-700" />
                                <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full bg-gray-100" :value="old('latitude', $gig->latitude)" readonly required />
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" class="font-bold text-gray-700" />
                                <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full bg-gray-100" :value="old('longitude', $gig->longitude)" readonly required />
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <button type="button" onclick="getLocation()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update to My Current Location') }}
                            </button>
                            <p class="text-xs text-gray-500">{{ __('Note: This will set the gig coordinates to your current position.') }}</p>
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
                            <a href="{{ route('gigs.show', $gig->id) }}" class="text-sm font-semibold text-gray-500 hover:text-gray-900 mr-6">Cancel</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition">
                                {{ __('Update Gig') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
