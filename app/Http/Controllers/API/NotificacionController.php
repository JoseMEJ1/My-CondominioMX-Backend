<?php

namespace App\Http\Controllers\API;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Events\NuevaNotificacionEvent;

class NotificacionController extends Controller
{

    public function index()
    {
        $notificaciones = Notificacion::with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notificaciones
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id_usuario' => 'required|exists:usuarios,id',

            'tipo' => 'required|string|max:50',

            'titulo' => 'required|string|max:255',

            'mensaje' => 'required|string',

            'ruta' => 'nullable|string'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $notificacion = Notificacion::create([

            'id_usuario' => $request->id_usuario,

            'tipo' => $request->tipo,

            'titulo' => $request->titulo,

            'mensaje' => $request->mensaje,

            'ruta' => $request->ruta,

            'leida' => false

        ]);

        $notificacion->load('usuario');

        broadcast(new NuevaNotificacionEvent($notificacion))->toOthers();


        return response()->json([
            'success' => true,
            'message' => 'Notificación creada correctamente',
            'data' => $notificacion
        ], 201);
    }


    public function show(string $id)
    {
        $notificacion = Notificacion::with('usuario')->find($id);

        if (!$notificacion) {

            return response()->json([
                'success' => false,
                'message' => 'Notificación no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $notificacion
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {

            return response()->json([
                'success' => false,
                'message' => 'Notificación no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'tipo' => 'required|string|max:50',

            'titulo' => 'required|string|max:255',

            'mensaje' => 'required|string',

            'ruta' => 'nullable|string',

            'leida' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $notificacion->update([

            'tipo' => $request->tipo,

            'titulo' => $request->titulo,

            'mensaje' => $request->mensaje,

            'ruta' => $request->ruta,

            'leida' => $request->leida

        ]);

        $notificacion->load('usuario');

        return response()->json([
            'success' => true,
            'message' => 'Notificación actualizada correctamente',
            'data' => $notificacion
        ], 200);
    }

    public function destroy(string $id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {

            return response()->json([
                'success' => false,
                'message' => 'Notificación no encontrada'
            ], 404);
        }

        $notificacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificación eliminada correctamente'
        ], 200);
    }

    public function marcarLeida(string $id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {

            return response()->json([
                'success' => false,
                'message' => 'Notificación no encontrada'
            ], 404);
        }

        $notificacion->update([
            'leida' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notificación marcada como leída',
            'data' => $notificacion
        ], 200);
    }
    public function usuario(string $id_usuario)
    {
        $notificaciones = Notificacion::with('usuario')
            ->where('id_usuario', $id_usuario)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notificaciones
        ], 200);
    }

    public function noLeidas(string $id_usuario)
    {
        $cantidad = Notificacion::where('id_usuario', $id_usuario)
            ->where('leida', false)
            ->count();

        return response()->json([
            'success' => true,
            'no_leidas' => $cantidad
        ], 200);
    }
}