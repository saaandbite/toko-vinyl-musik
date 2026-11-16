<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * 6 genre sesuai dokumen studi kasus.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Rock', 'description' => 'Rock klasik dan modern, dari The Beatles sampai Pink Floyd.'],
            ['name' => 'Jazz', 'description' => 'Jazz legendaris: Miles Davis, John Coltrane, dan kawan-kawan.'],
            ['name' => 'Pop', 'description' => 'Album pop terlaris sepanjang masa.'],
            ['name' => 'Hip-Hop dan R&B', 'description' => 'Hip-hop dan R&B modern.'],
            ['name' => 'Klasik', 'description' => 'Musik klasik: orkestra dan komposer besar.'],
            ['name' => 'Musik Indonesia', 'description' => 'Album musisi Indonesia lintas generasi.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
