<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Gigs') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">&larr; Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">All Gigs</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employer</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gigs as $gig)
                                <tr>
                                    <td class="py-3 px-4 border-b">{{ $gig->id }}</td>
                                    <td class="py-3 px-4 border-b font-semibold text-gray-800">{{ $gig->title }}</td>
                                    <td class="py-3 px-4 border-b text-gray-600">{{ $gig->employer->name ?? 'Unknown' }}</td>
                                    <td class="py-3 px-4 border-b">
                                        <span class="px-2 py-1 text-xs font-bold rounded-full 
                                            {{ $gig->status === 'open' ? 'bg-green-100 text-green-800' : ($gig->status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($gig->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border-b flex space-x-2">
                                        <a href="{{ route('gigs.show', $gig->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-semibold underline">View</a>
                                        <form action="{{ route('gigs.destroy', $gig->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gig?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-semibold underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
