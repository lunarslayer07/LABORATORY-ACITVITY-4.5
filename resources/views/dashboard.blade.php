<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Café Operations Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4">
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Products</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['products'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Customers</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['customers'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Orders</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['orders'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Payments</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['payments'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Revenue</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format((float) $stats['revenue'], 2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
            </div>

            <div class="mt-8 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Recent orders</h3>
                        <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                            New order
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($recentOrders as $order)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $order->order_number }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $order->customer?->name ?? 'Unknown' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : ($order->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">${{ number_format((float) $order->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-sm text-gray-500">No orders recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
