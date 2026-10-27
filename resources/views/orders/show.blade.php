<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order {{ $order->order_number }}</h2>
            <a href="{{ route('orders.payments.create', $order) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">Record payment</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 rounded bg-green-100 p-3 text-sm text-green-700">{{ session('success') }}</div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="rounded border border-gray-200 p-4">
                        <p class="text-xs uppercase text-gray-500">Customer</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $order->customer?->name ?? 'Unknown' }}</p>
                    </div>
                    <div class="rounded border border-gray-200 p-4">
                        <p class="text-xs uppercase text-gray-500">Status</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ ucfirst($order->status) }}</p>
                    </div>
                    <div class="rounded border border-gray-200 p-4">
                        <p class="text-xs uppercase text-gray-500">Total</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">${{ number_format((float) $order->total_amount, 2) }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-3">Items</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Qty</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Unit price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product?->name ?? 'Product removed' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">${{ number_format((float) $item->unit_price, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format((float) $item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mt-8 mb-3">Payments</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Reference</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Method</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($order->payments as $payment)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $payment->payment_reference }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->payment_method }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format((float) $payment->amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->paid_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-sm text-gray-500">No payments recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
