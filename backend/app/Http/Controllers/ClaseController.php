<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\ClasePresencial;
use App\Models\ClaseOnline;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    /**
     * Muestra todas las clases.
     */
    public function index()
    {
        $clases = Clase::paginate(10);
        return response()->json($clases);
    }

    /**
     * Guarda una nueva clase.
     */
    public function store(Request $request)
    {
        $request->validate([
            'instrumento' => 'required|string|max:255',
            'dificultad' => 'required|string|max:50',
            'duracion' => 'required|integer',
            'max_alumnos' => 'required|integer',
            'precio' => 'required|numeric',
            'profesor_id' => 'required|integer|exists:usuario,id', // Validación de clave foránea
        ]);

        $clase = Clase::create($request->all());

        return response()->json($clase, 201);
    }

    /**
     * Muestra una clase específica.
     */
    public function show($id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json(['error' => 'Clase no encontrada'], 404);
        }

        return response()->json($clase);
    }

    /**
     * Actualiza una clase.
     */
    public function update(Request $request, $id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json(['error' => 'Clase no encontrada'], 404);
        }

        $request->validate([
            'instrumento' => 'string|max:255',
            'dificultad' => 'string|max:50',
            'duracion' => 'integer',
            'max_alumnos' => 'integer',
            'precio' => 'numeric',
            'profesor_id' => 'integer|exists:usuario,id',
        ]);

        $clase->update($request->all());

        return response()->json($clase);
    }

    /**
     * Elimina una clase.
     */
    public function destroy($id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json(['error' => 'Clase no encontrada'], 404);
        }

        $clase->delete();

        return response()->json(['message' => 'Clase eliminada']);
    }

    // Obtener todas las clases presenciales
    public function getClasesPresenciales()
    {
        $clases = ClasePresencial::all();
        return response()->json($clases);
    }

    // Obtener todas las clases online
    public function getClasesOnline()
    {
        $clases = ClaseOnline::all();
        return response()->json($clases);
    }
}
