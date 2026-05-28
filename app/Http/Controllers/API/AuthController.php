<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'correo' => 'required|email',

            'password' => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $usuario = Usuario::with('persona')
            ->where('correo', $request->correo)
            ->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {

            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'token' => $token,
            'usuario' => $usuario
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_persona' => 'required|exists:personas,id',

            'correo' => 'required|email|unique:usuarios,correo',

            'password' => 'required|min:6'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $usuario = Usuario::create([

            'id_persona' => $request->id_persona,

            'correo' => $request->correo,

            'password' => Hash::make($request->password),

            'admin' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado',
            'usuario' => $usuario
        ], 201);
    }


    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'usuario' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada'
        ]);
    }
}