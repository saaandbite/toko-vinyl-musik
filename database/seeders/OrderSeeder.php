<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * 4 pesanan contoh. Stok produk dikurangi sesuai jumlah pesanan,
     * sama seperti yang dilakukan OrderController saat pesanan dibuat.
     */
    public function run(): void
    {
        $orders = [
            ['sku' => 'VNL-ROCK-001', 'buyer_name' => 'Andi Pratama', 'buyer_phone' => '081234567890', 'quantity' => 2, 'order_date' => '2026-11-10', 'status' => 'paid'],
            ['sku' => 'VNL-POP-001', 'buyer_name' => 'Sinta Maharani', 'buyer_phone' => '085678901234', 'quantity' => 1, 'order_date' => '2026-11-12', 'status' => 'shipped'],
            ['sku' => 'VNL-JAZZ-001', 'buyer_name' => 'Budi Santoso', 'buyer_phone' => '081987654321', 'quantity' => 1, 'order_date' => '2026-11-14', 'status' => 'pending'],
            ['sku' => 'VNL-INDO-001', 'buyer_name' => 'Dewi Lestari', 'buyer_phone' => '082112345678', 'quantity' => 3, 'order_date' => '2026-11-15', 'status' => 'paid'],
        ];

        foreach ($orders as $item) {
            DB::transaction(function () use ($item) {
                $product = Product::where('sku', $item['sku'])->firstOrFail();

                Order::create([
                    'product_id' => $product->id,
                    'buyer_name' => $item['buyer_name'],
                    'buyer_phone' => $item['buyer_phone'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $item['quantity'],
                    'order_date' => $item['order_date'],
                    'status' => $item['status'],
                ]);

                $product->decrement('stock', $item['quantity']);
            });
        }
    }
}
