<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'products' => Product::count(),
            'customers' => Customer::count(),
            'orders' => Order::count(),
            'payments' => Payment::count(),
            'revenue' => Order::sum('total_amount'),
            'pending' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('customer')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentOrders'));
    }
}
