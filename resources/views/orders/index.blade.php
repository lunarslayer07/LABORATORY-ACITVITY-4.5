<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Orders</h2>
            <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">New order</a>
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
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Order #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order->order_number }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->customer?->name ?? 'Unknown' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : ($order->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format((float) $order->total_amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('orders.show', $order) }}" class="text-indigo-600">View</a>
                                            <a href="{{ route('orders.edit', $order) }}" class="text-indigo-600">Status</a>
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Delete this order?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-sm text-gray-500">No orders available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
