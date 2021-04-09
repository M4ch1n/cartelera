<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelicula;

class PeliculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pelicula::factory(10)->create();
    }
}
