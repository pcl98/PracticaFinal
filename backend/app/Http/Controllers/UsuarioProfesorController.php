<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UsuarioProfesor;

class UsuarioProfesorController extends Controller
{
    /**
     * Obtener todos los profesores (paginados)
     */
    public function index()
    {
        $profesores = UsuarioProfesor::paginate(10);
        return response()->json($profesores);
    }

    /**
     * Crear un nuevo profesor
     */
    public function store(Request $request)
    {
        // Reiniciar la secuencia del campo id si es necesario
        DB::statement('SELECT setval(\'usuario_profesor_id_seq\', (SELECT MAX(id) FROM usuario_profesor));');

        // Validar los datos antes de crear el registro
        $request->validate([
            'dni' => 'required|string|max:20|unique:usuario_profesor,dni',
            'id' => 'required|integer|exists:usuario,id', // Asegura que el id exista en la tabla usuario
            'especialidad' => 'required|string|max:255',
            'media_calificacion' => 'nullable|numeric',
        ]);

        // Crear el registro
        $profesor = UsuarioProfesor::create($request->all());

        return response()->json(['message' => 'Profesor creado correctamente', 'profesor' => $profesor], 201);
    }

    /**
     * Obtener un profesor específico por su ID
     */
    public function show(string $id)
    {
        $profesor = UsuarioProfesor::find($id);

        if (!$profesor) {
            return response()->json(['message' => 'Profesor no encontrado'], 404);
        }

        return response()->json($profesor);
    }

    /**
     * Actualizar un profesor existente
     */
    public function update(Request $request, string $id)
    {
        $profesor = UsuarioProfesor::find($id);

        if (!$profesor) {
            return response()->json(['message' => 'Profesor no encontrado'], 404);
        }

        // Validar los datos antes de actualizar
        $request->validate([
            'dni' => 'sometimes|string|max:20|unique:usuario_profesor,dni,' . $profesor->id,
            'especialidad' => 'sometimes|string|max:255',
            'media_calificacion' => 'nullable|numeric',
        ]);

        // Actualizar el registro
        $profesor->update($request->all());

        return response()->json(['message' => 'Profesor actualizado correctamente', 'profesor' => $profesor]);
    }

    /**
     * Eliminar un profesor
     */
    public function destroy(string $id)
    {
        $profesor = UsuarioProfesor::find($id);

        if (!$profesor) {
            return response()->json(['message' => 'Profesor no encontrado'], 404);
        }

        $profesor->delete();

        return response()->json(['message' => 'Profesor eliminado correctamente']);
    }

    /**
     * Búsqueda avanzada por campos específicos
     */
    public function searchByFields(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'dni' => 'sometimes|string|max:20',
            'especialidad' => 'sometimes|string|max:255',
            'media_calificacion' => 'nullable|numeric',
        ]);

        // Construir la consulta
        $query = UsuarioProfesor::query();

        if ($request->has('dni')) {
            $query->where('dni', 'ilike', '%' . $request->dni . '%');
        }

        if ($request->has('especialidad')) {
            $query->where('especialidad', 'ilike', '%' . $request->especialidad . '%');
        }

        if ($request->has('media_calificacion')) {
            $query->where('media_calificacion', $request->media_calificacion);
        }

        // Paginar los resultados
        $profesores = $query->paginate(10);

        return response()->json($profesores);
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
        $profesores = UsuarioProfesor::where('dni', 'ilike', "%$query%")
            ->orWhere('especialidad', 'ilike', "%$query%")
            ->orWhere('media_calificacion', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($profesores);
    }

    /**
     * Obtener las clases que imparte un profesor
     */
    public function getClasesByProfesor($idProfesor)
    {
        // Buscar al profesor por su ID
        $profesor = UsuarioProfesor::find($idProfesor);

        if (!$profesor) {
            return response()->json(['message' => 'Profesor no encontrado'], 404);
        }

        // Obtener las clases que imparte el profesor usando la relación
        $clases = $profesor->clases;

        return response()->json($clases);
    }
}