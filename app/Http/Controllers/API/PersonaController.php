<?php

namespace App\Http\Controllers\API;

use App\Models\Persona;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::all();

        return response()->json([
            'success' => true,
            'data' => $personas
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'nombre' => 'required|string|max:255',

            'apellido_p' => 'required|string|max:255',

            'apellido_m' => 'required|string|max:255',

            'celular' => 'required|string|max:20'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $persona = Persona::create([

            'nombre' => $request->nombre,

            'apellido_p' => $request->apellido_p,

            'apellido_m' => $request->apellido_m,

            'celular' => $request->celular,

            'activo' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Persona registrada correctamente',
            'data' => $persona
        ], 201);
    }


    public function show(string $id)
    {
        $persona = Persona::find($id);

        if (!$persona) {

            return response()->json([
                'success' => false,
                'message' => 'Persona no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $persona
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $persona = Persona::find($id);

        if (!$persona) {

            return response()->json([
                'success' => false,
                'message' => 'Persona no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'nombre' => 'required|string|max:255',

            'apellido_p' => 'required|string|max:255',

            'apellido_m' => 'required|string|max:255',

            'celular' => 'required|string|max:20'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $persona->update([

            'nombre' => $request->nombre,

            'apellido_p' => $request->apellido_p,

            'apellido_m' => $request->apellido_m,

            'celular' => $request->celular

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Persona actualizada correctamente',
            'data' => $persona
        ], 200);
    }


    public function destroy(string $id)
    {
        $persona = Persona::find($id);

        if (!$persona) {

            return response()->json([
                'success' => false,
                'message' => 'Persona no encontrada'
            ], 404);
        }

        $persona->delete();

        return response()->json([
            'success' => true,
            'message' => 'Persona eliminada correctamente'
        ], 200);
    }
}