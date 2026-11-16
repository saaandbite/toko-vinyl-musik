<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar piringan hitam beserta genrenya.
     */
    public function index(): View
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah piringan hitam.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan piringan hitam baru (validasi di ProductRequest).
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Piringan hitam berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail piringan hitam beserta pesanannya.
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'orders']);

        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form ubah piringan hitam.
     */
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui piringan hitam (validasi di ProductRequest).
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Piringan hitam berhasil diperbarui.');
    }

    /**
     * Menghapus piringan hitam. Piringan hitam yang sudah memiliki
     * pesanan tidak dapat dihapus (aturan bisnis + FK restrict).
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->orders()->exists()) {
            return redirect()->route('products.index')
                ->with('error', 'Piringan hitam tidak dapat dihapus karena sudah memiliki pesanan.');
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Piringan hitam berhasil dihapus.');
    }
}
