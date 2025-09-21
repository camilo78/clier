<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para gestionar testimonios de clientes
 * Maneja nombre, posición, contenido, imagen, calificación, orden y estado
 */
class Testimonial extends Model
{
    // Campos asignables masivamente
    protected $fillable = [
        'client_name',      // Nombre del cliente
        'client_position',  // Posición del cliente
        'content',          // Contenido del testimonio
        'image',            // Imagen del cliente
        'rating',           // Calificación (1-5)
        'order',            // Orden de visualización
        'is_active',        // Estado activo/inactivo
    ];

    // Conversión automática de tipos
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'rating' => 'integer',
    ];

    // Scope: solo testimonios activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: ordenados por campo order
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Scope: búsqueda por nombre del cliente
    public function scopeSearch($query, $term)
    {
        return $query->where('client_name', 'LIKE', "%{$term}%");
    }
}