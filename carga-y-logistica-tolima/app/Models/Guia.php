<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Guia - SCRUM-6
 * Representa una guía de envío asociada a una planilla 23M&M
 */
class Guia extends Model
{
    use HasFactory;

    protected $table = 'guias';

    protected $fillable = [
        'planilla_id',
        'numero_guia',
        'fecha_admision',
        'referencia',
        'remitente_nombre',
        'remitente_direccion',
        'remitente_ciudad',
        'remitente_telefono',
        'remitente_cedula',
        'remitente_codigo_postal',
        'destinatario_nombre',
        'destinatario_direccion',
        'destinatario_ciudad',
        'destinatario_telefono',
        'destinatario_cedula',
        'destinatario_codigo_postal',
        'destinatario_zona',
        'descripcion_contenido',
        'unidades',
        'peso_real_kg',
        'peso_volumetrico_kg',
        'peso_cobrar_kg',
        'valor_declarado',
        'flete',
        'manejo',
        'otros',
        'total_fletes',
        'valor_recaudo',
        'estado_paquete',
        'novedad_descripcion',
        'estado',
        'registrado_por',
    ];

    protected $casts = [
        'fecha_admision'       => 'datetime',
        'peso_real_kg'         => 'decimal:3',
        'peso_volumetrico_kg'  => 'decimal:3',
        'peso_cobrar_kg'       => 'decimal:3',
        'valor_declarado'      => 'decimal:2',
        'flete'                => 'decimal:2',
        'manejo'               => 'decimal:2',
        'otros'                => 'decimal:2',
        'total_fletes'         => 'decimal:2',
        'valor_recaudo'        => 'decimal:2',
    ];

    // Relaciones
    public function planilla()
    {
        return $this->belongsTo(Planilla::class);
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    // Calcular total automáticamente
    public function calcularTotal(): float
    {
        return (float)$this->flete + (float)$this->manejo + (float)$this->otros;
    }
}
