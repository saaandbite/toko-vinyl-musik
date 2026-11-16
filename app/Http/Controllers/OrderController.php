<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan beserta piringan hitamnya.
     */
    public function index(): View
    {
        $orders = Order::with('product')->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan form buat pesanan.
     */
    public function create(): View
    {
        $products = Product::orderBy('title')->get();

        return view('orders.create', compact('products'));
    }

    /**
     * Menyimpan pesanan baru.
     * - Jumlah tidak boleh melebihi stok (aturan bisnis).
     * - unit_price diambil dari harga produk saat ini (snapshot),
     *   total_price = unit_price x jumlah.
     * - Stok produk berkurang sejumlah pesanan (dalam transaksi).
     */
    public function store(OrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            return back()
                ->withErrors(['quantity' => 'Jumlah pesanan melebihi stok yang tersedia (' . $product->stock . ').'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $product) {
            $unitPrice = $product->price;

            Order::create([
                ...$validated,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $validated['quantity'],
            ]);

            $product->decrement('stock', $validated['quantity']);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat. Stok berkurang.');
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Order $order): View
    {
        $order->load('product.category');

        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan form ubah pesanan.
     */
    public function edit(Order $order): View
    {
        $products = Product::orderBy('title')->get();

        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Memperbarui pesanan.
     * - Stok pesanan lama dikembalikan dulu, lalu stok dikurangi
     *   sesuai jumlah baru (dalam transaksi).
     * - unit_price dan total_price dihitung ulang dari harga produk
     *   saat ini.
     */
    public function update(OrderRequest $request, Order $order): RedirectResponse
    {
        $validated = $request->validated();
        $product = Product::findOrFail($validated['product_id']);

        $available = $product->stock + ($order->product_id === $product->id ? $order->quantity : 0);

        if ($validated['quantity'] > $available) {
            return back()
                ->withErrors(['quantity' => 'Jumlah pesanan melebihi stok yang tersedia (' . $available . ').'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $product, $order) {
            // Kembalikan stok dari pesanan lama.
            $order->product->increment('stock', $order->quantity);

            $unitPrice = $product->price;

            $order->update([
                ...$validated,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $validated['quantity'],
            ]);

            $product->decrement('stock', $validated['quantity']);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Menghapus pesanan. Stok produk dikembalikan sejumlah
     * pesanan yang dihapus (dalam transaksi).
     */
    public function destroy(Order $order): RedirectResponse
    {
        DB::transaction(function () use ($order) {
            $order->product->increment('stock', $order->quantity);
            $order->delete();
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dihapus. Stok dikembalikan.');
    }
}
