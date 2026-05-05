<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-blue-900">Your Gig Listings</h3>
                        <a href="{{ route('gigs.create') ?? '#' }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg transition transform hover:-translate-y-1">
                            + Post New Gig
                        </a>
                    </div>

                    @if($myGigs->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <p class="text-blue-700">You haven't posted any gigs yet. Start by posting a gig to hire talented freelancers!</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                            @foreach($myGigs as $gig)
                                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-lg text-gray-800">{{ $gig->title }}</h4>
                                        <span class="bg-{{ $gig->status === 'open' ? 'green' : 'gray' }}-100 text-{{ $gig->status === 'open' ? 'green' : 'gray' }}-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ ucfirst($gig->status) }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-3">{{ Str::limit($gig->description, 80) }}</p>
                                    
                                    <div class="mt-4 pt-4 border-t flex justify-between items-center">
                                        <div class="text-xl font-extrabold text-blue-600">${{ number_format($gig->price, 2) }}</div>
                                        <div class="text-sm text-gray-500"><i class="fas fa-clock"></i> {{ $gig->duration }}</div>
                                    </div>
                                    
                                    <div class="mt-5">
                                        <a href="{{ route('gigs.show', $gig->id) }}" class="w-full block text-center bg-gray-50 hover:bg-gray-100 text-blue-600 border border-gray-200 font-semibold py-2 px-4 rounded transition">
                                            View Applications
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <hr class="my-10 border-gray-200">

                    <h3 class="text-2xl font-bold text-blue-900 mb-6">Browse Freelancer Services</h3>

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
                                        {{ __('Search Services') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($services->isEmpty())
                        <div class="bg-gray-50 border-l-4 border-gray-400 p-4 mb-4">
                            <p class="text-gray-700">No freelancer services found in this area. Try expanding your search radius!</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($services as $service)
                                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-t-4 border-t-indigo-500">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-lg text-gray-800">{{ $service->title }}</h4>
                                        @if(isset($service->distance))
                                            <span class="text-xs font-bold bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">
                                                {{ number_format($service->distance, 1) }} km away
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Offered by {{ $service->employee->name ?? 'Unknown' }}</p>
                                    
                                    <p class="text-sm text-gray-600 mt-3">{{ Str::limit($service->description, 100) }}</p>
                                    <p class="text-xs text-gray-400 mt-1"><i class="fas fa-map-marker-alt mr-1"></i> {{ $service->address }}</p>
                                    
                                    <div class="mt-4 pt-4 border-t flex justify-between items-center">
                                        <div class="text-2xl font-extrabold text-indigo-600">${{ number_format($service->price, 2) }}</div>
                                        <div class="text-sm font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">Starts at</div>
                                    </div>
                                    
                                    <div class="mt-5">
                                        <form action="{{ route('services.book', $service->id) }}" method="POST">
                                            @csrf
                                            <textarea name="message" class="w-full border-gray-300 rounded-md shadow-sm text-sm mb-3 focus:border-indigo-500 focus:ring-indigo-500" rows="2" placeholder="Tell the freelancer about your project..."></textarea>
                                            <button type="submit" class="w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition shadow-md">
                                                Hire Now
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
