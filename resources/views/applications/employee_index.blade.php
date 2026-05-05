<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-blue-900">Your Submitted Applications</h3>

                    @if($applications->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <p class="text-blue-700">You haven't applied to any gigs yet. <a href="{{ route('dashboard') }}" class="underline font-bold">Browse available gigs</a></p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gig Title</th>
                                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employer</th>
                                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Budget</th>
                                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $app)
                                        <tr class="hover:bg-gray-50 transition border-b border-gray-100 last:border-0">
                                            <td class="py-4 px-6 font-bold text-gray-800">{{ $app->gig->title }}</td>
                                            <td class="py-4 px-6 text-gray-600">{{ $app->gig->employer->name ?? 'Unknown' }}</td>
                                            <td class="py-4 px-6 font-semibold text-green-600">${{ number_format($app->gig->price, 2) }}</td>
                                            <td class="py-4 px-6">
                                                <span class="px-3 py-1 text-xs font-bold rounded-full border
                                                    {{ $app->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : ($app->status === 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200') }}">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6">
                                                @if($app->status === 'pending')
                                                    <form method="POST" action="{{ route('applications.destroy', $app->id) }}" onsubmit="return confirm('Are you sure you want to cancel this application?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm underline transition">Cancel</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 italic text-sm"><i class="fas fa-lock"></i> Locked</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
