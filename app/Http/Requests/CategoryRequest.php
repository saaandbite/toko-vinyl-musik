<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengisi form ini (tanpa auth).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi genre.
     * Saat update, nama genre boleh sama dengan data yang sedang diubah.
     */
    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error berbahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama genre wajib diisi.',
            'name.unique' => 'Nama genre sudah digunakan.',
            'name.max' => 'Nama genre maksimal 100 karakter.',
        ];
    }
}
