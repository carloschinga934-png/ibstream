<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesibstreamcontactoTable extends Migration
{
    public function up()
    {
        Schema::create('clientesibstreamcontacto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');    // Columna para el nombre
            $table->string('telefono');  // Columna para el teléfono
            $table->timestamps();       // Campos de timestamps (created_at, updated_at)
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientesibstreamcontacto');
    }
}
