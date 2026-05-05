<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gig Details: ') }} {{ $gig->title }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">&larr; Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Gig Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-t-4 border-blue-500">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start">
                        <h3 class="text-3xl font-bold text-gray-800">{{ $gig->title }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('gigs.edit', $gig->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded shadow-sm text-sm font-semibold transition">Edit</a>
                            <form action="{{ route('gigs.destroy', $gig->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gig?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-800 px-4 py-2 rounded shadow-sm text-sm font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </div>
                    
                    <p class="mt-6 text-gray-700 text-lg leading-relaxed">{{ $gig->description }}</p>
                    
                    <div class="mt-8 flex gap-6 border-t pt-4">
                        <div class="text-center px-4 border-r">
                            <span class="block text-xs text-gray-500 uppercase tracking-wide">Budget</span>
                            <span class="font-bold text-blue-600 text-xl">${{ number_format($gig->price, 2) }}</span>
                        </div>
                        <div class="text-center px-4 border-r">
                            <span class="block text-xs text-gray-500 uppercase tracking-wide">Duration</span>
                            <span class="font-bold text-gray-700 text-lg">{{ $gig->duration }}</span>
                        </div>
                        <div class="text-center px-4 border-r">
                            <span class="block text-xs text-gray-500 uppercase tracking-wide">Status</span>
                            <span class="inline-block mt-1 px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $gig->status === 'open' ? 'bg-green-100 text-green-800' : ($gig->status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($gig->status) }}
                            </span>
                        </div>
                        <div class="text-center px-4">
                            <span class="block text-xs text-gray-500 uppercase tracking-wide">Applicants</span>
                            <span class="font-bold text-gray-700 text-lg">{{ $gig->applications->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Applications Received</h3>
                    
                    @if($gig->applications->isEmpty())
                        <div class="bg-gray-50 border border-dashed border-gray-300 rounded p-8 text-center">
                            <p class="text-gray-500">No applications have been submitted for this gig yet.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($gig->applications as $app)
                                <div class="border rounded-xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center bg-gray-50 hover:bg-white transition-colors duration-200 shadow-sm">
                                    <div class="mb-4 md:mb-0 w-full md:w-2/3">
                                        <div class="flex items-center space-x-3">
                                            <h4 class="font-bold text-lg text-gray-800">{{ $app->employee->name ?? 'Unknown Employee' }}</h4>
                                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border
                                                {{ $app->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : ($app->status === 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200') }}">
                                                {{ ucfirst($app->status) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mt-2 bg-white p-3 rounded border text-sm italic">"{{ $app->message ?? 'No pitch provided.' }}"</p>
                                        <span class="text-xs text-gray-400 mt-2 block">Applied: {{ $app->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 w-full md:w-auto justify-end">
                                        @if($app->status === 'pending' && $gig->status === 'open')
                                            <form method="POST" action="{{ route('applications.update', $app->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition font-semibold text-sm">Accept Offer</button>
                                            </form>
                                            <form method="POST" action="{{ route('applications.update', $app->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button class="bg-white hover:bg-gray-100 text-red-600 border border-red-200 px-4 py-2 rounded shadow-sm transition font-semibold text-sm">Reject</button>
                                            </form>
                                        @elseif($app->status === 'accepted')
                                            <form method="POST" action="{{ route('applications.update', $app->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition font-semibold text-sm">Mark as Completed</button>
                                            </form>
                                        @elseif($app->status === 'completed')
                                            @php
                                                $isPaid = \App\Models\Payout::where('payable_type', \App\Models\Application::class)->where('payable_id', $app->id)->exists();
                                            @endphp
                                            @if($isPaid)
                                                <span class="text-green-600 font-bold flex items-center bg-green-50 px-3 py-1 rounded-full"><i class="fas fa-check-circle mr-2"></i> Paid</span>
                                            @else
                                                <form method="POST" action="{{ route('payouts.gig', $app->id) }}">
                                                    @csrf
                                                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-lg transition font-bold text-sm">Pay ${{ number_format($gig->price, 2) }}</button>
                                                </form>
                                            @endif
                                        @endif
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
