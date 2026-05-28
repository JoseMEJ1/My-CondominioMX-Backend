<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = 'tipos_pago';

    protected $fillable = [
        'tipo'
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_tipo');
    }
}