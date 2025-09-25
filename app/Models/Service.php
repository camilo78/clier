<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para gestionar servicios de la empresa
 * Maneja nombre, descripción, imagen, icono, orden y estado
 */
class Service extends Model
{
    // Campos asignables masivamente
    protected $fillable = [
        'name',         // Nombre del servicio
        'description',  // Descripción del servicio
        'image',        // Imagen representativa
        'icon',         // Icono del servicio
        'order',        // Orden de visualización
        'is_active',    // Estado activo/inactivo
    ];

    // Conversión automática de tipos
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scope: solo servicios activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: ordenados por campo order
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Scope: búsqueda por nombre
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', "%{$term}%");
    }
}