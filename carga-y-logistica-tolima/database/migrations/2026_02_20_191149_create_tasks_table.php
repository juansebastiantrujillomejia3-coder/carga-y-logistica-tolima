<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // autoincremental

            $table->string('title'); // Título de la tarea
            $table->text('descripcion')->nulable(); // Descripción opcional

            $table->boolean('completed')->default(false); // Estado
            $table->date('due_date')->nullable(); // Fecha límite opcional

            $table->timestamps(); // crated_at y update_at

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
