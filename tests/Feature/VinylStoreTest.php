<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VinylStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_dashboard_menampilkan_ringkasaan(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Dashboard');
        $response->assertSee('Rumours');
    }

    public function test_crud_genre(): void
    {
        // Create
        $response = $this->post('/categories', ['name' => 'Funk', 'description' => 'Funk dan soul.']);
        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Funk']);

        // Validasi: nama duplikat ditolak
        $response = $this->post('/categories', ['name' => 'Funk']);
        $response->assertSessionHasErrors('name');

        // Validasi: nama wajib diisi
        $response = $this->post('/categories', ['name' => '']);
        $response->assertSessionHasErrors('name');

        // Update
        $category = Category::where('name', 'Funk')->first();
        $response = $this->put("/categories/{$category->id}", ['name' => 'Funk & Soul', 'description' => 'Funk dan soul.']);
        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Funk & Soul']);

        // Delete: genre berisi produk tidak boleh dihapus
        $rock = Category::where('name', 'Rock')->first();
        $response = $this->delete("/categories/{$rock->id}");
        $response->assertRedirect('/categories');
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['name' => 'Rock']);

        // Delete: genre kosong boleh dihapus
        $response = $this->delete("/categories/{$category->id}");
        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['name' => 'Funk & Soul']);
    }

    public function test_crud_piringan_hitam(): void
    {
        $rock = Category::where('name', 'Rock')->first();

        // Create
        $response = $this->post('/products', [
            'category_id' => $rock->id,
            'sku' => 'VNL-ROCK-099',
            'title' => 'Led Zeppelin IV',
            'artist' => 'Led Zeppelin',
            'price' => 480000,
            'stock' => 5,
        ]);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['sku' => 'VNL-ROCK-099']);

        // Validasi: SKU duplikat ditolak
        $response = $this->post('/products', [
            'category_id' => $rock->id,
            'sku' => 'VNL-ROCK-099',
            'title' => 'Lain',
            'artist' => 'Lain',
            'price' => 100000,
            'stock' => 1,
        ]);
        $response->assertSessionHasErrors('sku');

        // Validasi: harga negatif ditolak
        $response = $this->post('/products', [
            'category_id' => $rock->id,
            'sku' => 'VNL-ROCK-100',
            'title' => 'Lain',
            'artist' => 'Lain',
            'price' => -1000,
            'stock' => 1,
        ]);
        $response->assertSessionHasErrors('price');

        // Update
        $product = Product::where('sku', 'VNL-ROCK-099')->first();
        $response = $this->put("/products/{$product->id}", [
            'category_id' => $rock->id,
            'sku' => 'VNL-ROCK-099',
            'title' => 'Led Zeppelin IV (Remaster)',
            'artist' => 'Led Zeppelin',
            'price' => 490000,
            'stock' => 7,
        ]);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['title' => 'Led Zeppelin IV (Remaster)', 'stock' => 7]);

        // Delete: produk yang sudah punya pesanan tidak boleh dihapus
        $rumours = Product::where('sku', 'VNL-ROCK-001')->first();
        $response = $this->delete("/products/{$rumours->id}");
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('products', ['sku' => 'VNL-ROCK-001']);

        // Delete: produk tanpa pesanan boleh dihapus
        $response = $this->delete("/products/{$product->id}");
        $response->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['sku' => 'VNL-ROCK-099']);
    }

    public function test_pesanan_mengurangi_stok_dan_mengembalikannya_saat_dihapus(): void
    {
        $product = Product::where('sku', 'VNL-ROCK-002')->first(); // stok awal 8
        $stockAwal = $product->stock;

        $response = $this->post('/orders', [
            'product_id' => $product->id,
            'buyer_name' => 'Rina Wijaya',
            'buyer_phone' => '081122334455',
            'quantity' => 2,
            'order_date' => '2026-11-16',
            'status' => 'pending',
        ]);
        $response->assertRedirect('/orders');

        $this->assertDatabaseHas('orders', [
            'buyer_name' => 'Rina Wijaya',
            'quantity' => 2,
            'unit_price' => $product->price,
            'total_price' => $product->price * 2,
        ]);
        $this->assertSame($stockAwal - 2, $product->fresh()->stock);

        // Hapus pesanan: stok kembali
        $order = Order::where('buyer_name', 'Rina Wijaya')->first();
        $response = $this->delete("/orders/{$order->id}");
        $response->assertRedirect('/orders');
        $this->assertSame($stockAwal, $product->fresh()->stock);
    }

    public function test_pesanan_tidak_boleh_melebihi_stok(): void
    {
        $product = Product::where('sku', 'VNL-KLASIK-001')->first(); // stok awal 4

        $response = $this->post('/orders', [
            'product_id' => $product->id,
            'buyer_name' => 'Tono',
            'buyer_phone' => '081100000000',
            'quantity' => 99,
            'order_date' => '2026-11-16',
            'status' => 'pending',
        ]);

        $response->assertSessionHasErrors('quantity');
        $this->assertDatabaseMissing('orders', ['buyer_name' => 'Tono']);
        $this->assertSame(4, $product->fresh()->stock);
    }

    public function test_update_pesanan_menyesuaikan_stok(): void
    {
        $order = Order::where('buyer_name', 'Andi Pratama')->first(); // Rumours, qty 2
        $product = $order->product;
        $stockSebelum = $product->stock; // 10 (12 - 2 dari seeder)

        $response = $this->put("/orders/{$order->id}", [
            'product_id' => $product->id,
            'buyer_name' => 'Andi Pratama',
            'buyer_phone' => '081234567890',
            'quantity' => 3,
            'order_date' => '2026-11-10',
            'status' => 'paid',
        ]);
        $response->assertRedirect('/orders');

        // Stok: 10 + 2 (dikembalikan) - 3 (baru) = 9
        $this->assertSame($stockSebelum - 1, $product->fresh()->stock);
        $this->assertSame(3, $order->fresh()->quantity);
    }
}
