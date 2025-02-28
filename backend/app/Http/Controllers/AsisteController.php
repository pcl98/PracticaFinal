<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asiste;
use App\Models\Usuario;
use App\Models\UsuarioEstudiante;
use App\Models\Clase;
use Illuminate\Validation\Rule;

class AsisteController extends Controller
{
    /**
     * Obtener todos los registros de asistencia (paginados)
     */
    public function index()
    {
        $asistencias = Asiste::paginate(10);
        return response()->json($asistencias);
    }

    /**
     * Crear un nuevo registro de asistencia
     */
    public function store(Request $request)
    {
        // Validar los datos antes de crear el registro
        $request->validate([
            'dni' => 'required|string|max:20|exists:usuario_estudiante,dni',
            'id_clase' => 'required|integer|exists:clase,id',
        ]);

        // Crear el registro
        $asiste = Asiste::create($request->all());

        return response()->json(['message' => 'Asistencia registrada correctamente', 'asiste' => $asiste], 201);
    }

    /**
     * Actualizar un registro de asistencia existente
     */
    public function update(Request $request, $dni, $id_clase)
    {

        // Buscar el registro por dni e id_clase
        $asiste = Asiste::where('dni', $dni)
            ->where('id_clase', $id_clase)
            ->first();

        if (!$asiste) {
            return response()->json(['message' => 'Registro de asistencia no encontrado'], 404);
        }

        // Validar los datos del cuerpo de la solicitud
        $request->validate([
            'dni' => 'sometimes|string|max:20|exists:usuario_estudiante,dni',
            'id_clase' => 'sometimes|integer|exists:clase,id',
        ]);

        // Actualizar el registro con los nuevos valores (si se proporcionan)
        if ($request->has('dni')) {
            $asiste->dni = $request->dni;
        }

        if ($request->has('id_clase')) {
            $asiste->id_clase = $request->id_clase;
        }

        $asiste->update($request->all());

        return response()->json(['message' => 'Asistencia actualizada correctamente', 'asiste' => $asiste]);
    }

    /**
     * Eliminar un registro de asistencia
     */
    public function destroy($dni, $id_clase)
    {
        // Buscar el registro por dni e id_clase
        $asiste = Asiste::where('dni', $dni)
            ->where('id_clase', $id_clase)
            ->first();

        if (!$asiste) {
            return response()->json(['message' => 'Registro de asistencia no encontrado'], 404);
        }

        // Eliminar el registro
        $asiste->delete();

        return response()->json(['message' => 'Asistencia eliminada correctamente']);
    }

    /**
     * Búsqueda avanzada por campos específicos
     */
    public function searchByFields(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'dni' => 'sometimes|string|max:20',
            'id_clase' => 'sometimes|integer',
        ]);

        // Construir la consulta
        $query = Asiste::query();

        if ($request->has('dni')) {
            $query->where('dni', 'ilike', '%' . $request->dni . '%');
        }

        if ($request->has('id_clase')) {
            $query->where('id_clase', $request->id_clase);
        }

        // Paginar los resultados
        $asistencias = $query->paginate(10);

        return response()->json($asistencias);
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
        $asistencias = Asiste::where('dni', 'ilike', "%$query%")
            ->orWhere('id_clase', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($asistencias);
    }
}
