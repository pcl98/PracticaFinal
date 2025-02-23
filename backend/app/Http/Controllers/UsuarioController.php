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
        $usuarios = Usuario::paginate(1);
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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'nivel' => 'required|integer',
            'tipo_usuario' => 'required|string|max:50',
            'contraseña' => 'required|string|min:6',
            'email' => 'required|email|unique:usuario,email,' . $usuario->id,
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
     * Búsqueda de usuarios
     */
    public function search(Request $request)
    {
        $query = Usuario::query();

        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->has('apellido')) {
            $query->where('apellido', 'like', '%' . $request->apellido . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->has('tipo_usuario')) {
            $query->where('tipo_usuario', $request->tipo_usuario);
        }

        if ($request->has('nivel')) {
            $query->where('nivel', $request->nivel);
        }

        $usuarios = $query->get();

        return response()->json($usuarios);
    }

    /**
     * Búsqueda avanzada de usuarios
     */
    public function advancedSearch(Request $request)
    {
        // Validar que se haya enviado el parámetro 'query'
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query'); // Texto de búsqueda

        // Realizar la búsqueda en múltiples campos
        $usuarios = Usuario::where('nombre', 'like', "%$query%")
            ->orWhere('apellido', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('tipo_usuario', 'like', "%$query%")
            ->paginate(10);

        return response()->json($usuarios);
    }

}
