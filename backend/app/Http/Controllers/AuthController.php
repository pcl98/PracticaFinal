<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /*
        TODO: Registrar el usuario completo
    */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'contraseña' => 'required|string|min:8',
        ]);

        $user = Usuario::create([
            'email' => $validated['email'],
            'contraseña' => $validated['contraseña'],
        ]);

        return response()->json(['message' => 'Usuario registrado correctamente']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'contraseña');
        
        // Buscar al usuario en la base de datos
        $user = Usuario::where('email', $credentials['email'])->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$user || $user->contraseña !== $credentials['contraseña']) { // Comparar contraseñas en texto plano
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Si las credenciales son correctas, generar el token JWT
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'user' => [
                'nombre' => $user->nombre,
                'email' => $user->email,
            ],
        ]);
    }


    public function user()
    {
        return response()->json(auth('api')->user());
    }
}