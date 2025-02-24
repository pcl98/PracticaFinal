<?php

namespace App\Http\Controllers;

use App\Models\ClasePresencial;
use Illuminate\Http\Request;

class ClasePresencialController extends Controller
{
    /**
     * Muestra todas las clases presenciales
     */
    public function index(Request $request)
    {
        $clasesPresenciales = ClasePresencial::paginate(10);

        return response()->json($clasesPresenciales);
    }

    /**
     * Guarda una nueva clase presencial
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:clase,id', // Validación de clave foránea
            'ubicacion' => 'required|string|max:255',
        ]);

        $clasePresencial = ClasePresencial::create($request->all());

        return response()->json($clasePresencial, 201);
    }

    /**
     * Muestra una clase presencial específica
     */
    public function show(ClasePresencial $clasePresencial)
    {
        return response()->json($clasePresencial);
    }

    /**
     * Actualiza una clase presencial
     */
    public function update(Request $request, ClasePresencial $clasePresencial)
    {
        $request->validate([
            'ubicacion' => 'sometimes|string|max:255',
        ]);

        $clasePresencial->update($request->all());

        return response()->json($clasePresencial);
    }

    /**
     * Elimina una clase presencial
     */
    public function destroy(ClasePresencial $clasePresencial)
    {
        $clasePresencial->delete();

        return response()->json(['message' => 'Clase presencial eliminada']);
    }

    /**
     * Búsqueda avanzada de clases presenciales
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1', // Texto de búsqueda
        ]);

        $query = $request->input('query');

        $clasesPresenciales = ClasePresencial::where('ubicacion', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($clasesPresenciales);
    }

    /**
     * Búsqueda por campos específicos.
     */
    public function searchByFields(Request $request)
    {
        $request->validate([
            'id' => 'sometimes|integer',
            'ubicacion' => 'sometimes|string|max:255',
        ]);

        $query = ClasePresencial::query();

        // Filtros opcionales
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('ubicacion')) {
            $query->where('ubicacion', 'ilike', '%' . $request->ubicacion . '%');
        }

        $clasesPresenciales = $query->paginate(10);

        return response()->json($clasesPresenciales);
    }
}