<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function create(Order $order)
    {
        return view('payments.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $totalPaid = (float) $order->payments()->sum('amount');
        $remainingBalance = (float) $order->total_amount - $totalPaid;

        if ((float) $validated['amount'] > $remainingBalance) {
            throw ValidationException::withMessages([
                'amount' => 'The payment amount cannot exceed the remaining balance of $' . number_format($remainingBalance, 2),
            ]);
        }

        $order->payments()->create([
            'payment_reference' => 'PAY-' . strtoupper(Str::random(8)),
            'payment_method' => $validated['payment_method'],
            'amount' => $validated['amount'],
            'paid_at' => now(),
        ]);

        $newTotalPaid = $totalPaid + (float) $validated['amount'];
        $order->update([
            'status' => $newTotalPaid >= (float) $order->total_amount ? 'paid' : 'partial',
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Payment recorded successfully.');
    }
}
