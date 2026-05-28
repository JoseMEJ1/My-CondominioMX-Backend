<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'id_depa',
        'monto',
        'id_tipo',
        'fecha',
        'id_motivo',
        'descripcion',
        'comprobante',
        'efectuado',
        'id_reporte'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_depa');
    }

    public function tipoPago()
    {
        return $this->belongsTo(TipoPago::class, 'id_tipo');
    }

    public function motivo()
    {
        return $this->belongsTo(Motivo::class, 'id_motivo');
    }

    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'id_reporte');
    }

    public function mantenimiento()
    {
        return $this->hasOne(Mantenimiento::class, 'id_pago');
    }
}