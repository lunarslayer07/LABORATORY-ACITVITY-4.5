<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        $staff = User::create([
            'name' => 'Cafe Manager',
            'email' => 'staff@cafebistro.test',
            'password' => Hash::make('password123'),
        ]);

        $coffee = Category::create([
            'name' => 'Coffee',
            'description' => 'Hot and cold coffee favourites',
        ]);

        $tea = Category::create([
            'name' => 'Tea',
            'description' => 'Herbal and classic teas',
        ]);

        $desserts = Category::create([
            'name' => 'Desserts',
            'description' => 'Sweet treats and pastries',
        ]);

        $espresso = Product::create([
            'category_id' => $coffee->id,
            'name' => 'Espresso',
            'description' => 'Double shot espresso',
            'price' => 3.50,
            'stock_quantity' => 25,
            'is_available' => true,
        ]);

        $latte = Product::create([
            'category_id' => $coffee->id,
            'name' => 'Cappuccino',
            'description' => 'Creamy cappuccino with chocolate dust',
            'price' => 5.75,
            'stock_quantity' => 18,
            'is_available' => true,
        ]);

        $coldBrew = Product::create([
            'category_id' => $coffee->id,
            'name' => 'Cold Brew',
            'description' => 'Refreshing cold brew coffee',
            'price' => 4.90,
            'stock_quantity' => 20,
            'is_available' => true,
        ]);

        $greenTea = Product::create([
            'category_id' => $tea->id,
            'name' => 'Green Tea',
            'description' => 'Light botanical tea',
            'price' => 3.25,
            'stock_quantity' => 30,
            'is_available' => true,
        ]);

        $chai = Product::create([
            'category_id' => $tea->id,
            'name' => 'Chai Latte',
            'description' => 'Smooth spiced chai latte',
            'price' => 4.50,
            'stock_quantity' => 22,
            'is_available' => true,
        ]);

        $brownie = Product::create([
            'category_id' => $desserts->id,
            'name' => 'Chocolate Brownie',
            'description' => 'Rich and fudgy brownie',
            'price' => 6.00,
            'stock_quantity' => 16,
            'is_available' => true,
        ]);

        $customers = [
            Customer::create(['name' => 'Alice Morgan', 'email' => 'alice@example.com', 'phone' => '0712345678', 'address' => '12 Berry Road']),
            Customer::create(['name' => 'Brian Smith', 'email' => 'brian@example.com', 'phone' => '0723456789', 'address' => '45 Oak Street']),
            Customer::create(['name' => 'Chloe White', 'email' => 'chloe@example.com', 'phone' => '0734567890', 'address' => '9 River Lane']),
        ];

        $orders = [
            ['customer_id' => $customers[0]->id, 'order_number' => 'ORD-20261027-1001', 'status' => 'paid', 'total_amount' => 0],
            ['customer_id' => $customers[1]->id, 'order_number' => 'ORD-20261027-1002', 'status' => 'partial', 'total_amount' => 0],
            ['customer_id' => $customers[2]->id, 'order_number' => 'ORD-20261027-1003', 'status' => 'paid', 'total_amount' => 0],
        ];

        foreach ($orders as $orderData) {
            $order = Order::create($orderData);
            $items = [];

            if ($order->order_number === 'ORD-20261027-1001') {
                $items = [
                    ['product_id' => $espresso->id, 'quantity' => 2],
                    ['product_id' => $brownie->id, 'quantity' => 1],
                ];
            } elseif ($order->order_number === 'ORD-20261027-1002') {
                $items = [
                    ['product_id' => $latte->id, 'quantity' => 2],
                    ['product_id' => $greenTea->id, 'quantity' => 1],
                ];
            } else {
                $items = [
                    ['product_id' => $coldBrew->id, 'quantity' => 1],
                    ['product_id' => $chai->id, 'quantity' => 2],
                ];
            }

            $total = 0;

            foreach ($items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $quantity = $itemData['quantity'];
                $subtotal = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total_amount' => $total]);
        }

        $orderOne = Order::where('order_number', 'ORD-20261027-1001')->first();
        $orderTwo = Order::where('order_number', 'ORD-20261027-1002')->first();

        Payment::create([
            'order_id' => $orderOne->id,
            'payment_reference' => 'PAY-ALICE-1001',
            'payment_method' => 'Card',
            'amount' => 13.50,
            'paid_at' => now(),
        ]);

        Payment::create([
            'order_id' => $orderTwo->id,
            'payment_reference' => 'PAY-BRIAN-1002',
            'payment_method' => 'Cash',
            'amount' => 8.50,
            'paid_at' => now(),
        ]);

        Payment::create([
            'order_id' => $orderOne->id,
            'payment_reference' => 'PAY-ALICE-1003',
            'payment_method' => 'Bank Transfer',
            'amount' => 2.00,
            'paid_at' => now(),
        ]);

        $orderOne->update(['status' => 'paid']);
        $orderTwo->update(['status' => 'partial']);
    }
}
