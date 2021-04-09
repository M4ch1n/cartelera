<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Pelicula;
use App\Models\Turno;

class PeliculaController extends Controller
{   
    /**
     * Muestra la vista de pelicula
     * @return view Vista de pelicula
     */
    public function index()
    {
        return view('peliculas');
    }

    /**
     * Crea un nuevo registro de pelicula
     * @param  Request  $request Datos de la pelicula
     * @return response          Modelo de la pelicula
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'image' => 'required|file',
        ]);

        $path = Storage::putFile('public', $request->file('image'));

        $pelicula = new Pelicula();
        $pelicula->nombre = $request->input('name');
        $pelicula->imagen = $path;
        $pelicula->save();
        
        return response($pelicula, 200);
    }
    
    /**
     * Actualiza un registro de pelicula
     * @param  integer  $id      Identificador de registro
     * @param  Request  $request Datos de la pelicula
     * @return response          Modelo de la pelicula
     */
    public function update($id, Request $request)
    {        
        if($request->input('imageCheck') == 'true') {            
            $request->validate([
                'name' => 'required|max:50',
                'image' => 'required|file',
            ]);
        } else {            
            $request->validate([
                'name' => 'required|max:50',
            ]);
        }

        $pelicula = Pelicula::find($id);
        $pelicula->nombre = $request->input('name');
        
        if($request->input('imageCheck') == 'true') {
            $path = Storage::putFile('public', $request->file('image'));
            $pelicula->imagen = $path;
        }

        $pelicula->save();

        return response($pelicula, 200);
    }

    /**
     * Obtiene lista de todas las peliculas
     * @param  integer  $elements Cantidad de elementos a desplegar
     * @return response           Peliculas
     */
    public function getMovies($elements = 10) {
        $pelicula = Pelicula::with('turnos')
            ->orderBy('created_at')
            ->paginate($elements);

        return response($pelicula, 200);
    }

    /**
     * Obtiene lista de todas las peliculas que estan activadas
     * @param  integer  $elements Cantidad de elementos a desplegar
     * @return response           Peliculas
     */
    public function getMoviesGuest($elements = 10) {
        $pelicula = Pelicula::with(['turnos' => function($q) {
            $q->where('estado', 1);
        }])
            ->where('estado', 1)
            ->orderBy('created_at')
            ->paginate($elements);

        return response($pelicula, 200);
    }

    /**
     * Actualiza el estado de una pelicula
     * @param  integer  $id      Identificador de registro
     * @param  Request  $request Informacion a actualizar
     * @return response          Registro actualizado
     */
    public function updateEstado($id, Request $request)
    {
        $pelicula = Pelicula::find($id);
        $pelicula->estado = $request->input('estado');
        $pelicula->save();

        return response($pelicula, 200);
    }

    /**
     * Elimina un registro de la base de datos
     * @param  integer  $id Identificador de registro
     * @return response     Mensaje de confirmacion
     */
    public function delete($id)
    {
        $pelicula = Pelicula::find($id);
        $pelicula->delete();

        return response(['message' => 'Success'], 200);
    }

    /**
     * Asigna horarios a las peliculas
     * @param  Request $request Informacion de horarios a actualizar
     * @return array            Modelo de pelicula
     */
    public function asignarHorario(Request $request) {
        $pelicula = Pelicula::find($request->input('id'));
        $array    = explode(',', $request->input('turnos'));
        $turnos   = Turno::whereIn('id', $array)->pluck('id');
        $pelicula->turnos()->sync($turnos);

        return $pelicula;
    }
}
