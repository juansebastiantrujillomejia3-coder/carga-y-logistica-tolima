<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guias', function (Blueprint $table) {
            $table->id();

            // Relación con planilla (int para coincidir con id_planilla)
            $table->unsignedInteger('planilla_id');
            $table->foreign('planilla_id')
                  ->references('id_planilla')
                  ->on('planilla')
                  ->onDelete('restrict');

            $table->string('numero_guia', 20)->unique()->index();
            $table->datetime('fecha_admision');
            $table->string('referencia', 50)->nullable();

            $table->string('remitente_nombre', 150);
            $table->string('remitente_direccion', 255);
            $table->string('remitente_ciudad', 100);
            $table->string('remitente_telefono', 20)->nullable();
            $table->string('remitente_cedula', 20)->nullable();
            $table->string('remitente_codigo_postal', 10)->nullable();

            $table->string('destinatario_nombre', 150);
            $table->string('destinatario_direccion', 255);
            $table->string('destinatario_ciudad', 100);
            $table->string('destinatario_telefono', 20)->nullable();
            $table->string('destinatario_cedula', 20)->nullable();
            $table->string('destinatario_codigo_postal', 10)->nullable();
            $table->string('destinatario_zona', 10)->nullable();

            $table->string('descripcion_contenido', 255);
            $table->integer('unidades')->default(1);

            $table->decimal('peso_real_kg', 8, 3)->default(0);
            $table->decimal('peso_volumetrico_kg', 8, 3)->nullable();
            $table->decimal('peso_cobrar_kg', 8, 3)->default(0);

            $table->decimal('valor_declarado', 12, 2)->default(0);
            $table->decimal('flete', 10, 2)->default(0);
            $table->decimal('manejo', 10, 2)->default(0);
            $table->decimal('otros', 10, 2)->default(0);
            $table->decimal('total_fletes', 10, 2)->default(0);
            $table->decimal('valor_recaudo', 10, 2)->default(0);

            $table->enum('estado_paquete', ['buen_estado', 'con_novedad'])->default('buen_estado');
            $table->text('novedad_descripcion')->nullable();
            $table->enum('estado', ['registrada', 'en_transito', 'entregada', 'devuelta', 'cancelada'])
                  ->default('registrada');

            // Sin foreign key a users para evitar conflicto de tipos
            $table->unsignedBigInteger('registrado_por')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guias');
    }
};