<?php

namespace Database\Seeders;

use App\Models\Costumer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CostumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Costumer::create([
            'id' => Str::uuid(),
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'alamat' => 'customer@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
