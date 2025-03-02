<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    /**
     * Devolver todos los usuarios
     */
    public function index()
    {
        $usuarios = Usuario::paginate(15);
        return response()->json(($usuarios));
    }

    /**
     * Crear nuevo usuario
     */
    public function store(Request $request)
    {
        // Reiniciar la secuencia del campo id si es necesario
        DB::statement('SELECT setval(\'usuario_id_seq\', (SELECT MAX(id) FROM usuario));');

        // Validar datos antes del registro
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'nivel' => 'required|integer',
            'tipo_usuario' => 'required|string|max:50',
            'contraseña' => 'required|string|min:6',
            'email' => 'required|email|unique:usuario,email',
        ]);

        // Cifrar la contraseña antes de guardarla
        $data = $request->all();
        //$data['contraseña'] = bcrypt($data['contraseña']);

        $usuario = Usuario::create($data);

        return response()->json(['message' => 'Usuario creado correctamente', 'usuario' => $usuario], 201);
    }


    /**
     * Devolver un usuario específico
     */
    public function show(string $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    /**
     * Actualizar un usuario
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'nivel' => 'sometimes|integer',
            'tipo_usuario' => 'sometimes|string|max:50',
            'contraseña' => 'sometimes|string|min:6',
            'email' => 'sometimes|email|unique:usuario,email,' . $usuario->id,
        ]);

        $usuario->update($request->all());

        return response()->json(['message' => 'Usuario actualizado correctamente', 'usuario' => $usuario]);
    }

    /**
     * Eliminar un usuario
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    /**
     * Búsqueda por campos específicos.
     */
    public function searchByFields(Request $request)
    {
        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'nivel' => 'sometimes|integer',
            'tipo_usuario' => 'sometimes|string|max:50',
            'email' => 'sometimes|email',
        ]);

        $query = Usuario::query();

        if ($request->has('nombre')) {
            $query->where('nombre', 'ilike', '%' . $request->nombre . '%');
        }

        if ($request->has('apellido')) {
            $query->where('apellido', 'ilike', '%' . $request->apellido . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'ilike', '%' . $request->email . '%');
        }

        if ($request->has('tipo_usuario')) {
            $query->where('tipo_usuario', 'ilike', '%' . $request->tipo_usuario . '%');
        }

        if ($request->has('nivel')) {
            $nivel = (int)$request->nivel; // Convierte a entero
            $query->where('nivel', $nivel);
        }

        $usuarios = $query->paginate(10);

        return response()->json($usuarios);
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
        $usuarios = Usuario::where('nombre', 'ilike', "%$query%")
            ->orWhere('apellido', 'ilike', "%$query%")
            ->orWhere('email', 'ilike', "%$query%")
            ->orWhere('tipo_usuario', 'ilike', "%$query%")
            ->orWhere('nivel', 'ilike', "%$query%")
            ->paginate(10);

        return response()->json($usuarios);
    }

}
