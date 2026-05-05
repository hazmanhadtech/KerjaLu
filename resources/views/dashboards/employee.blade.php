<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Freelancer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-blue-900 mb-6">Available Gigs</h3>

                    <!-- Proximity Search -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-8">
                        <form action="{{ route('dashboard') }}" method="GET" id="search-form">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                                <div>
                                    <x-input-label for="search_mode" :value="__('Search Mode')" />
                                    <select id="search_mode" name="search_mode" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" onchange="toggleLocationInputs()">
                                        <option value="" {{ !$searchMode ? 'selected' : '' }}>Recent (All Locations)</option>
                                        <option value="home" {{ $searchMode === 'home' ? 'selected' : '' }}>Near My Home Address</option>
                                        <option value="current" {{ $searchMode === 'current' ? 'selected' : '' }}>Near My Current Location</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <x-input-label for="radius" :value="__('Distance Radius (km)')" />
                                    <input type="range" id="radius" name="radius" min="1" max="200" value="{{ $radius ?? 50 }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer mt-3 accent-blue-600" oninput="this.nextElementSibling.value = this.value">
                                    <output class="text-sm font-bold text-blue-600 mt-1 block text-center">{{ $radius ?? 50 }} km</output>
                                </div>

                                <div>
                                    <input type="hidden" name="lat" id="current_lat" value="{{ $lat }}">
                                    <input type="hidden" name="lng" id="current_lng" value="{{ $lng }}">
                                    <x-primary-button class="w-full justify-center">
                                        {{ __('Search') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script>
                        function toggleLocationInputs() {
                            const mode = document.getElementById('search_mode').value;
                            if (mode === 'current') {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(function(position) {
                                        document.getElementById('current_lat').value = position.coords.latitude;
                                        document.getElementById('current_lng').value = position.coords.longitude;
                                    }, function(error) {
                                        alert("Error getting current location: " + error.message);
                                        document.getElementById('search_mode').value = '';
                                    });
                                } else {
                                    alert("Geolocation is not supported by this browser.");
                                    document.getElementById('search_mode').value = '';
                                }
                            }
                        }
                    </script>

                    @if($gigs->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <p class="text-blue-700">There are no open gigs right now. Check back later!</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($gigs as $gig)
                                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-t-4 border-t-blue-500">
                                    <h4 class="font-bold text-lg text-gray-800">{{ $gig->title }}</h4>
                                    <div class="flex justify-between items-start mt-1">
                                        <p class="text-sm text-gray-500">Posted by {{ $gig->employer->name ?? 'Unknown' }}</p>
                                        @if(isset($gig->distance))
                                            <span class="text-xs font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
                                                {{ number_format($gig->distance, 1) }} km away
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mt-3">{{ Str::limit($gig->description, 100) }}</p>
                                    <p class="text-xs text-gray-400 mt-1"><i class="fas fa-map-marker-alt mr-1"></i> {{ $gig->address }}</p>
                                    
                                    <div class="mt-4 pt-4 border-t flex justify-between items-center">
                                        <div class="text-2xl font-extrabold text-green-600">${{ number_format($gig->price, 2) }}</div>
                                        <div class="text-sm font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded"><i class="fas fa-clock mr-1"></i> {{ $gig->duration }}</div>
                                    </div>
                                    
                                    <div class="mt-5">
                                        <form action="{{ route('applications.store', $gig->id) }}" method="POST">
                                            @csrf
                                            <textarea name="message" class="w-full border-gray-300 rounded-md shadow-sm text-sm mb-3 focus:border-blue-500 focus:ring-blue-500" rows="2" placeholder="Write a short pitch to the employer (optional)..."></textarea>
                                            <button type="submit" class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                                Apply Now
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
