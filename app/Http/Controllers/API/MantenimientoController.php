<?php

namespace App\Http\Controllers\API;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MantenimientoController extends Controller
{

    public function index()
    {
        $mantenimientos = Mantenimiento::with([
            'departamento',
            'pago'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $mantenimientos
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'mes' => 'required|string|max:20',

            'año' => 'required|integer',

            'id_depa' => 'required|exists:departamentos,id',

            'completado' => 'required|boolean',

            'monto' => 'required|numeric',

            'id_pago' => 'nullable|exists:pagos,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $mantenimiento = Mantenimiento::create([

            'mes' => $request->mes,

            'año' => $request->año,

            'id_depa' => $request->id_depa,

            'completado' => $request->completado,

            'monto' => $request->monto,

            'id_pago' => $request->id_pago

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mantenimiento registrado correctamente',
            'data' => $mantenimiento
        ], 201);
    }

    public function show(string $id)
    {
        $mantenimiento = Mantenimiento::with([
            'departamento',
            'pago'
        ])->find($id);

        if (!$mantenimiento) {

            return response()->json([
                'success' => false,
                'message' => 'Mantenimiento no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $mantenimiento
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if (!$mantenimiento) {

            return response()->json([
                'success' => false,
                'message' => 'Mantenimiento no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'mes' => 'required|string|max:20',

            'año' => 'required|integer',

            'id_depa' => 'required|exists:departamentos,id',

            'completado' => 'required|boolean',

            'monto' => 'required|numeric',

            'id_pago' => 'nullable|exists:pagos,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $mantenimiento->update([

            'mes' => $request->mes,

            'año' => $request->año,

            'id_depa' => $request->id_depa,

            'completado' => $request->completado,

            'monto' => $request->monto,

            'id_pago' => $request->id_pago

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mantenimiento actualizado correctamente',
            'data' => $mantenimiento
        ], 200);
    }

    public function destroy(string $id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if (!$mantenimiento) {

            return response()->json([
                'success' => false,
                'message' => 'Mantenimiento no encontrado'
            ], 404);
        }

        $mantenimiento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mantenimiento eliminado correctamente'
        ], 200);
    }
}