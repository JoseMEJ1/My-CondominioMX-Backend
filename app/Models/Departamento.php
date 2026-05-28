<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';

    protected $fillable = [
        'depa',
        'moroso',
        'codigo'
    ];

    public function personas()
    {
        return $this->hasMany(PerDep::class, 'id_depa');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_depa');
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'id_depa');
    }

    public function carros()
    {
        return $this->hasMany(Carro::class, 'id_depa');
    }

    public function controles()
    {
        return $this->hasMany(Control::class, 'id_depa');
    }
}