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
        $usuarios = Usuario::all();
        return response()->json(($usuarios));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //$data['contraseña'] = bcrypt($data['contraseña']); // Asegúrate de cifrar la contraseña

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            'nombre' => 'string|max:255',
            'apellido' => 'string|max:255',
            'nivel' => 'integer',
            'tipo_usuario' => 'string|max:50',
            'contraseña' => 'string|min:6',
            'email' => 'email|unique:USUARIO,email,' . $usuario->id,
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

}
