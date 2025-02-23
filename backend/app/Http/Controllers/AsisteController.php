<?php

namespace App\Http\Controllers;

use App\Models\Asiste;
use Illuminate\Http\Request;
use App\Models\UsuarioEstudiante;
use App\Models\Usuario;

class AsisteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $table = Asiste::all();
        return response()->json(($table));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Asiste $asiste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asiste $asiste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asiste $asiste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asiste $asiste)
    {
        //
    }

    /*
     * Obtener clases de un estudiante
    */
    public function getClasesByUsuarioId($id)
{
    // Buscar al usuario
    $usuario = Usuario::findOrFail($id);

    // Obtener el estudiante relacionado
    $estudiante = $usuario->estudiante;

    // Obtener las clases a las que asiste
    $clases = Asiste::where('dni', $estudiante->dni)->with('clase')->get();

    return response()->json($clases);
}

}
