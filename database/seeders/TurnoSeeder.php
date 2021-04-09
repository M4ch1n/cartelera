<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turno;

class TurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['turno' => '15:00'],
            ['turno' => '16:00'],
            ['turno' => '17:00'],
            ['turno' => '18:00'],
            ['turno' => '19:00'],
            ['turno' => '20:00'],
            ['turno' => '21:00'],
            ['turno' => '22:00'],
        ];
        
        Turno::insert($data);
    }
}
