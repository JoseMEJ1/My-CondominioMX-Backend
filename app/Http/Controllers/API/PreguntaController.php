<?php

namespace App\Http\Controllers\API;

use App\Models\Pregunta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PreguntaController extends Controller
{

    public function index()
    {
        $preguntas = Pregunta::with([
            'evento',
            'respuestas'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $preguntas
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'pregunta' => 'required|string|max:255',

            'id_evento' => 'required|exists:eventos,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pregunta = Pregunta::create([

            'pregunta' => $request->pregunta,

            'id_evento' => $request->id_evento

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pregunta creada correctamente',
            'data' => $pregunta
        ], 201);
    }

    public function show(string $id)
    {
        $pregunta = Pregunta::with([
            'evento',
            'respuestas'
        ])->find($id);

        if (!$pregunta) {

            return response()->json([
                'success' => false,
                'message' => 'Pregunta no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pregunta
        ], 200);
    }


    public function update(Request $request, string $id)
    {
        $pregunta = Pregunta::find($id);

        if (!$pregunta) {

            return response()->json([
                'success' => false,
                'message' => 'Pregunta no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'pregunta' => 'required|string|max:255',

            'id_evento' => 'required|exists:eventos,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pregunta->update([

            'pregunta' => $request->pregunta,

            'id_evento' => $request->id_evento

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pregunta actualizada correctamente',
            'data' => $pregunta
        ], 200);
    }


    public function destroy(string $id)
    {
        $pregunta = Pregunta::find($id);

        if (!$pregunta) {

            return response()->json([
                'success' => false,
                'message' => 'Pregunta no encontrada'
            ], 404);
        }

        $pregunta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pregunta eliminada correctamente'
        ], 200);
    }
}