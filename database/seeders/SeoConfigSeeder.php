<?php

namespace Database\Seeders;

use App\Models\SeoConfig;
use Illuminate\Database\Seeder;

class SeoConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeoConfig::create([
            // Información general del sitio
            'site_name' => 'Clier - Servicios de Climatización',
            'site_description' => 'Clier es tu socio confiable en climatización desde 2020. Especialistas en instalación, mantenimiento y reparación de sistemas de aire acondicionado para hogares y empresas en La Ceiba, Honduras.',
            'default_og_image' => 'img/logo.png',

            // Configuración de redes sociales
            'twitter_card_type' => 'summary_large_image',
            'twitter_site' => '@clier_hn',

            // Scripts de seguimiento (vacíos por defecto, el usuario los configurará)
            'google_analytics_id' => null,
            'google_tag_manager_id' => null,
            'facebook_pixel_id' => null,

            // Verificaciones de motores de búsqueda (vacíos, el usuario los configurará)
            'google_site_verification' => null,
            'bing_site_verification' => null,

            // Configuración de robots y SEO
            'robots_default' => 'index, follow',
            'canonical_url_base' => url('/'),
            'sitemap_enabled' => true,
            'structured_data_enabled' => true,
        ]);
    }
}
