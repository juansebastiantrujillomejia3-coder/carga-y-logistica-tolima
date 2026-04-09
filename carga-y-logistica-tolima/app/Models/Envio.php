<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $table = 'envios';

    protected $fillable = [
        'numero_guia',
        'estado',
        'remitente',
        'destinatario',
        'ciudad_origen',
        'ciudad_destino',
        'direccion_destino',
        'fecha_registro',
        'fecha_entrega_estimada',
        'peso_kg',
        'descripcion',
    ];

    protected $casts = [
        'fecha_registro'         => 'datetime',
        'fecha_entrega_estimada' => 'datetime',
        'peso_kg'                => 'decimal:2',
    ];
}