<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Valora;
use App\Models\Clase;

class ValoraController extends Controller
{
    /**
     * Devolver todas las valoraciones
     */
    public function index()
    {
        $valoraciones = Valora::with(['estudiante', 'clase'])->paginate(15);
        return response()->json($valoraciones);
    }

    /**
     * Crear una nueva valoración
     */
    public function store(Request $request)
    {
        // Validar datos antes del registro
        $request->validate([
            'dni' => 'required|exists:usuario_estudiante,dni',
            'id_clase' => 'required|exists:clase,id',
            'comentario' => 'nullable|string',
            'fecha_valoracion' => 'required|date',
            'calificacion' => 'required|numeric|min:1|max:5',
        ]);

        $valoracion = Valora::create($request->all());

        return response()->json(['message' => 'Valoración creada correctamente', 'valoracion' => $valoracion], 201);
    }

    /**
     * Actualizar una valoración existente
     */
    public function update(Request $request, $dni, $id_clase)
    {
        // Buscar el registro por dni e id_clase
        $valoracion = Valora::where('dni', $dni)
            ->where('id_clase', $id_clase)
            ->first();

        if (!$valoracion) {
            return response()->json(['message' => 'Valoración no encontrada'], 404);
        }

        $request->validate([
            'dni' => 'sometimes|exists:usuario_estudiante,dni',
            'id_clase' => 'sometimes|exists:clase,id',
            'comentario' => 'nullable|string',
            'fecha_valoracion' => 'sometimes|date',
            'calificacion' => 'sometimes|numeric|min:1|max:5',
        ]);

        $valoracion->update($request->all());

        return response()->json(['message' => 'Valoración actualizada correctamente', 'valoracion' => $valoracion]);
    }

    /**
     * Eliminar una valoración
     */
    public function destroy($dni, $id_clase)
    {
        // Buscar el registro por dni e id_clase
        $valoracion = Valora::where('dni', $dni)
            ->where('id_clase', $id_clase)
            ->first();

        if (!$valoracion) {
            return response()->json(['message' => 'Valoración no encontrada'], 404);
        }

        $valoracion->delete();

        return response()->json(['message' => 'Valoración eliminada correctamente']);
    }

    /**
     * Búsqueda por campos específicos
     */
    public function searchByFields(Request $request)
    {
        $request->validate([
            'dni' => 'sometimes|exists:usuario_estudiante,dni',
            'id_clase' => 'sometimes|exists:clase,id',
            'comentario' => 'nullable|string',
            'fecha_valoracion' => 'sometimes|date',
            'calificacion' => 'sometimes|numeric|min:1|max:5',
        ]);

        $query = Valora::query();

        if ($request->has('dni')) {
            $query->where('dni', $request->dni);
        }

        if ($request->has('id_clase')) {
            $query->where('id_clase', $request->id_clase);
        }

        if ($request->has('comentario')) {
            $query->where('comentario', 'ilike', '%' . $request->comentario . '%');
        }

        if ($request->has('fecha_valoracion')) {
            $query->where('fecha_valoracion', $request->fecha_valoracion);
        }

        if ($request->has('calificacion')) {
            $query->where('calificacion', $request->calificacion);
        }

        $valoraciones = $query->with(['estudiante', 'clase'])->paginate(10);

        return response()->json($valoraciones);
    }

    /**
     * Búsqueda completa en todos los campos
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1', // Texto de búsqueda
        ]);

        $query = $request->input('query'); // Texto de búsqueda

        // Búsqueda en todos los campos
        $valoraciones = Valora::where('dni', 'ilike', "%$query%")
            ->orWhere('id_clase', 'ilike', "%$query%")
            ->orWhere('comentario', 'ilike', "%$query%")
            ->orWhere('fecha_valoracion', 'ilike', "%$query%")
            ->orWhere('calificacion', 'ilike', "%$query%")
            ->with(['estudiante', 'clase'])
            ->paginate(10);

        return response()->json($valoraciones);
    }

    /**
     * Obtener todas las valoraciones de una clase
     */
    public function getValoracionesByClase($id_clase)
    {
        // Verificar si la clase existe
        $clase = Clase::find($id_clase);

        if (!$clase) {
            return response()->json(['message' => 'Clase no encontrada'], 404);
        }

        // Obtener las valoraciones de la clase usando la relación
        $valoraciones = $clase->valoraciones;

        return response()->json($valoraciones);
    }
}