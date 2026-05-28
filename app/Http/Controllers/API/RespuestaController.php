<?php

namespace App\Http\Controllers\API;

use App\Models\Respuesta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Events\NuevaRespuestaEvent;

class RespuestaController extends Controller
{

    public function index()
    {
        $respuestas = Respuesta::with([
            'pregunta',
            'asistencia'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $respuestas
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_pregunta' => 'required|exists:preguntas,id',

            'id_asistente' => 'required|exists:asistencia,id',

            'respuesta' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        $respuesta = Respuesta::create([

            'id_pregunta' => $request->id_pregunta,

            'id_asistente' => $request->id_asistente,

            'respuesta' => $request->respuesta

        ]);

        $respuesta->load([
            'pregunta',
            'asistencia'
        ]);

        $total = Respuesta::where(
            'id_pregunta',
            $request->id_pregunta
        )->count();

        $si = Respuesta::where(
            'id_pregunta',
            $request->id_pregunta
        )
        ->where('respuesta', true)
        ->count();

        $no = Respuesta::where(
            'id_pregunta',
            $request->id_pregunta
        )
        ->where('respuesta', false)
        ->count();

        $estadisticas = [

            'pregunta_id' => $request->id_pregunta,

            'total_respuestas' => $total,

            'si' => $si,

            'no' => $no

        ];

        broadcast(
            new NuevaRespuestaEvent(
                $respuesta,
                $estadisticas
            )
        )->toOthers();


        return response()->json([
            'success' => true,
            'message' => 'Respuesta registrada correctamente',
            'data' => [
                'respuesta' => $respuesta,
                'estadisticas' => $estadisticas
            ]
        ], 201);
    }

    public function show(string $id)
    {
        $respuesta = Respuesta::with([
            'pregunta',
            'asistencia'
        ])->find($id);

        if (!$respuesta) {

            return response()->json([
                'success' => false,
                'message' => 'Respuesta no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $respuesta
        ], 200);
    }


    public function update(Request $request, string $id)
    {
        $respuesta = Respuesta::find($id);

        if (!$respuesta) {

            return response()->json([
                'success' => false,
                'message' => 'Respuesta no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'id_pregunta' => 'required|exists:preguntas,id',

            'id_asistente' => 'required|exists:asistencia,id',

            'respuesta' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $respuesta->update([

            'id_pregunta' => $request->id_pregunta,

            'id_asistente' => $request->id_asistente,

            'respuesta' => $request->respuesta

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Respuesta actualizada correctamente',
            'data' => $respuesta
        ], 200);
    }


    public function destroy(string $id)
    {
        $respuesta = Respuesta::find($id);

        if (!$respuesta) {

            return response()->json([
                'success' => false,
                'message' => 'Respuesta no encontrada'
            ], 404);
        }

        $respuesta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Respuesta eliminada correctamente'
        ], 200);
    }

    public function estadisticas(string $id_pregunta)
    {
        $total = Respuesta::where(
            'id_pregunta',
            $id_pregunta
        )->count();

        $si = Respuesta::where(
            'id_pregunta',
            $id_pregunta
        )
        ->where('respuesta', true)
        ->count();

        $no = Respuesta::where(
            'id_pregunta',
            $id_pregunta
        )
        ->where('respuesta', false)
        ->count();

        return response()->json([
            'success' => true,
            'data' => [

                'pregunta_id' => $id_pregunta,

                'total_respuestas' => $total,

                'si' => $si,

                'no' => $no

            ]
        ], 200);
    }
}