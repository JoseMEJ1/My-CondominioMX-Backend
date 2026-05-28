<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PersonaController;
use App\Http\Controllers\API\DepartamentoController;
use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\CarroController;
use App\Http\Controllers\API\ControlController;
use App\Http\Controllers\API\PagoController;
use App\Http\Controllers\API\ReporteController;
use App\Http\Controllers\API\GastoController;
use App\Http\Controllers\API\MensajeController;
use App\Http\Controllers\API\EventoController;
use App\Http\Controllers\API\PreguntaController;
use App\Http\Controllers\API\RespuestaController;
use App\Http\Controllers\API\AsistenciaController;
use App\Http\Controllers\API\MantenimientoController;
use App\Http\Controllers\API\NotificacionController;


Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('personas', PersonaController::class);

    Route::apiResource('departamentos', DepartamentoController::class);

    Route::apiResource('usuarios', UsuarioController::class);

    Route::apiResource('carros', CarroController::class);

    Route::apiResource('controles', ControlController::class);

    Route::apiResource('pagos', PagoController::class);

    Route::apiResource('reportes', ReporteController::class);

    Route::apiResource('gastos', GastoController::class);

    Route::apiResource('mensajes', MensajeController::class);

    Route::apiResource('eventos', EventoController::class);

    Route::apiResource('preguntas', PreguntaController::class);

    Route::apiResource('respuestas', RespuestaController::class);

    Route::get(
        'estadisticas/{id_pregunta}',
        [RespuestaController::class, 'estadisticas']
    );

    Route::apiResource('asistencia', AsistenciaController::class);

    Route::apiResource('mantenimiento', MantenimientoController::class);

    Route::apiResource('notificaciones', NotificacionController::class);

    Route::get(
        'notificaciones/usuario/{id_usuario}',
        [NotificacionController::class, 'usuario']
    );

    Route::get(
        'notificaciones/no-leidas/{id_usuario}',
        [NotificacionController::class, 'noLeidas']
    );

    Route::put(
        'notificaciones/marcar-leida/{id}',
        [NotificacionController::class, 'marcarLeida']
    );
});