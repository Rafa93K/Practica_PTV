<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function mostrarTarifas()
    {
        return view('tarifas.inicio');
    }
}
