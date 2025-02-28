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


    /**
     * Búsqueda por campos específicos
     */
    public function searchByFields(Request $request)
    {
        $request->validate([
            'instrumento' => 'sometimes|string|max:255',
            'dificultad' => 'sometimes|string|max:50',
            'duracion' => 'sometimes|integer',
            'max_alumnos' => 'sometimes|integer',
            'precio' => 'sometimes|numeric',
            'profesor_id' => 'sometimes|integer|exists:usuario,id',
        ]);

        $query = Clase::query();

        if ($request->has('instrumento')) {
            $query->where('instrumento', 'ilike', '%' . $request->instrumento . '%');
        }

        if ($request->has('dificultad')) {
            $query->where('dificultad', 'ilike', '%' . $request->dificultad . '%');
        }

        if ($request->has('duracion')) {
            $query->where('duracion', $request->duracion);
        }

        if ($request->has('max_alumnos')) {
            $query->where('max_alumnos', $request->max_alumnos);
        }

        if ($request->has('precio')) {
            $query->where('precio', $request->precio);
        }

        if ($request->has('profesor_id')) {
            $query->where('profesor_id', $request->profesor_id);
        }

        $clases = $query->paginate(10);

        return response()->json($clases);
    }


    /**
     * Búsqueda completa en todos los campos.
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1', // Texto de búsqueda
        ]);

        $query = $request->input('query'); // Texto de búsqueda

        // Búsqueda en múltiples campos
        $clases = Clase::where('instrumento', 'ilike', "%$query%")
            ->orWhere('dificultad', 'ilike', "%$query%")
            ->orWhere('duracion', 'ilike', "%$query%")
            ->orWhere('max_alumnos', 'ilike', "%$query%")
            ->orWhere('precio', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($clases);
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

    /**
     * Obtener todos los estudiantes que asisten a una clase
     */
    public function getEstudiantesByIdClase($id)
    {
        // Buscar la clase por ID
        $clase = Clase::where('id', $id)->first();

        if (!$clase) {
            return response()->json(['message' => 'Clase no encontrada'], 404);
        }

        // Obtener las clases a las que ha asistido
        $estudiantes = $clase->estudiantes;

        return response()->json($estudiantes);
    }

    /**
     * Obtener profesor
     */
    public function getProfesorByClase($idClase)
    {
        // Buscar la clase por su ID
        $clase = Clase::find($idClase);

        if (!$clase) {
            return response()->json(['message' => 'Clase no encontrada'], 404);
        }

        // Obtener el profesor que imparte la clase usando la relación
        $profesor = $clase->profesor;

        return response()->json($profesor);
    }
}
