<?php

namespace App\Http\Controllers\API;

use App\Models\Pago;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PagoController extends Controller
{

    public function index()
    {
        $pagos = Pago::with([
            'departamento',
            'tipoPago',
            'motivo',
            'reporte',
            'mantenimiento'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $pagos
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_depa' => 'required|exists:departamentos,id',

            'monto' => 'required|numeric|min:0',

            'id_tipo' => 'required|exists:tipos_pago,id',

            'fecha' => 'required|date',

            'id_motivo' => 'required|exists:motivos,id',

            'descripcion' => 'nullable|string',

            'comprobante' => 'nullable|string',

            'efectuado' => 'required|boolean',

            'id_reporte' => 'nullable|exists:reportes,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pago = Pago::create([

            'id_depa' => $request->id_depa,

            'monto' => $request->monto,

            'id_tipo' => $request->id_tipo,

            'fecha' => $request->fecha,

            'id_motivo' => $request->id_motivo,

            'descripcion' => $request->descripcion,

            'comprobante' => $request->comprobante,

            'efectuado' => $request->efectuado,

            'id_reporte' => $request->id_reporte

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pago registrado correctamente',
            'data' => $pago
        ], 201);
    }

    public function show(string $id)
    {
        $pago = Pago::with([
            'departamento',
            'tipoPago',
            'motivo',
            'reporte',
            'mantenimiento'
        ])->find($id);

        if (!$pago) {

            return response()->json([
                'success' => false,
                'message' => 'Pago no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pago
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $pago = Pago::find($id);

        if (!$pago) {

            return response()->json([
                'success' => false,
                'message' => 'Pago no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'id_depa' => 'required|exists:departamentos,id',

            'monto' => 'required|numeric|min:0',

            'id_tipo' => 'required|exists:tipos_pago,id',

            'fecha' => 'required|date',

            'id_motivo' => 'required|exists:motivos,id',

            'descripcion' => 'nullable|string',

            'comprobante' => 'nullable|string',

            'efectuado' => 'required|boolean',

            'id_reporte' => 'nullable|exists:reportes,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pago->update([

            'id_depa' => $request->id_depa,

            'monto' => $request->monto,

            'id_tipo' => $request->id_tipo,

            'fecha' => $request->fecha,

            'id_motivo' => $request->id_motivo,

            'descripcion' => $request->descripcion,

            'comprobante' => $request->comprobante,

            'efectuado' => $request->efectuado,

            'id_reporte' => $request->id_reporte

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pago actualizado correctamente',
            'data' => $pago
        ], 200);
    }


    public function destroy(string $id)
    {
        $pago = Pago::find($id);

        if (!$pago) {

            return response()->json([
                'success' => false,
                'message' => 'Pago no encontrado'
            ], 404);
        }

        $pago->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pago eliminado correctamente'
        ], 200);
    }
}