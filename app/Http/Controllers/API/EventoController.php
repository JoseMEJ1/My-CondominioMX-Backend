<?php

namespace App\Http\Controllers\API;

use App\Models\Evento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{

    public function index()
    {
        $eventos = Evento::with([
            'preguntas',
            'asistencias'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $eventos
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'fecha' => 'required|date',

            'descripcion' => 'required|string|max:255'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $evento = Evento::create([

            'fecha' => $request->fecha,

            'descripcion' => $request->descripcion

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Evento creado correctamente',
            'data' => $evento
        ], 201);
    }

    public function show(string $id)
    {
        $evento = Evento::with([
            'preguntas',
            'asistencias'
        ])->find($id);

        if (!$evento) {

            return response()->json([
                'success' => false,
                'message' => 'Evento no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $evento
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {

            return response()->json([
                'success' => false,
                'message' => 'Evento no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'fecha' => 'required|date',

            'descripcion' => 'required|string|max:255'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $evento->update([

            'fecha' => $request->fecha,

            'descripcion' => $request->descripcion

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Evento actualizado correctamente',
            'data' => $evento
        ], 200);
    }

    public function destroy(string $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {

            return response()->json([
                'success' => false,
                'message' => 'Evento no encontrado'
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Evento eliminado correctamente'
        ], 200);
    }
}