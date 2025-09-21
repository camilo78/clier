<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para gestionar slides del carousel principal
 * Maneja información, orden, estado y botones de acción
 */
class Slide extends Model
{
    // Campos asignables masivamente
    protected $fillable = [
        'title',        // Título principal
        'subtitle',     // Subtítulo opcional
        'image',        // Ruta de imagen
        'button_text',  // Texto del botón
        'button_url',   // URL del botón
        'order',        // Orden de visualización
        'is_active',    // Estado activo/inactivo
    ];

    // Conversión automática de tipos
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scope: solo slides activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: ordenados por campo order
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Scope: búsqueda por título
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'LIKE', "%{$term}%");
    }
}