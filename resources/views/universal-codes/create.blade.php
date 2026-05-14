<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Universal Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('universal-codes.store') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Creation Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Creation Type') }}
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="creation_type" value="single" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" onchange="toggleBulkCount()">
                                    <span class="ml-2 text-sm text-gray-700">Single Code</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="creation_type" value="bulk" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" onchange="toggleBulkCount()">
                                    <span class="ml-2 text-sm text-gray-700">Bulk Creation</span>
                                </label>
                            </div>
                        </div>

                        <!-- Bulk Count -->
                        <div id="bulk_count_wrapper" class="mb-6" style="display: none;">
                            <label for="bulk_count" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Number of Codes') }}
                            </label>
                            <input
                                type="number"
                                name="bulk_count"
                                id="bulk_count"
                                min="1"
                                max="1000"
                                value="{{ old('bulk_count', 1) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            <p class="mt-1 text-sm text-gray-500">Enter a number between 1 and 1000</p>
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
                                placeholder="Optional notes about this code or batch..."
                            >{{ old('notes') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Optional administrative notes (max 1000 characters)</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('universal-codes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Create Code(s)') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBulkCount() {
            const creationType = document.querySelector('input[name="creation_type"]:checked').value;
            const bulkCountWrapper = document.getElementById('bulk_count_wrapper');

            if (creationType === 'bulk') {
                bulkCountWrapper.style.display = 'block';
            } else {
                bulkCountWrapper.style.display = 'none';
            }
        }
    </script>
</x-app-layout>
