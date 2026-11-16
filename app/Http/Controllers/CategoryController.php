<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar genre beserta jumlah piringan hitamnya.
     */
    public function index(): View
    {
        $categories = Category::withCount('products')->latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form tambah genre.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Menyimpan genre baru (validasi di CategoryRequest).
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Genre berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail genre beserta daftar piringan hitamnya.
     */
    public function show(Category $category): View
    {
        $category->load('products');

        return view('categories.show', compact('category'));
    }

    /**
     * Menampilkan form ubah genre.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Memperbarui genre (validasi di CategoryRequest).
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Genre berhasil diperbarui.');
    }

    /**
     * Menghapus genre. Genre yang masih memiliki piringan hitam
     * tidak dapat dihapus (aturan bisnis + FK restrict).
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Genre tidak dapat dihapus karena masih memiliki piringan hitam.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Genre berhasil dihapus.');
    }
}
