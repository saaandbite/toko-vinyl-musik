<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * 10 piringan hitam contoh, tersebar di 6 genre.
     */
    public function run(): void
    {
        $products = [
            ['genre' => 'Rock', 'sku' => 'VNL-ROCK-001', 'title' => 'Rumours', 'artist' => 'Fleetwood Mac', 'price' => 450000, 'stock' => 12],
            ['genre' => 'Rock', 'sku' => 'VNL-ROCK-002', 'title' => 'The Dark Side of the Moon', 'artist' => 'Pink Floyd', 'price' => 525000, 'stock' => 8],
            ['genre' => 'Rock', 'sku' => 'VNL-ROCK-003', 'title' => 'Abbey Road', 'artist' => 'The Beatles', 'price' => 499000, 'stock' => 10],
            ['genre' => 'Jazz', 'sku' => 'VNL-JAZZ-001', 'title' => 'Kind of Blue', 'artist' => 'Miles Davis', 'price' => 475000, 'stock' => 7],
            ['genre' => 'Jazz', 'sku' => 'VNL-JAZZ-002', 'title' => 'A Love Supreme', 'artist' => 'John Coltrane', 'price' => 460000, 'stock' => 5],
            ['genre' => 'Pop', 'sku' => 'VNL-POP-001', 'title' => 'Thriller', 'artist' => 'Michael Jackson', 'price' => 550000, 'stock' => 15],
            ['genre' => 'Pop', 'sku' => 'VNL-POP-002', 'title' => "1989 (Taylor's Version)", 'artist' => 'Taylor Swift', 'price' => 520000, 'stock' => 9],
            ['genre' => 'Hip-Hop dan R&B', 'sku' => 'VNL-HIPHOP-001', 'title' => 'To Pimp a Butterfly', 'artist' => 'Kendrick Lamar', 'price' => 510000, 'stock' => 6],
            ['genre' => 'Klasik', 'sku' => 'VNL-KLASIK-001', 'title' => 'The Four Seasons', 'artist' => 'Antonio Vivaldi', 'price' => 399000, 'stock' => 4],
            ['genre' => 'Musik Indonesia', 'sku' => 'VNL-INDO-001', 'title' => 'Badai Pasti Berlalu', 'artist' => 'Chrisye', 'price' => 425000, 'stock' => 11],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['genre'])->firstOrFail();

            Product::create([
                'category_id' => $category->id,
                'sku' => $item['sku'],
                'title' => $item['title'],
                'artist' => $item['artist'],
                'price' => $item['price'],
                'stock' => $item['stock'],
            ]);
        }
    }
}
