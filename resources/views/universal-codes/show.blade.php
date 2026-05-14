<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Universal Code Details') }}
            </h2>
            <a href="{{ route('universal-codes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Code Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Code Information</h3>
                            <div class="flex items-center gap-4">
                                <div class="text-4xl font-mono font-bold text-gray-900 bg-gray-100 px-6 py-3 rounded">
                                    {{ $code->code }}
                                </div>
                                <button onclick="copyToClipboard('{{ $code->code }}')" class="text-sm text-indigo-600 hover:text-indigo-900 cursor-pointer">
                                    Copy
                                </button>
                            </div>
                        </div>
                        <div>
                            @if($code->status === 'active')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @elseif($code->status === 'exhausted')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Exhausted
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Redemption Info -->
                    <div class="mb-6 bg-blue-50 p-4 rounded">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Total Redemptions</span>
                            <span class="text-lg font-bold text-blue-600">{{ $code->total_redemptions }}</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            <strong>Note:</strong> This code can be redeemed <strong>3 times per brand</strong>.
                            @if($code->redemptions->count() > 0)
                                Currently redeemed across {{ $code->redemptions->groupBy('brand_id')->count() }} different brand(s).
                            @else
                                No redemptions yet.
                            @endif
                        </p>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Created At</span>
                            <span class="block text-sm text-gray-900">{{ $code->created_at->format('Y-m-d H:i:s') }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Last Updated</span>
                            <span class="block text-sm text-gray-900">{{ $code->updated_at->format('Y-m-d H:i:s') }}</span>
                        </div>
                    </div>

                    @if($code->notes)
                        <div class="mb-6">
                            <span class="block text-sm font-medium text-gray-500 mb-1">Notes</span>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $code->notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-4">
                        <a href="{{ route('universal-codes.edit', $code) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Edit Code') }}
                        </a>
                        <form action="{{ route('universal-codes.destroy', $code) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this code?')">
                                {{ __('Delete Code') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Redemption History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Redemption History</h3>

                    @if($code->redemptions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Info</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Redeemed By</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Redeemed At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($code->redemptions as $redemption)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $redemption->brand->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $redemption->brand->category }}</div>
                                                <div class="mt-1">
                                                    @php
                                                        $brandRedemptions = $code->getRedemptionsForBrand($redemption->brand_id);
                                                        $remaining = 3 - $brandRedemptions;
                                                    @endphp
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                        {{ $brandRedemptions >= 3 ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                        {{ $brandRedemptions }}/3 used
                                                        @if($remaining > 0)
                                                            ({{ $remaining }} left)
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($redemption->customer_info)
                                                    @if(isset($redemption->customer_info['name']))
                                                        <div class="text-sm text-gray-900">{{ $redemption->customer_info['name'] }}</div>
                                                    @endif
                                                    @if(isset($redemption->customer_info['email']))
                                                        <div class="text-sm text-gray-500">{{ $redemption->customer_info['email'] }}</div>
                                                    @endif
                                                    @if(isset($redemption->customer_info['phone']))
                                                        <div class="text-sm text-gray-500">{{ $redemption->customer_info['phone'] }}</div>
                                                    @endif
                                                @else
                                                    <span class="text-sm text-gray-400">No customer info</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $redemption->redeemed_by ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $redemption->redeemed_at->format('Y-m-d H:i:s') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $redemption->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No redemptions yet for this code.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Code copied to clipboard!');
            }, function(err) {
                alert('Failed to copy code');
            });
        }
    </script>
</x-app-layout>
