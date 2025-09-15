<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            
            // Campo para identificar el tipo de contacto
            $table->enum('tipo_contacto', ['persona', 'empresa'])->default('persona');
            
            // Campos comunes
            $table->string('correo');
            $table->string('telefono');
            $table->string('servicio');
            $table->text('consulta'); // Para personas, descripcion_proyecto para empresas
            
            // Campos específicos para personas
            $table->string('nombre_completo')->nullable();
            
            // Campos específicos para empresas
            $table->string('nombre_empresa')->nullable();
            $table->string('persona_contacto')->nullable();
            $table->string('cargo')->nullable();
            $table->string('ruc', 11)->nullable();
            $table->string('sector_empresa')->nullable();
            $table->enum('tamaño_empresa', ['startup', 'pequeña', 'mediana', 'grande', 'corporativa'])->nullable();
            $table->string('presupuesto_estimado', 100)->nullable();
            $table->enum('urgencia', ['baja', 'media', 'alta', 'urgente'])->nullable();
            
            $table->timestamps();
            
            // Índices para mejorar las búsquedas
            $table->index('correo');
            $table->index('tipo_contacto');
            $table->index('created_at');
            $table->index(['tipo_contacto', 'urgencia']); // Para empresas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};