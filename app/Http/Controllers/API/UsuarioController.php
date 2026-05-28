<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{

    public function index()
    {
        $usuarios = Usuario::with('persona')->get();

        return response()->json([
            'success' => true,
            'data' => $usuarios
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_persona' => 'required|exists:personas,id',

            'correo' => 'required|email|unique:usuarios,correo',

            'password' => 'required|min:6',

            'admin' => 'required|boolean'

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

            'admin' => $request->admin

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'data' => $usuario
        ], 201);
    }

    public function show(string $id)
    {
        $usuario = Usuario::with('persona')->find($id);

        if (!$usuario) {

            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $usuario
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {

            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'id_persona' => 'required|exists:personas,id',

            'correo' => 'required|email',

            'admin' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $usuario->update([

            'id_persona' => $request->id_persona,

            'correo' => $request->correo,

            'admin' => $request->admin

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => $usuario
        ], 200);
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {

            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ], 200);
    }
}