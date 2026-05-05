<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Platform Overview</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.users') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition text-sm">Manage Users</a>
                            <a href="{{ route('admin.gigs') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition text-sm">Manage Gigs</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-5 rounded-r-lg shadow-sm">
                            <h4 class="text-sm font-semibold text-blue-500 uppercase tracking-wider">Total Users</h4>
                            <p class="text-3xl font-extrabold text-blue-900 mt-2">{{ \App\Models\User::count() }}</p>
                        </div>
                        
                        <div class="bg-green-50 border-l-4 border-green-500 p-5 rounded-r-lg shadow-sm">
                            <h4 class="text-sm font-semibold text-green-500 uppercase tracking-wider">Active Gigs</h4>
                            <p class="text-3xl font-extrabold text-green-900 mt-2">{{ \App\Models\Gig::where('status', 'open')->count() }}</p>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-5 rounded-r-lg shadow-sm">
                            <h4 class="text-sm font-semibold text-yellow-500 uppercase tracking-wider">Total Applications</h4>
                            <p class="text-3xl font-extrabold text-yellow-900 mt-2">{{ \App\Models\Application::count() }}</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Recent Users</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                                <tr>
                                    <td class="py-3 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-3 px-4 border-b text-gray-500">{{ $user->email }}</td>
                                    <td class="py-3 px-4 border-b">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'employer' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border-b text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
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
