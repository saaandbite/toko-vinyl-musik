<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel piringan hitam: katalog album yang dijual.
     * Sesuai ERD: id, category_id (FK ke categories, restrict),
     * sku (unik, maks 20), title (maks 100), artist (maks 100),
     * price (decimal 12,2), stock (unsigned int, default 0).
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('sku', 20)->unique();
            $table->string('title', 100);
            $table->string('artist', 100);
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
