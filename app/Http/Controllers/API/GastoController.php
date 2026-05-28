<?php

namespace App\Http\Controllers\API;

use App\Models\Gasto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GastoController extends Controller
{

    public function index()
    {
        $gastos = Gasto::all();

        return response()->json([
            'success' => true,
            'data' => $gastos
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'monto' => 'required|numeric|min:0',

            'descripcion' => 'required|string|max:255',

            'fecha' => 'required|date'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $gasto = Gasto::create([

            'monto' => $request->monto,

            'descripcion' => $request->descripcion,

            'fecha' => $request->fecha

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gasto registrado correctamente',
            'data' => $gasto
        ], 201);
    }
    public function show(string $id)
    {
        $gasto = Gasto::find($id);

        if (!$gasto) {

            return response()->json([
                'success' => false,
                'message' => 'Gasto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $gasto
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $gasto = Gasto::find($id);

        if (!$gasto) {

            return response()->json([
                'success' => false,
                'message' => 'Gasto no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'monto' => 'required|numeric|min:0',

            'descripcion' => 'required|string|max:255',

            'fecha' => 'required|date'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $gasto->update([

            'monto' => $request->monto,

            'descripcion' => $request->descripcion,

            'fecha' => $request->fecha

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gasto actualizado correctamente',
            'data' => $gasto
        ], 200);
    }

    public function destroy(string $id)
    {
        $gasto = Gasto::find($id);

        if (!$gasto) {

            return response()->json([
                'success' => false,
                'message' => 'Gasto no encontrado'
            ], 404);
        }

        $gasto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gasto eliminado correctamente'
        ], 200);
    }
}