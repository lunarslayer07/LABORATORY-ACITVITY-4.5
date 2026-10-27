<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">Add product</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 rounded bg-green-100 p-3 text-sm text-green-700">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $product->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $product->category?->name ?? 'Unassigned' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format((float) $product->price, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $product->stock_quantity }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->is_available ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600">Edit</a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-sm text-gray-500">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
