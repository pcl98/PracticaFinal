<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;

class ExamenController extends Controller
{
    /**
     * Obtener todos los exámenes (paginados)
     */
    public function index()
    {
        $examenes = Examen::with('clase')->paginate(10);
        return response()->json($examenes);
    }

    /**
     * Crear un nuevo examen
     */
    public function store(Request $request)
    {
        // Validar los datos antes de crear el registro
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'nivel_dificultad' => 'required|numeric',
            'puntuacion' => 'required|numeric',
            'fecha' => 'required|date', 
        ]);

        // Crear el registro
        $examen = Examen::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'nivel_dificultad' => $request->nivel_dificultad,
            'puntuacion' => $request->puntuacion,
            'fecha' => $request->fecha,
        ]);

        return response()->json(['message' => 'Examen creado correctamente', 'examen' => $examen], 201);
    }

    /**
     * Obtener un examen específico por su ID
     */
    public function show(string $id)
    {
        $examen = Examen::find($id);

        if (!$examen) {
            return response()->json(['message' => 'Examen no encontrado'], 404);
        }

        return response()->json($examen);
    }

    /**
     * Actualizar un examen existente
     */
    public function update(Request $request, string $id)
    {
        $examen = Examen::find($id);

        if (!$examen) {
            return response()->json(['message' => 'Examen no encontrado'], 404);
        }

        // Validar los datos antes de actualizar
        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'nivel_dificultad' => 'sometimes|numeric',
            'puntuacion' => 'sometimes|numeric',
            'fecha' => 'sometimes|date',
        ]);

        // Actualizar el registro
        $examen->update([
            'titulo' => $request->titulo ?? $examen->titulo,
            'descripcion' => $request->descripcion ?? $examen->descripcion,
            'nivel_dificultad' => $request->nivel_dificultad ?? $examen->nivel_dificultad,
            'puntuacion' => $request->puntuacion ?? $examen->puntuacion,
            'fecha' => $request->fecha ?? $examen->fecha,
        ]);

        return response()->json(['message' => 'Examen actualizado correctamente', 'examen' => $examen]);
    }

    /**
     * Eliminar un examen
     */
    public function destroy(string $id)
    {
        $examen = Examen::find($id);

        if (!$examen) {
            return response()->json(['message' => 'Examen no encontrado'], 404);
        }

        $examen->delete();

        return response()->json(['message' => 'Examen eliminado correctamente']);
    }

    /**
     * Búsqueda avanzada por campos específicos
     */
    public function searchByFields(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'nivel_dificultad' => 'sometimes|numeric',
            'puntuacion' => 'sometimes|numeric',
            'fecha' => 'sometimes|date',
        ]);

        // Construir la consulta
        $query = Examen::query();

        if ($request->has('titulo')) {
            $query->where('titulo', 'ilike', '%' . $request->titulo . '%');
        }

        if ($request->has('descripcion')) {
            $query->where('descripcion', 'ilike', '%' . $request->descripcion . '%');
        }

        if ($request->has('nivel_dificultad')) {
            $query->where('nivel_dificultad', 'ilike', '%' . $request->nivel_dificultad . '%');
        }

        if ($request->has('puntuacion')) {
            $query->where('puntuacion', $request->puntuacion);
        }

        if ($request->has('fecha')) {
            $query->whereDate('fecha', '=', $request->fecha);
        }

        // Paginar los resultados
        $examenes = $query->paginate(10);

        return response()->json($examenes);
    }

    /**
     * Búsqueda completa en todos los campos
     */
    public function search(Request $request)
    {
        // Validar el parámetro de búsqueda
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query'); // Texto de búsqueda

        // Búsqueda en todos los campos
        $examenes = Examen::where('titulo', 'ilike', "%$query%")
            ->orWhere('descripcion', 'ilike', "%$query%")
            ->orWhere('nivel_dificultad', 'ilike', "%$query%")
            ->orWhere('puntuacion', 'ilike', "%$query%")
            ->orWhereDate('fecha', '=', $request->query('fecha')) 
            ->paginate(10);

        return response()->json($examenes);
    }
}
