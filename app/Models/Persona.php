<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido_p',
        'apellido_m',
        'celular',
        'activo'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_persona');
    }

    public function departamentos()
    {
        return $this->hasMany(PerDep::class, 'id_persona');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_persona');
    }

    public function mensajesEnviados()
    {
        return $this->hasMany(Mensaje::class, 'remitente');
    }

    public function mensajesRecibidos()
    {
        return $this->hasMany(Mensaje::class, 'destinatario');
    }
}