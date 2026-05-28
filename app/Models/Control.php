<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'controles';

    protected $fillable = [
        'codigo',
        'id_depa'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_depa');
    }
}