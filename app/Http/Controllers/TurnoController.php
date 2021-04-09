<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno;
use Illuminate\Support\Facades\Validator;

class TurnoController extends Controller
{   
    /**
     * Muestra la vista de turnos
     * @return vista Vista de turnos
     */
    public function index()
    {
        return view('turnos');
    }

    /**
     * Obtiene todos los turnos en la base de datos
     * @return response Modelo de turnos
     */
    public function getAll()
    {
        $turnos = Turno::select('id', 'turno')
            ->where('estado', 1)
            ->orderBy('turno')
            ->get();
        
        return response($turnos, 200);
    }

    /**
     * Crea un nuevo registro de turno
     * @param  Request $request Informacion del turno
     * @return response         Turno
     */
    public function store(Request $request)
    {
        $request->validate([
            'time' => 'required|unique:turnos,turno',
        ]);

        $turno = new Turno();
        $turno->turno = $request->input('time');        
        $turno->save();
        
        return response($turno, 200);
    }

    /**
     * Actualiza un registro de turno
     * @param  integer  $id      Identificador del registro
     * @param  Request  $request Informacion del turno
     * @return response          Modelo de turno
     */
    public function update($id, Request $request)
    {        
        $request->validate([
            'time' => "required|unique:turnos,turno,{$id},id,deleted_at,NULL"
        ]);
     
        $turno = Turno::find($id);
        $turno->turno = $request->input('time');
        $turno->save();

        return response($turno, 200);
    }

    /**
     * Obtener turnos de forma paginada
     * @param  integer  $elements Elementos para mostrar
     * @return response           Turnos
     */
    public function getTurnos($elements = 10) {
        $turno = Turno::orderBy('turno')->paginate($elements);

        return response($turno, 200);
    }

    /**
     * Actualizar el estado de un turno
     * @param  integer  $id      Identificador del registro
     * @param  Request  $request Informacion del estado
     * @return response          Turno
     */
    public function updateEstado($id, Request $request)
    {
        $turno = Turno::find($id);
        $turno->estado = $request->input('estado');
        $turno->save();

        return response($turno, 200);
    }

    /**
     * Borrar un turno
     * @param  integer  $id Identificador del registro
     * @return response     Mensaje de confirmacion
     */
    public function delete($id)
    {
        $turno = Turno::find($id);
        $turno->delete();

        return response(['message' => 'Success'], 200);
    }
}
