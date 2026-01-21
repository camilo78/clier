<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo PageSeoSetting - Configuración SEO por página
 *
 * Gestiona la configuración SEO específica de cada página:
 * - Meta tags básicos (title, description, keywords)
 * - Open Graph para redes sociales
 * - Twitter Cards
 * - URLs canónicas
 * - Directivas de robots
 * - Datos estructurados (JSON-LD)
 *
 * @property string $page_identifier Identificador único de la página
 * @property string $page_name Nombre amigable de la página
 * @property string $title Título SEO
 * @property string $meta_description Meta descripción
 * @property string $meta_keywords Meta keywords
 * @property string $og_title Open Graph título
 * @property string $og_description Open Graph descripción
 * @property string $og_image Open Graph imagen
 * @property string $og_type Open Graph tipo
 * @property string $twitter_title Twitter título
 * @property string $twitter_description Twitter descripción
 * @property string $twitter_image Twitter imagen
 * @property string $canonical_url URL canónica
 * @property string $robots Directivas robots
 * @property array $structured_data Datos estructurados JSON-LD
 * @property bool $is_active Estado activo/inactivo
 */
class PageSeoSetting extends Model
{
    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'page_identifier',
        'page_name',
        'title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'canonical_url',
        'robots',
        'structured_data',
        'is_active',
    ];

    /**
     * Conversiones automáticas de tipos de datos
     */
    protected $casts = [
        'structured_data' => 'array',
        'is_active' => 'boolean',
    ];
}
