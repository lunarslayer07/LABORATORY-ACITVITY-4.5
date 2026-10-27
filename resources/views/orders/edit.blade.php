<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update order status</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('orders.update', $order) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach (['pending', 'partial', 'paid', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ old('status', $order->status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
