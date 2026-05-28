<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuestas';

    protected $fillable = [
        'id_pregunta',
        'id_asistente',
        'respuesta'
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'id_asistente');
    }
}