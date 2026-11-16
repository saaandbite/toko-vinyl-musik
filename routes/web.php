<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Toko Vinyl Musik
|--------------------------------------------------------------------------
| Dashboard + Resource Controller untuk ketiga modul:
| categories (genre), products (piringan hitam), orders (pesanan).
| Route::resource menghasilkan 7 route standar per modul:
| index, create, store, show, edit, update, destroy.
*/

Route::get('/', function () {
    return view('dashboard', [
        'categoryCount' => Category::count(),
        'productCount' => Product::count(),
        'orderCount' => Order::count(),
        'lowStockProducts' => Product::where('stock', '<=', 5)->orderBy('stock')->get(),
        'latestOrders' => Order::with('product')->latest()->take(5)->get(),
    ]);
})->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
