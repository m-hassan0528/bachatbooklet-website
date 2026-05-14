<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Book Order #') }}{{ $bookOrder->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Customer Information (Read-only) -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Customer Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <p class="text-gray-900">{{ $bookOrder->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <p class="text-gray-900">{{ $bookOrder->phone }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <p class="text-gray-900">{{ $bookOrder->email }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                                <p class="text-gray-900">
                                    {{ $bookOrder->address }}<br>
                                    {{ $bookOrder->city }}, {{ $bookOrder->state }} - {{ $bookOrder->pincode }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                <p class="text-gray-900">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bookOrder->payment_method === 'cod' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ strtoupper($bookOrder->payment_method) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Date</label>
                                <p class="text-gray-900">{{ $bookOrder->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Management Form -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Order Management</h3>

                        <form action="{{ route('book-orders.update', $bookOrder) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Status -->
                            <div class="mb-6">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status *</label>
                                <select id="status" name="status" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('status') border-red-500 @enderror">
                                    <option value="pending" {{ $bookOrder->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $bookOrder->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="shipped" {{ $bookOrder->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $bookOrder->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $bookOrder->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="returned" {{ $bookOrder->status === 'returned' ? 'selected' : '' }}>Returned</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                                <textarea id="notes" name="notes" rows="5"
                                    placeholder="Add any notes about this order (tracking number, issues, special instructions, etc.)"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('notes') border-red-500 @enderror">{{ old('notes', $bookOrder->notes) }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-1">These notes are only visible to admin users.</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between border-t pt-6">
                                <a href="{{ route('book-orders.index') }}" class="text-gray-600 hover:text-gray-900">
                                    ← Back to Orders
                                </a>
                                <div class="flex gap-3">
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
