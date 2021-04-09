<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/', 
    [App\Http\Controllers\GuestController::class, 'index']
)->name('welcome');

Route::get('/peliculas/listg',
    [App\Http\Controllers\PeliculaController::class, 'getMoviesGuest']
);

Route::get('/turnos/list',
    [App\Http\Controllers\TurnoController::class, 'getTurnos']
);

Auth::routes();

Route::group(['middleware' => 'auth'], function($router) {
    $router->get(
        '/home', 
        [App\Http\Controllers\HomeController::class, 'index']
    )->name('home');

    // Peliculas
    $router->get(
        '/peliculas', 
        [App\Http\Controllers\PeliculaController::class, 'index']
    )->name('peliculas');
    $router->post(
        '/peliculas/crear',
        [App\Http\Controllers\PeliculaController::class, 'store']
    );
    $router->patch(
        '/peliculas/{peliculaID}/estado',
        [App\Http\Controllers\PeliculaController::class, 'updateEstado']
    );
    $router->delete(
        '/peliculas/{peliculaID}/borrar',
        [App\Http\Controllers\PeliculaController::class, 'delete']
    );
    $router->post(
        '/peliculas/{peliculaID}/actualizar',
        [App\Http\Controllers\PeliculaController::class, 'update']
    );
    $router->post(
        '/peliculas/turnos',
        [App\Http\Controllers\PeliculaController::class, 'asignarHorario']
    );
    Route::get('/peliculas/list',
        [App\Http\Controllers\PeliculaController::class, 'getMovies']
    );

    // Turnos
    $router->get(
        '/turnos', [App\Http\Controllers\TurnoController::class, 'index']
    )->name('turnos');
    $router->post(
        '/turnos/crear',
        [App\Http\Controllers\TurnoController::class, 'store']
    );
    $router->patch(
        '/turnos/{peliculaID}/estado',
        [App\Http\Controllers\TurnoController::class, 'updateEstado']
    );
    $router->delete(
        '/turnos/{peliculaID}/borrar',
        [App\Http\Controllers\TurnoController::class, 'delete']
    );
    $router->post(
        '/turnos/{peliculaID}/actualizar',
        [App\Http\Controllers\TurnoController::class, 'update']
    );
    $router->get(
        '/turnos/all',
        [App\Http\Controllers\TurnoController::class, 'getAll']
    );
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
