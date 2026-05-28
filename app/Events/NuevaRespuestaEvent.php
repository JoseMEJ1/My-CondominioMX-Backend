<?php

namespace App\Events;

use App\Models\Respuesta;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NuevaRespuestaEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $respuesta;

    public $estadisticas;

    public function __construct($respuesta, $estadisticas)
    {
        $this->respuesta = $respuesta;

        $this->estadisticas = $estadisticas;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('encuestas-live')
        ];
    }

    public function broadcastAs(): string
    {
        return 'nueva-respuesta';
    }
}