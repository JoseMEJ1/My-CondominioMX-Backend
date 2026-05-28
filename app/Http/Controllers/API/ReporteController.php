<?php

namespace App\Http\Controllers\API;

use App\Models\Reporte;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReporteController extends Controller
{

    public function index()
    {
        $reportes = Reporte::with([
            'usuario',
            'pagos'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $reportes
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_usuario' => 'required|exists:usuarios,id',

            'reporte' => 'required|string|max:255',

            'fecha' => 'required|date'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $reporte = Reporte::create([

            'id_usuario' => $request->id_usuario,

            'reporte' => $request->reporte,

            'fecha' => $request->fecha

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reporte registrado correctamente',
            'data' => $reporte
        ], 201);
    }

    public function show(string $id)
    {
        $reporte = Reporte::with([
            'usuario',
            'pagos'
        ])->find($id);

        if (!$reporte) {

            return response()->json([
                'success' => false,
                'message' => 'Reporte no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $reporte
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $reporte = Reporte::find($id);

        if (!$reporte) {

            return response()->json([
                'success' => false,
                'message' => 'Reporte no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'id_usuario' => 'required|exists:usuarios,id',

            'reporte' => 'required|string|max:255',

            'fecha' => 'required|date'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $reporte->update([

            'id_usuario' => $request->id_usuario,

            'reporte' => $request->reporte,

            'fecha' => $request->fecha

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reporte actualizado correctamente',
            'data' => $reporte
        ], 200);
    }

    public function destroy(string $id)
    {
        $reporte = Reporte::find($id);

        if (!$reporte) {

            return response()->json([
                'success' => false,
                'message' => 'Reporte no encontrado'
            ], 404);
        }

        $reporte->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reporte eliminado correctamente'
        ], 200);
    }
}