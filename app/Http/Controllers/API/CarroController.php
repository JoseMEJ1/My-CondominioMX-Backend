<?php

namespace App\Http\Controllers\API;

use App\Models\Carro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CarroController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTAR CARROS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $carros = Carro::with('departamento')->get();

        return response()->json([
            'success' => true,
            'data' => $carros
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREAR CARRO
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_depa' => 'required|exists:departamentos,id',

            'placa' => 'required|string|max:20|unique:carros,placa',

            'marca' => 'required|string|max:50',

            'modelo' => 'required|string|max:50',

            'color' => 'required|string|max:30'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $carro = Carro::create([

            'id_depa' => $request->id_depa,

            'placa' => $request->placa,

            'marca' => $request->marca,

            'modelo' => $request->modelo,

            'color' => $request->color

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Carro registrado correctamente',
            'data' => $carro
        ], 201);
    }
    public function show(string $id)
    {
        $carro = Carro::with('departamento')->find($id);

        if (!$carro) {

            return response()->json([
                'success' => false,
                'message' => 'Carro no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $carro
        ], 200);
    }
    public function update(Request $request, string $id)
    {
        $carro = Carro::find($id);

        if (!$carro) {

            return response()->json([
                'success' => false,
                'message' => 'Carro no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'id_depa' => 'required|exists:departamentos,id',

            'placa' => 'required|string|max:20',

            'marca' => 'required|string|max:50',

            'modelo' => 'required|string|max:50',

            'color' => 'required|string|max:30'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $carro->update([

            'id_depa' => $request->id_depa,

            'placa' => $request->placa,

            'marca' => $request->marca,

            'modelo' => $request->modelo,

            'color' => $request->color

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Carro actualizado correctamente',
            'data' => $carro
        ], 200);
    }

    public function destroy(string $id)
    {
        $carro = Carro::find($id);

        if (!$carro) {

            return response()->json([
                'success' => false,
                'message' => 'Carro no encontrado'
            ], 404);
        }

        $carro->delete();

        return response()->json([
            'success' => true,
            'message' => 'Carro eliminado correctamente'
        ], 200);
    }
}