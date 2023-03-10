<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'id' => Str::uuid(),
            'kode_kategori' => Str::random(6),
            'nm_kategori' => 'Jacket',
        ]);
        Category::create([
            'id' => Str::uuid(),
            'kode_kategori' => Str::random(6),
            'nm_kategori' => 'Baju',
        ]);
        Category::create([
            'id' => Str::uuid(),
            'kode_kategori' => Str::random(6),
            'nm_kategori' => 'Celana',
        ]);
    }
}
