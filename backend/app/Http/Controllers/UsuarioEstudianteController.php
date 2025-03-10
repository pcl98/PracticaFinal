<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Notifica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UsuarioEstudiante;
use App\Models\Pago;
use App\Models\Asiste;
use App\Models\Valora;
use App\Models\Examen;

class UsuarioEstudianteController extends Controller
{
    /**
     * Devolver todos los usuarios estudiantes
     */
    public function index()
    {
        $usuariosEstudiantes = UsuarioEstudiante::paginate(10);
        return response()->json($usuariosEstudiantes);
    }

    /**
     * Crear nuevo usuario estudiante
     */
    public function store(Request $request)
    {
        // Reiniciar la secuencia del campo id si es necesario
        DB::statement('SELECT setval(\'usuario_estudiante_id_seq\', (SELECT MAX(id) FROM usuario_estudiante));');

        // Validar datos antes del registro
        $request->validate([
            'dni' => 'required|string|max:20|unique:usuario_estudiante,dni',
            'id' => 'required|integer|unique:usuario_estudiante,id',
            'historial_clases' => 'nullable|string',
            'lecciones_completadas' => 'nullable|integer',
        ]);

        $usuarioEstudiante = UsuarioEstudiante::create($request->all());

        return response()->json(['message' => 'Usuario estudiante creado correctamente', 'usuario_estudiante' => $usuarioEstudiante], 201);
    }

    /**
     * Devolver un usuario estudiante específico
     */
    public function show(string $id)
    {
        $usuarioEstudiante = UsuarioEstudiante::find($id);

        if (!$usuarioEstudiante) {
            return response()->json(['message' => 'Usuario estudiante no encontrado'], 404);
        }

        return response()->json($usuarioEstudiante);
    }

    /**
     * Actualizar un usuario estudiante
     */
    public function update(Request $request, $id)
    {
        $usuarioEstudiante = UsuarioEstudiante::find($id);

        if (!$usuarioEstudiante) {
            return response()->json(['message' => 'Usuario estudiante no encontrado'], 404);
        }

        $request->validate([
            'dni' => 'sometimes|string|max:20|unique:usuario_estudiante,dni,' . $usuarioEstudiante->id,
            'historial_clases' => 'nullable|string',
            'lecciones_completadas' => 'nullable|integer',
        ]);

        $usuarioEstudiante->update($request->all());

        return response()->json(['message' => 'Usuario estudiante actualizado correctamente', 'usuario_estudiante' => $usuarioEstudiante]);
    }

    /**
     * Eliminar un usuario estudiante
     */
    public function destroy($id)
    {
        $usuarioEstudiante = UsuarioEstudiante::find($id);

        if (!$usuarioEstudiante) {
            return response()->json(['message' => 'Usuario estudiante no encontrado'], 404);
        }

        $usuarioEstudiante->delete();

        return response()->json(['message' => 'Usuario estudiante eliminado correctamente']);
    }

    /**
     * Búsqueda por campos específicos
     */
    public function searchByFields(Request $request)
    {
        $request->validate([
            'dni' => 'sometimes|string|max:20',
            'id' => 'sometimes|integer',
            'historial_clases' => 'nullable|string',
            'lecciones_completadas' => 'nullable|integer',
        ]);

        $query = UsuarioEstudiante::query();

        if ($request->has('dni')) {
            $query->where('dni', 'ilike', '%' . $request->dni . '%');
        }

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('historial_clases')) {
            $query->where('historial_clases', 'ilike', '%' . $request->historial_clases . '%');
        }

        if ($request->has('lecciones_completadas')) {
            $query->where('lecciones_completadas', $request->lecciones_completadas);
        }

        $usuariosEstudiantes = $query->paginate(10);

        return response()->json($usuariosEstudiantes);
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

        // Búsqueda en todos los campos
        $usuariosEstudiantes = UsuarioEstudiante::where('dni', 'ilike', "%$query%")
            ->orWhere('id', 'ilike', "%$query%")
            ->orWhere('historial_clases', 'ilike', "%$query%")
            ->orWhere('lecciones_completadas', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($usuariosEstudiantes);
    }

    /**
     * Obtener todos los pagos hechos por un alumno
     */
    public function getPagosByIdEstudiante($id)
    {
        $usuarioEstudiante = UsuarioEstudiante::find($id);

        if (!$usuarioEstudiante) {
            return response()->json(['message' => 'Usuario estudiante no encontrado'], 404);
        }

        // Obtener las clases a las que ha asistido el alumno
        $clases = Pago::where('id_estudiante', $id)
            ->paginate(10);

        return response()->json($clases);
    }

    /**
     * Obtener todas las clases a las que ha asistido un alumno
     */
    public function getClasesByIdEstudiante($id)
    {
        // Buscar el estudiante por ID
        $estudiante = UsuarioEstudiante::where('id', $id)->first();

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Obtener las clases a las que ha asistido
        $clases = $estudiante->clases;

        return response()->json($clases);
    }

    /**
     * Obtener las notificaciones de un estudiante
     */
    public function getNotificacionesByDniEstudiante(Request $request)
    {
        // Obtener el dni del estudiante desde la request
        $dniEstudiante = $request->input('dni');

        // Verificar si el estudiante existe
        $estudiante = UsuarioEstudiante::where('dni', $dniEstudiante)->first();

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Obtener las notificaciones del estudiante usando la relación
        $notificaciones = $estudiante->notificaciones;

        return response()->json($notificaciones);
    }

    /**
     * Obtener todas las valoraciones de un estudiante por su ID
     */
    public function getValoracionesById($id)
    {
        // Verificar si el estudiante existe
        $estudiante = UsuarioEstudiante::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Obtener las valoraciones del estudiante usando su DNI
        $valoraciones = Valora::where('dni', $estudiante->dni)->get();

        return response()->json($valoraciones);
    }

    /**
     * Obtener exámenes
     */
    public function getExamenesByIdEstudiante($id)
    {
        // Buscar al estudiante
        $estudiante = UsuarioEstudiante::findOrFail($id);

        // Obtener los exámenes de todas las clases en las que está inscrito
        $examenes = Examen::whereHas('clase', function ($query) use ($estudiante) {
            $query->whereIn('id', $estudiante->clases->pluck('id'));
        })->get();

        return response()->json($examenes);
    }

    /**
     * Obtener todas las clases online de un estudiante
     */
    public function getClasesOnlineByIdEstudiante($id)
    {
        // Buscar el estudiante por ID
        $estudiante = UsuarioEstudiante::where('id', $id)->first();

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Obtener las clases online del estudiante
        $clasesOnline = $estudiante->clases()->with('online')->get();

        return response()->json($clasesOnline);
    }

    /**
     * Obtener todas las clases presenciales de un estudiante
     */
    public function getClasesPresencialesByIdEstudiante($id)
    {
        // Buscar el estudiante por ID
        $estudiante = UsuarioEstudiante::where('id', $id)->first();

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Obtener las clases presenciales del estudiante
        $clasesPresenciales = $estudiante->clases()->with('presencial')->get();

        return response()->json($clasesPresenciales);
    }

}