<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencia';

    protected $fillable = [
        'id_persona',
        'id_evento',
        'hora'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'id_asistente');
    }
}