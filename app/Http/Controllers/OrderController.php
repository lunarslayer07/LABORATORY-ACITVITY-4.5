<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'items.product', 'payments'])->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::where('is_available', true)->orderBy('name')->get();

        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . str_pad((Order::count() + 1), 4, '0', STR_PAD_LEFT);

        $order = null;

        DB::transaction(function () use ($validated, $orderNumber, &$order) {
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'order_number' => $orderNumber,
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                $quantity = (int) $item['quantity'];

                if ($product->stock_quantity < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => 'The product "' . $product->name . '" does not have enough stock available.',
                    ]);
                }

                $unitPrice = (float) $product->price;
                $subtotal = $quantity * $unitPrice;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock_quantity', $quantity);
                $total += $subtotal;
            }

            $order->update(['total_amount' => $total]);
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product', 'payments']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,partial,cancelled'],
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        if ($order->payments()->exists()) {
            return back()->withErrors(['order' => 'This order cannot be deleted because payments have already been recorded.']);
        }

        $order->items()->delete();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
