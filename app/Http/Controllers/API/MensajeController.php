<?php

namespace App\Http\Controllers\API;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Events\NuevoMensajeEvent;

class MensajeController extends Controller
{

    public function index()
    {
        $mensajes = Mensaje::with([
            'remitentePersona',
            'destinatarioPersona',
            'departamentoA',
            'departamentoB'
        ])
        ->orderBy('fecha', 'asc')
        ->get()
        ->map(function ($m) {

            return [
                'id' => $m->id,
                'mensaje' => $m->mensaje,
                'fecha' => $m->fecha,

                'remitente' => $m->remitentePersona ? [
                    'id' => $m->remitentePersona->id,
                    'nombre' => $m->remitentePersona->nombre,
                ] : null,

                'destinatario' => $m->destinatarioPersona ? [
                    'id' => $m->destinatarioPersona->id,
                    'nombre' => $m->destinatarioPersona->nombre,
                ] : null,

                'id_depaA' => $m->id_depaA,
                'id_depaB' => $m->id_depaB,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $mensajes
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'remitente' => 'required|exists:personas,id',
            'destinatario' => 'required|exists:personas,id',
            'id_depaA' => 'required|exists:departamentos,id',
            'id_depaB' => 'required|exists:departamentos,id',
            'mensaje' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $mensaje = Mensaje::create([
            'remitente' => $request->remitente,
            'destinatario' => $request->destinatario,
            'id_depaA' => $request->id_depaA,
            'id_depaB' => $request->id_depaB,
            'mensaje' => $request->mensaje,
            'fecha' => now()
        ]);

        $mensaje->load([
            'remitentePersona',
            'destinatarioPersona',
            'departamentoA',
            'departamentoB'
        ]);

        event(new NuevoMensajeEvent($mensaje));

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente',
            'data' => [
                'id' => $mensaje->id,
                'mensaje' => $mensaje->mensaje,
                'fecha' => $mensaje->fecha,

                'remitente' => $mensaje->remitentePersona ? [
                    'id' => $mensaje->remitentePersona->id,
                    'nombre' => $mensaje->remitentePersona->nombre,
                ] : null,

                'destinatario' => $mensaje->destinatarioPersona ? [
                    'id' => $mensaje->destinatarioPersona->id,
                    'nombre' => $mensaje->destinatarioPersona->nombre,
                ] : null,
            ]
        ], 201);
    }


    public function show(string $id)
    {
        $mensaje = Mensaje::with([
            'remitentePersona',
            'destinatarioPersona',
            'departamentoA',
            'departamentoB'
        ])->find($id);

        if (!$mensaje) {

            return response()->json([
                'success' => false,
                'message' => 'Mensaje no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $mensaje
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR MENSAJE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, string $id)
    {
        $mensaje = Mensaje::find($id);

        if (!$mensaje) {

            return response()->json([
                'success' => false,
                'message' => 'Mensaje no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'mensaje' => 'required|string|max:1000'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $mensaje->update([

            'mensaje' => $request->mensaje

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje actualizado correctamente',
            'data' => $mensaje
        ], 200);
    }

    public function destroy(string $id)
    {
        $mensaje = Mensaje::find($id);

        if (!$mensaje) {

            return response()->json([
                'success' => false,
                'message' => 'Mensaje no encontrado'
            ], 404);
        }

        $mensaje->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mensaje eliminado correctamente'
        ], 200);
    }
}