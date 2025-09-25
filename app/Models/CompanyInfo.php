<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo CompanyInfo - Información completa de la empresa
 * 
 * Gestiona toda la información dinámica del sitio web:
 * - Datos básicos de la empresa (nombre, contacto, descripción)
 * - Redes sociales y enlaces externos
 * - Contenido de todas las secciones del home (About, Features, Services, Quote, Facts, Testimonials)
 * - Toggles para activar/desactivar módulos completos
 * - Imágenes e iconos de todas las secciones
 * 
 * @property string $name Nombre de la empresa
 * @property string $logo Ruta del logo
 * @property string $phone Teléfono de contacto
 * @property string $email Email de contacto
 * @property string $address Dirección física
 * @property string $description Descripción de la empresa
 * @property int $founded_year Año de fundación
 * @property bool $slides_enabled Toggle para carousel
 * @property bool $services_enabled Toggle para servicios
 * @property bool $testimonials_enabled Toggle para testimonios
 * @property bool $facts_enabled Toggle para estadísticas
 */
class CompanyInfo extends Model
{
    /**
     * Campos asignables masivamente
     * Incluye toda la información dinámica del sitio web
     */
    protected $fillable = [
        'name',           // Nombre de la empresa
        'logo',           // Ruta del archivo de logo
        'phone',          // Teléfono de contacto
        'email',          // Email de contacto
        'address',        // Dirección física
        'description',    // Descripción de la empresa
        'founded_year',   // Año de fundación
        'facebook_url',   // URL de Facebook
        'twitter_url',    // URL de Twitter
        'instagram_url',  // URL de Instagram
        'linkedin_url',   // URL de LinkedIn
        'youtube_url',    // URL de YouTube
        // Sección About
        'about_title',    // Título de la sección About
        'about_description', // Descripción de la sección About
        'feature_1_title', // Título de característica 1
        'feature_1_icon',  // Icono de característica 1
        'feature_2_title', // Título de característica 2
        'feature_2_icon',  // Icono de característica 2
        'about_image_1',   // Imagen 1 de About (cuadrada)
        'about_image_2',   // Imagen 2 de About (cuadrada)
        'about_image_3',   // Imagen 3 de About (cuadrada)
        'about_image_4',   // Imagen 4 de About (cuadrada)
        // Sección Features
        'features_title',      // Título principal de Features
        'features_description', // Descripción principal de Features
        'feature_1_description', // Descripción de característica 1
        'feature_description_1_icon', // Icono de descripción 1
        'feature_2_description', // Descripción de característica 2
        'feature_description_2_icon', // Icono de descripción 2
        'feature_3_description', // Descripción de característica 3
        'feature_description_3_icon', // Icono de descripción 3
        'features_image',      // Imagen principal de Features
        // Sección Services
        'services_title',      // Título de la sección Services
        'services_subtitle',   // Subtítulo de la sección Services
        // Sección Quote
        'quote_title',         // Título de la sección Quote
        'quote_description',   // Descripción de la sección Quote
        'quote_button_text',   // Texto del botón Quote
        'quote_button_url',    // URL del botón Quote
        'quote_bg_image_1',    // Imagen de fondo 1 Quote
        'quote_bg_image_2',    // Imagen de fondo 2 Quote
        'quote_form_name_label',    // Etiqueta campo nombre
        'quote_form_email_label',   // Etiqueta campo email
        'quote_form_phone_label',   // Etiqueta campo teléfono
        'quote_form_service_label', // Etiqueta campo servicio
        'quote_form_message_label', // Etiqueta campo mensaje
        'quote_form_button_text',   // Texto botón formulario
        // Toggles de módulos
        'slides_enabled',      // Activar/desactivar carousel
        'services_enabled',    // Activar/desactivar servicios
        'testimonials_enabled', // Activar/desactivar testimonios
        'facts_enabled',       // Activar/desactivar facts
        // Sección Facts
        'facts_clients_count',  // Número clientes
        'facts_clients_label',  // Etiqueta clientes
        'facts_projects_count', // Número proyectos
        'facts_projects_label', // Etiqueta proyectos
        'facts_experts_count',  // Número expertos
        'facts_experts_label',  // Etiqueta expertos
        'facts_support_count',  // Número soporte
        'facts_support_label',  // Etiqueta soporte
        // Sección Testimonials
        'testimonials_title',   // Título testimonios
        // Feature 3 title
        'feature_3_title',      // Título característica 3
    ];

    /**
     * Conversiones automáticas de tipos de datos
     * 
     * Laravel convertirá automáticamente estos campos:
     * - founded_year: string -> integer
     * - *_enabled: string -> boolean (para los toggles de módulos)
     */
    protected $casts = [
        'founded_year' => 'integer',
        'slides_enabled' => 'boolean',
        'services_enabled' => 'boolean', 
        'testimonials_enabled' => 'boolean',
        'facts_enabled' => 'boolean',
    ];
}