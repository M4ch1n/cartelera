<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Pelicula;

class PeliculaTest extends TestCase
{
    public function test_createPelicula()
    {
        $data = Pelicula::factory(1)->create();

        foreach ($data as $val) {
            $this->assertDatabaseHas('peliculas', [
                'nombre' => $val->nombre,
                'estado' => $val->estado
            ]);
        }        
    }

    public function test_errorCreatePelicula()
    {
        $data = Pelicula::factory()->sinNombre()->make();

        $response = $this->post('/peliculas/crear', [
            'imagen' => $data->imagen
        ]);

        $response->assertStatus(302);
    }
}

    
