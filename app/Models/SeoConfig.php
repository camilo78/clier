<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo SeoConfig - Configuración global de SEO
 *
 * Gestiona toda la configuración SEO del sitio web:
 * - Información general del sitio (nombre, descripción, imagen OG por defecto)
 * - Configuración de redes sociales (Twitter Card)
 * - Scripts de seguimiento (Google Analytics, GTM, Facebook Pixel)
 * - Verificaciones de motores de búsqueda
 * - Configuración de robots y comportamiento SEO global
 *
 * @property string $site_name Nombre del sitio
 * @property string $site_description Descripción general del sitio
 * @property string $default_og_image Imagen Open Graph por defecto
 * @property string $twitter_card_type Tipo de tarjeta Twitter
 * @property string $twitter_site Usuario de Twitter del sitio
 * @property string $google_analytics_id ID de Google Analytics
 * @property string $google_tag_manager_id ID de Google Tag Manager
 * @property string $facebook_pixel_id ID de Facebook Pixel
 * @property string $google_site_verification Meta tag de verificación Google
 * @property string $bing_site_verification Meta tag de verificación Bing
 * @property string $robots_default Robots por defecto
 * @property string $canonical_url_base URL base canónica
 * @property bool $sitemap_enabled Habilitar sitemap automático
 * @property bool $structured_data_enabled Habilitar datos estructurados
 */
class SeoConfig extends Model
{
    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'site_name',
        'site_description',
        'default_og_image',
        'site_logo',
        'site_favicon',
        'site_logo_alt',
        'contact_email',
        'contact_phone',
        'contact_address',
        'country',
        'language',
        'twitter_card_type',
        'twitter_site',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
        'whatsapp_number',
        'primary_color',
        'secondary_color',
        'google_analytics_id',
        'google_tag_manager_id',
        'facebook_pixel_id',
        'google_site_verification',
        'bing_site_verification',
        'robots_default',
        'canonical_url_base',
        'sitemap_enabled',
        'structured_data_enabled',
        'author',
        'copyright',
        'established_year',
    ];

    /**
     * Conversiones automáticas de tipos de datos
     */
    protected $casts = [
        'sitemap_enabled' => 'boolean',
        'structured_data_enabled' => 'boolean',
    ];
}
