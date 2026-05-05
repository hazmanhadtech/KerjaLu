<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Users') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">&larr; Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-4">All Users</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                    <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="py-3 px-4 border-b">{{ $user->id }}</td>
                                    <td class="py-3 px-4 border-b font-semibold text-gray-800">{{ $user->name }}</td>
                                    <td class="py-3 px-4 border-b text-gray-600">{{ $user->email }}</td>
                                    <td class="py-3 px-4 border-b">
                                        <span class="px-2 py-1 text-xs font-bold rounded-full 
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'employer' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border-b">
                                        @if($user->role !== 'admin')
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-semibold underline">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 italic text-sm">Protected</span>
                                        @endif
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
