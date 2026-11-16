<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * Atribut yang boleh diisi mass assignment.
     */
    protected $fillable = ['name', 'description'];

    /**
     * Satu genre memiliki banyak piringan hitam (one-to-many).
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
