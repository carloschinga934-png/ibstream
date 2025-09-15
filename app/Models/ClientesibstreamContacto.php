<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientesibstreamContacto extends Model
{
    use HasFactory;

    protected $table = 'clientesibstreamcontacto';  // Especifica la tabla a utilizar

    protected $fillable = [
        'nombre',   // Permite asignar masivamente el nombre
        'telefono', // Permite asignar masivamente el teléfono
    ];
}
