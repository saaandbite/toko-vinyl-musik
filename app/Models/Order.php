<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /**
     * Atribut yang boleh diisi mass assignment.
     * unit_price dan total_price dihitung controller saat pesanan
     * dibuat/diubah, bukan diisi langsung dari form.
     */
    protected $fillable = [
        'product_id',
        'buyer_name',
        'buyer_phone',
        'quantity',
        'unit_price',
        'total_price',
        'order_date',
        'status',
    ];

    protected $casts = [
        'order_date' => 'date',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Setiap pesanan memuat satu piringan hitam.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
