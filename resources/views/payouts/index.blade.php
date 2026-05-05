<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($payouts->isEmpty())
                        <p class="text-gray-500 text-center py-4">No payments found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($payouts as $payout)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($payout->user_id === auth()->id())
                                                    <span class="px-2 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">Paid Out</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Received</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                @if($payout->user_id === auth()->id())
                                                    To: {{ $payout->recipient->name }}
                                                @else
                                                    From: {{ $payout->payer->name }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $payout->user_id === auth()->id() ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $payout->user_id === auth()->id() ? '-' : '+' }}${{ number_format($payout->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                                {{ $payout->payable_type === \App\Models\Application::class ? 'Gig' : 'Service' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($payout->payable_type === \App\Models\Application::class)
                                                    {{ $payout->payable->gig->title ?? 'Deleted Gig' }}
                                                @else
                                                    {{ $payout->payable->service->title ?? 'Deleted Service' }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ ucfirst($payout->status) }}
                                                </span>
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
