<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Muestra la vista de invitado
     * @return view Vista de invitado
     */
    public function index()
    {
        return view('guest.guest');
    }
}
