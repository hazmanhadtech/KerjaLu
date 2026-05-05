<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Offered Services') }}
            </h2>
            <a href="{{ route('services.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                {{ __('Add New Service') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($services->isEmpty())
                        <div class="text-center py-10">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-concierge-bell text-5xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No services yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Start by adding a service you can offer to employers.</p>
                            <div class="mt-6">
                                <a href="{{ route('services.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                    {{ __('Add New Service') }}
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($services as $service)
                                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-all border-t-4 border-t-blue-500">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-lg text-gray-800">{{ $service->title }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mt-3 line-clamp-3">{{ $service->description }}</p>
                                    
                                    <div class="mt-4 pt-4 border-t flex justify-between items-center">
                                        <div class="text-xl font-bold text-blue-600">${{ number_format($service->price, 2) }}</div>
                                        <div class="text-xs text-gray-400"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($service->address, 20) }}</div>
                                    </div>
                                    
                                    <div class="mt-5 flex gap-2">
                                        <a href="{{ route('services.edit', $service->id) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-sm transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2 px-4 rounded text-sm transition">
                                                Delete
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
