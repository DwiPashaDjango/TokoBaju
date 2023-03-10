<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Gilang',
            'email' => 'gilang@gmail.com',
            'jk' => 'Laki-laki',
            'password' => Hash::make('12345678'),
        ]);
    }
}
