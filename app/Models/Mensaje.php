<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';

    protected $fillable = [
        'remitente',
        'destinatario',
        'id_depaA',
        'id_depaB',
        'mensaje',
        'fecha'
    ];

    public function remitentePersona()
    {
        return $this->belongsTo(Persona::class, 'remitente');
    }

    public function destinatarioPersona()
    {
        return $this->belongsTo(Persona::class, 'destinatario');
    }

    public function departamentoA()
    {
        return $this->belongsTo(Departamento::class, 'id_depaA');
    }

    public function departamentoB()
    {
        return $this->belongsTo(Departamento::class, 'id_depaB');
    }
}