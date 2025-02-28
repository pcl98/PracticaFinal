<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifica;
use App\Models\UsuarioProfesor;
use App\Models\Clase;

class NotificaController extends Controller
{
    /**
     * Obtener todas las notificaciones (paginadas)
     */
    public function index()
    {
        $notificas = Notifica::paginate(10);
        return response()->json($notificas);
    }

    /**
     * Crear una nueva notificación
     */
    public function store(Request $request)
    {
        // Validar los datos antes de crear el registro
        $request->validate([
            'dni' => 'required|exists:usuario_profesor,dni', // Asegura que el dni exista en usuario_profesor
            'id_clase' => 'required|integer|exists:clase,id', // Asegura que id_clase exista en clase
            'fecha_envio' => 'nullable|date',
            'contenido' => 'nullable|string|max:255',
        ]);

        // Crear el registro
        $notifica = Notifica::create($request->all());

        return response()->json(['message' => 'Notificación creada correctamente', 'notifica' => $notifica], 201);
    }

    /**
     * Obtener una notificación específica por su ID
     */
    public function show($id)
    {
        // Buscar la notificación por ID
        $notifica = Notifica::find($id);

        if (!$notifica) {
            return response()->json(['message' => 'Notificación no encontrada'], 404);
        }

        return response()->json($notifica);
    }

    /**
     * Actualizar una notificación existente
     */
    public function update(Request $request, $id)
    {
        // Buscar la notificación por ID
        $notifica = Notifica::find($id);

        if (!$notifica) {
            return response()->json(['message' => 'Notificación no encontrada'], 404);
        }

        // Validar los datos antes de actualizar
        $request->validate([
            'dni' => 'nullable|exists:usuario_profesor,dni', // Asegura que el dni exista en usuario_profesor
            'id_clase' => 'nullable|integer|exists:clase,id', // Asegura que id_clase exista en clase
            'fecha_envio' => 'nullable|date',
            'contenido' => 'nullable|string|max:255',
        ]);

        // Actualizar el registro con los nuevos valores (si se proporcionan)
        $notifica->update($request->all());

        return response()->json(['message' => 'Notificación actualizada correctamente', 'notifica' => $notifica]);
    }

    /**
     * Eliminar una notificación
     */
    public function destroy($id)
    {
        // Buscar la notificación por ID
        $notifica = Notifica::find($id);

        if (!$notifica) {
            return response()->json(['message' => 'Notificación no encontrada'], 404);
        }

        // Eliminar el registro
        $notifica->delete();

        return response()->json(['message' => 'Notificación eliminada correctamente']);
    }

    /**
     * Búsqueda avanzada por campos específicos
     */
    public function searchByFields(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'dni' => 'nullable|exists:usuario_profesor,dni',
            'id_clase' => 'nullable|integer|exists:clase,id',
            'fecha_envio' => 'nullable|date',
            'contenido' => 'nullable|string|max:255',
        ]);

        // Construir la consulta
        $query = Notifica::query();

        if ($request->has('dni')) {
            $query->where('dni', $request->dni);
        }

        if ($request->has('id_clase')) {
            $query->where('id_clase', $request->id_clase);
        }

        if ($request->has('fecha_envio')) {
            $query->where('fecha_envio', $request->fecha_envio);
        }

        if ($request->has('contenido')) {
            $query->where('contenido', 'ilike', '%' . $request->contenido . '%');
        }

        // Paginar los resultados
        $notificas = $query->paginate(10);

        return response()->json($notificas);
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
        $notificas = Notifica::where('dni', 'ilike', "%$query%")
            ->orWhere('id_clase', 'ilike', "%$query%")
            ->orWhere('fecha_envio', 'ilike', "%$query%")
            ->orWhere('contenido', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($notificas);
    }
}
