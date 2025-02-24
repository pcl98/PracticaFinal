<?php

namespace App\Http\Controllers;

use App\Models\ClaseOnline;
use Illuminate\Http\Request;

class ClaseOnlineController extends Controller
{
    /**
     * Muestra todas las clases online
     */
    public function index(Request $request)
    {
        $clasesOnline = ClaseOnline::paginate(10);

        return response()->json($clasesOnline);
    }

    /**
     * Guarda una nueva clase online
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'id' => 'required|integer|exists:clase,id',
            'url_video' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
        ]);

        $claseOnline = ClaseOnline::create($request->all());

        return response()->json($claseOnline, 201);
    }

    /**
     * Muestra una clase online específica
     */
    public function show(ClaseOnline $id)
    {
        return response()->json($id);
    }

    /**
     * Actualiza una clase online
     */
    public function update(Request $request, ClaseOnline $claseOnline)
    {
        $request->validate([
            'url_video' => 'sometimes|string|max:255', 
            'titulo' => 'sometimes|string|max:255', 
        ]);

        $claseOnline->update($request->all());

        return response()->json($claseOnline);
    }

    /**
     * Elimina una clase online
     */
    public function destroy(ClaseOnline $claseOnline)
    {
        $claseOnline->delete();

        return response()->json(['message' => 'Clase online eliminada']);
    }

    /**
     * Búsqueda avanzada de clases online
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1', // Texto de búsqueda
        ]);

        $query = $request->input('query');

        $clasesOnline = ClaseOnline::where('url_video', 'ilike', "%$query%")
            ->orWhere('titulo', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($clasesOnline);
    }

    /**
     * Búsqueda por campos específicos
     */
    public function searchByFields(Request $request)
    {
        $request->validate([
            'id' => 'sometimes|integer',
            'url_video' => 'sometimes|string|max:255',
            'titulo' => 'sometimes|string|max:255',
        ]);

        $query = ClaseOnline::query();

        // Filtros opcionales
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('url_video')) {
            $query->where('url_video', 'ilike', '%' . $request->url_video . '%');
        }

        if ($request->has('titulo')) {
            $query->where('titulo', 'ilike', '%' . $request->titulo . '%');
        }

        $clasesOnline = $query->paginate(10);

        return response()->json($clasesOnline);
    }
}