<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create order</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                        <select id="customer_id" name="customer_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Order items</h3>
                        <button type="button" id="add-item" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700">Add item</button>
                    </div>

                    <div id="items-container" class="space-y-4">
                        <div class="item-row grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Product</label>
                                <select name="items[0][product_id]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Choose a product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (${{ number_format((float) $product->price, 2) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="items[0][quantity]" min="1" value="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>

                    @error('items') <p class="mt-3 text-sm text-red-600">{{ $message }}</p> @enderror

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">Create order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 1;
        document.getElementById('add-item').addEventListener('click', function () {
            const container = document.getElementById('items-container');
            const row = document.createElement('div');
            row.className = 'item-row grid grid-cols-1 md:grid-cols-2 gap-4';
            row.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product</label>
                    <select name="items[${itemIndex}][product_id]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Choose a product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (${{ number_format((float) $product->price, 2) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="items[${itemIndex}][quantity]" min="1" value="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            `;
            container.appendChild(row);
            itemIndex += 1;
        });
    </script>
</x-app-layout>
