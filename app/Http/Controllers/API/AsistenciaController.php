<?php

namespace App\Http\Controllers\API;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AsistenciaController extends Controller
{

    public function index()
    {
        $asistencias = Asistencia::with([
            'persona',
            'evento',
            'respuestas'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $asistencias
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_persona' => 'required|exists:personas,id',

            'id_evento' => 'required|exists:eventos,id',

            'hora' => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $asistencia = Asistencia::create([

            'id_persona' => $request->id_persona,

            'id_evento' => $request->id_evento,

            'hora' => $request->hora

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia registrada correctamente',
            'data' => $asistencia
        ], 201);
    }

    public function show(string $id)
    {
        $asistencia = Asistencia::with([
            'persona',
            'evento',
            'respuestas'
        ])->find($id);

        if (!$asistencia) {

            return response()->json([
                'success' => false,
                'message' => 'Asistencia no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $asistencia
        ], 200);
    }


    public function update(Request $request, string $id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {

            return response()->json([
                'success' => false,
                'message' => 'Asistencia no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'id_persona' => 'required|exists:personas,id',

            'id_evento' => 'required|exists:eventos,id',

            'hora' => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $asistencia->update([

            'id_persona' => $request->id_persona,

            'id_evento' => $request->id_evento,

            'hora' => $request->hora

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia actualizada correctamente',
            'data' => $asistencia
        ], 200);
    }


    public function destroy(string $id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {

            return response()->json([
                'success' => false,
                'message' => 'Asistencia no encontrada'
            ], 404);
        }

        $asistencia->delete();

        return response()->json([
            'success' => true,
            'message' => 'Asistencia eliminada correctamente'
        ], 200);
    }
}