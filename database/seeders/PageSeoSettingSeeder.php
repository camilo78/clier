<?php

namespace Database\Seeders;

use App\Models\PageSeoSetting;
use Illuminate\Database\Seeder;

class PageSeoSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'page_identifier' => 'home',
                'page_name' => 'Página Principal',
                'title' => 'Clier - Servicios de Climatización en La Ceiba, Honduras',
                'meta_description' => 'Especialistas en instalación, mantenimiento y reparación de sistemas de aire acondicionado. Servicio profesional 24/7 en La Ceiba, Atlántida.',
                'meta_keywords' => 'aire acondicionado, climatización, La Ceiba, Honduras, instalación AC, mantenimiento AC',
                'og_title' => 'Clier - Tu Socio Confiable en Climatización',
                'og_description' => 'Más de 5 años brindando soluciones de climatización de calidad. Técnicos expertos, mejores precios y soporte 24/7.',
                'og_image' => 'img/logo.png',
                'og_type' => 'website',
                'twitter_title' => 'Clier - Servicios de Climatización',
                'twitter_description' => 'Especialistas en climatización desde 2020. Instalación, mantenimiento y reparación de AC.',
                'twitter_image' => 'img/logo.png',
                'canonical_url' => url('/'),
                'robots' => 'index, follow',
                'structured_data' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'LocalBusiness',
                    'name' => 'Clier',
                    'description' => 'Servicios de climatización profesional',
                    'telephone' => '+504 8780-8572',
                    'email' => 'clier.hn@gmail.com',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'Residencial Vistas de Satuyé',
                        'addressLocality' => 'La Ceiba',
                        'addressRegion' => 'Atlántida',
                        'addressCountry' => 'HN',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'page_identifier' => 'contact',
                'page_name' => 'Contacto',
                'title' => 'Contacta con Clier - Atención 24/7',
                'meta_description' => 'Contáctanos para solicitar presupuesto o agendar servicio. Disponibles 24/7 en La Ceiba, Honduras. Respuesta rápida garantizada.',
                'meta_keywords' => 'contacto clier, presupuesto climatización, agendar servicio AC',
                'og_title' => 'Contáctanos - Clier Climatización',
                'og_description' => 'Solicita tu presupuesto gratuito o agenda un servicio. Atención 24/7.',
                'og_image' => 'img/logo.png',
                'og_type' => 'website',
                'twitter_title' => 'Contacta con Clier',
                'twitter_description' => 'Solicita información o agenda tu servicio. Atención personalizada 24/7.',
                'twitter_image' => 'img/logo.png',
                'canonical_url' => url('/contact'),
                'robots' => 'index, follow',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            PageSeoSetting::updateOrCreate(
                ['page_identifier' => $page['page_identifier']],
                $page
            );
        }
    }
}
