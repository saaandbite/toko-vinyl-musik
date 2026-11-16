<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pesanan: mencatat pembelian piringan hitam.
     * Sesuai ERD: id, product_id (FK ke products, restrict),
     * buyer_name (maks 100), buyer_phone (maks 20),
     * quantity (unsigned int), unit_price (decimal 12,2),
     * total_price (decimal 12,2), order_date (date),
     * status (enum pending/paid/shipped, default pending).
     *
     * unit_price menyimpan harga saat pesanan dibuat, sehingga
     * perubahan harga di kemudian hari tidak mengubah riwayat pesanan.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->string('buyer_name', 100);
            $table->string('buyer_phone', 20);
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->date('order_date');
            $table->enum('status', ['pending', 'paid', 'shipped'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
