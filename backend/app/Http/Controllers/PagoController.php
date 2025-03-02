<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Clase;
use App\Models\UsuarioEstudiante;
use Illuminate\Validation\Rule;

class PagoController extends Controller
{
    /**
     * Obtener todos los pagos (paginados)
     */
    public function index()
    {
        $pagos = Pago::paginate(10);
        return response()->json($pagos);
    }

    /**
     * Crear un nuevo pago
     */
    public function store(Request $request)
    {
        // Validar los datos antes de crear el registro
        $request->validate([
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|string|max:50',
            'cantidad' => 'required|numeric',
            'concepto' => 'nullable|string',
            'id_estudiante' => 'required|integer|exists:usuario_estudiante,id',
            'id_clase' => 'required|integer|exists:clase,id',
        ]);

        // Crear el registro
        $pago = Pago::create($request->all());

        return response()->json(['message' => 'Pago creado correctamente', 'pago' => $pago], 201);
    }

    /**
     * Obtener un pago específico por su ID
     */
    public function show($id)
    {
        // Buscar el pago por ID
        $pago = Pago::find($id);

        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        return response()->json($pago);
    }

    /**
     * Actualizar un pago existente
     */
    public function update(Request $request, $id)
    {
        // Buscar el pago por ID
        $pago = Pago::find($id);

        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        // Validar los datos antes de actualizar
        $request->validate([
            'fecha_pago' => 'sometimes|date',
            'metodo_pago' => 'sometimes|string|max:50',
            'cantidad' => 'sometimes|numeric',
            'concepto' => 'nullable|string',
            'id_estudiante' => 'sometimes|integer|exists:usuario_estudiante,id',
            'id_clase' => 'sometimes|integer|exists:clase,id',
        ]);

        // Actualizar el registro con los nuevos valores (si se proporcionan)
        $pago->update($request->all());

        return response()->json(['message' => 'Pago actualizado correctamente', 'pago' => $pago]);
    }

    /**
     * Eliminar un pago
     */
    public function destroy($id)
    {
        // Buscar el pago por ID
        $pago = Pago::find($id);

        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        // Eliminar el registro
        $pago->delete();

        return response()->json(['message' => 'Pago eliminado correctamente']);
    }

    /**
     * Búsqueda avanzada por campos específicos
     */
    public function searchByFields(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'fecha_pago' => 'sometimes|date',
            'metodo_pago' => 'sometimes|string|max:50',
            'cantidad' => 'sometimes|numeric',
            'concepto' => 'nullable|string',
            'id_estudiante' => 'sometimes|integer|exists:usuario_estudiante,id',
            'id_clase' => 'sometimes|integer|exists:clase,id',
        ]);

        // Construir la consulta
        $query = Pago::query();

        if ($request->has('fecha_pago')) {
            $query->where('fecha_pago', $request->fecha_pago);
        }

        if ($request->has('metodo_pago')) {
            $query->where('metodo_pago', 'ilike', '%' . $request->metodo_pago . '%');
        }

        if ($request->has('cantidad')) {
            $query->where('cantidad', $request->cantidad);
        }

        if ($request->has('concepto')) {
            $query->where('concepto', 'ilike', '%' . $request->concepto . '%');
        }

        if ($request->has('id_estudiante')) {
            $query->where('id_estudiante', $request->id_estudiante);
        }

        if ($request->has('id_clase')) {
            $query->where('id_clase', $request->id_clase);
        }

        // Paginar los resultados
        $pagos = $query->paginate(10);

        return response()->json($pagos);
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
        $pagos = Pago::where('fecha_pago', 'ilike', "%$query%")
            ->orWhere('metodo_pago', 'ilike', "%$query%")
            ->orWhere('cantidad', 'ilike', "%$query%")
            ->orWhere('concepto', 'ilike', "%$query%")
            ->orWhere('id_estudiante', 'ilike', "%$query%")
            ->orWhere('id_clase', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($pagos);
    }
}