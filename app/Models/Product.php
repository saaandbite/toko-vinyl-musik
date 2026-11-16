<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /**
     * Atribut yang boleh diisi mass assignment.
     */
    protected $fillable = ['category_id', 'sku', 'title', 'artist', 'price', 'stock'];

    /**
     * Harga selalu ditampilkan dengan 2 angka desimal.
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Setiap piringan hitam termasuk satu genre.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Satu piringan hitam dapat muncul di banyak pesanan (one-to-many).
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
