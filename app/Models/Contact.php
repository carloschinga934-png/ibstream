<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_contacto',
        'correo',
        'telefono',
        'servicio',
        'consulta',
        // Campos para personas
        'nombre_completo',
        // Campos para empresas
        'nombre_empresa',
        'persona_contacto',
        'cargo',
        'ruc',
        'sector_empresa',
        'tamaño_empresa',
        'presupuesto_estimado',
        'urgencia'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope para contactos de personas
     */
    public function scopePersonas($query)
    {
        return $query->where('tipo_contacto', 'persona');
    }

    /**
     * Scope para contactos de empresas
     */
    public function scopeEmpresas($query)
    {
        return $query->where('tipo_contacto', 'empresa');
    }

    /**
     * Scope para filtrar por urgencia (solo empresas)
     */
    public function scopeUrgencia($query, $urgencia)
    {
        return $query->where('urgencia', $urgencia);
    }

    /**
     * Accessor para obtener el nombre del contacto
     */
    public function getNombreContactoAttribute()
    {
        return $this->tipo_contacto === 'persona' 
            ? $this->nombre_completo 
            : $this->persona_contacto;
    }

    /**
     * Accessor para obtener el nombre principal (persona o empresa)
     */
    public function getNombrePrincipalAttribute()
    {
        return $this->tipo_contacto === 'persona' 
            ? $this->nombre_completo 
            : $this->nombre_empresa;
    }

    /**
     * Verificar si es contacto de empresa
     */
    public function esEmpresa()
    {
        return $this->tipo_contacto === 'empresa';
    }

    /**
     * Verificar si es contacto de persona
     */
    public function esPersona()
    {
        return $this->tipo_contacto === 'persona';
    }
}