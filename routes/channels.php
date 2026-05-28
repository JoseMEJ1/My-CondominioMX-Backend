<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notificaciones.{id}', function ($user, $id) {

    return true;
});

Broadcast::channel('encuestas-live', function () {
    return true;
});

Broadcast::channel('chat', function ($user) {
    return true;
});