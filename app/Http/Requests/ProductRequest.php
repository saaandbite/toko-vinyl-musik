<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengisi form ini (tanpa auth).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi piringan hitam.
     * Saat update, SKU boleh sama dengan data yang sedang diubah.
     * Harga dan stok tidak boleh negatif (sesuai aturan bisnis).
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:20', Rule::unique('products', 'sku')->ignore($productId)],
            'title' => ['required', 'string', 'max:100'],
            'artist' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Pesan error berbahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Genre wajib dipilih.',
            'category_id.exists' => 'Genre yang dipilih tidak tersedia.',
            'sku.required' => 'SKU wajib diisi.',
            'sku.unique' => 'SKU sudah digunakan.',
            'sku.max' => 'SKU maksimal 20 karakter.',
            'title.required' => 'Judul album wajib diisi.',
            'title.max' => 'Judul album maksimal 100 karakter.',
            'artist.required' => 'Artis wajib diisi.',
            'artist.max' => 'Artis maksimal 100 karakter.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh negatif.',
        ];
    }
}
