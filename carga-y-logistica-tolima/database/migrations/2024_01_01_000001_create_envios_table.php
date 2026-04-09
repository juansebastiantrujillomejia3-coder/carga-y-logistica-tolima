<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->string('numero_guia', 50)->unique()->index();
            $table->enum('estado', ['pendiente', 'en_transito', 'entregado', 'devuelto', 'cancelado'])
                  ->default('pendiente');
            $table->string('remitente', 150);
            $table->string('destinatario', 150);
            $table->string('ciudad_origen', 100);
            $table->string('ciudad_destino', 100);
            $table->string('direccion_destino', 255);
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamp('fecha_entrega_estimada')->nullable();
            $table->decimal('peso_kg', 8, 2)->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
