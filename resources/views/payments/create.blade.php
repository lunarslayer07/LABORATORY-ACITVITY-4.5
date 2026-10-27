<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Record payment for {{ $order->order_number }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="mb-4 text-sm text-gray-600">Order total: <span class="font-semibold text-gray-900">${{ number_format((float) $order->total_amount, 2) }}</span></p>

                <form method="POST" action="{{ route('orders.payments.store', $order) }}">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment method</label>
                            <select id="payment_method" name="payment_method" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a method</option>
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                            @error('payment_method') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <input id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">Save payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
