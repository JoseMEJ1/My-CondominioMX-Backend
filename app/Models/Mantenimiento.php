<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimiento';

    protected $fillable = [
        'mes',
        'año',
        'id_depa',
        'completado',
        'monto',
        'id_pago'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_depa');
    }

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'id_pago');
    }
}