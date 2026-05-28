<?php

namespace App\Events;

use App\Models\Mensaje;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevoMensajeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mensaje;

    public function __construct(Mensaje $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('chat'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'nuevo.mensaje';
    }

    public function broadcastWith(): array
    {
        return [

            'id' => $this->mensaje->id,

            'mensaje' => $this->mensaje->mensaje,

            'fecha' => $this->mensaje->fecha,

            'remitente' => $this->mensaje->remitentePersona
                ? [
                    'id' => $this->mensaje->remitentePersona->id,
                    'nombre' => $this->mensaje->remitentePersona->nombre,
                ]
                : null,

            'destinatario' => $this->mensaje->destinatarioPersona
                ? [
                    'id' => $this->mensaje->destinatarioPersona->id,
                    'nombre' => $this->mensaje->destinatarioPersona->nombre,
                ]
                : null,
        ];
    }
}