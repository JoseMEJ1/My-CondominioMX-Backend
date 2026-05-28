<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'fecha',
        'descripcion'
    ];

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'id_evento');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_evento');
    }
}