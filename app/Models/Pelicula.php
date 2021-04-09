<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelicula extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'peliculas';

    public function turnos()
    {
        return $this->belongsToMany(Turno::class);
    }
}
