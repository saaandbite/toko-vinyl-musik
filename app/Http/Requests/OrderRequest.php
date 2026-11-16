<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengisi form ini (tanpa auth).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi pesanan.
     * Jumlah minimal 1 (sesuai aturan bisnis). Pengecekan jumlah
     * terhadap stok dilakukan di OrderController karena butuh
     * data produk dan pesanan lama.
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'buyer_name' => ['required', 'string', 'max:100'],
            'buyer_phone' => ['required', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:1'],
            'order_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,paid,shipped'],
        ];
    }

    /**
     * Pesan error berbahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'Piringan hitam wajib dipilih.',
            'product_id.exists' => 'Piringan hitam yang dipilih tidak tersedia.',
            'buyer_name.required' => 'Nama pembeli wajib diisi.',
            'buyer_name.max' => 'Nama pembeli maksimal 100 karakter.',
            'buyer_phone.required' => 'Nomor telepon pembeli wajib diisi.',
            'buyer_phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka bulat.',
            'quantity.min' => 'Jumlah pesanan minimal 1.',
            'order_date.required' => 'Tanggal pesanan wajib diisi.',
            'order_date.date' => 'Tanggal pesanan harus berupa tanggal yang valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus pending, paid, atau shipped.',
        ];
    }
}
