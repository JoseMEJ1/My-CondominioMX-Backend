<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    protected $table = 'motivos';

    protected $fillable = [
        'motivo'
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_motivo');
    }
}