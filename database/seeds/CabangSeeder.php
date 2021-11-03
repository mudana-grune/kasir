<?php

use App\Cabang;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cabang::create([
            'nama' => 'Cabang Denpasar',
            'alamat' => 'xx',
            'telepon' => '',
            'email' => '',
            'ig'=> ''
        ]);
        Cabang::create([
            'nama' => 'Cabang Singaraja',
            'alamat' => 'xx',
            'telepon' => '',
            'email' => '',
            'ig'=> ''
        ]);
    }
}
