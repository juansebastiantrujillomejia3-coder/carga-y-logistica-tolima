<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table = 'planilla';
    protected $primaryKey = 'id_planilla';
    public $timestamps = false;

    protected $fillable = [
        'id_planilla',
        'fecha_envio',
        'estado',
        'id_empresa',
    ];

    public function guias()
    {
        return $this->hasMany(Guia::class, 'planilla_id', 'id_planilla');
    }
}