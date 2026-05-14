<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Universal Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Code Display -->
                    <div class="mb-6 bg-gray-50 p-4 rounded">
                        <span class="block text-sm font-medium text-gray-500 mb-2">Code</span>
                        <span class="text-2xl font-mono font-bold text-gray-900">{{ $code->code }}</span>
                    </div>

                    <form method="POST" action="{{ route('universal-codes.update', $code) }}">
                        @csrf
                        @method('PATCH')

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Status') }} <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="status"
                                id="status"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="active" {{ old('status', $code->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $code->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="exhausted" {{ old('status', $code->status) === 'exhausted' ? 'selected' : '' }}>Exhausted</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">
                                Active: Can be redeemed | Inactive: Temporarily disabled | Exhausted: All redemptions used
                            </p>
                        </div>

                        <!-- Redemption Info (Read-only) -->
                        <div class="mb-6 bg-blue-50 p-4 rounded">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Redemptions</span>
                                <span class="text-sm font-medium text-gray-900">{{ $code->redemption_count }} / {{ $code->max_redemptions }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full" style="width: {{ ($code->redemption_count / $code->max_redemptions) * 100 }}%"></div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{ $code->remaining_redemptions }} redemptions remaining</p>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Notes') }}
                            </label>
                            <textarea
                                name="notes"
                                id="notes"
                                rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Optional administrative notes..."
                            >{{ old('notes', $code->notes) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Optional administrative notes (max 1000 characters)</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('universal-codes.show', $code) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Code') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
