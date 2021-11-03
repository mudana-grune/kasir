<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    const ADMIN_ROLE = 2;
    const KASIR_ROLE = 1;
    const MANAGER = 3;
    public function run()
    {
        $this->call(CabangSeeder::class);
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'role' => self::ADMIN_ROLE,
            'cabang_id' => 1
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'admin2',
            'password' => Hash::make('12345678'),
            'role' => self::ADMIN_ROLE,
            'cabang_id' => 2
        ]);
        User::create([
            'name' => 'Kasir',
            'username' => 'kasir',
            'password' => Hash::make('12345678'),
            'role' => self::KASIR_ROLE,
            'cabang_id' => 1,
        ]);
        User::create([
            'name' => 'Kasir',
            'username' => 'kasir2',
            'password' => Hash::make('12345678'),
            'role' => self::KASIR_ROLE,
            'cabang_id' => 2,
        ]);
        User::create([
            'name' => 'Manager',
            'username' => 'manager',
            'password' => Hash::make('12345678'),
            'role' => self::MANAGER,
            'cabang_id' => NULL,
        ]);
    }
}
