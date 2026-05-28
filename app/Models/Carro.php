<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $table = 'carros';

    protected $fillable = [
        'id_depa',
        'placa',
        'marca',
        'modelo',
        'color'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_depa');
    }
}