<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use Illuminate\Database\Seeder;

class CompanyInfoSeeder extends Seeder
{
    public function run(): void
    {
        CompanyInfo::create([
            'name' => 'Clier',
            'logo' => 'img/logo.png',
            'phone' => '+504 8780-8572',
            'email' => 'clier.hn@gmail.com',
            'address' => 'Residencial Vistas de Satuyé, La Ceiba, Atlántida, Honduras',
            'description' => 'Clier es tu socio confiable en climatización desde 2020. Especialistas en instalación, mantenimiento y reparación de sistemas de aire acondicionado y otros servicios ténicos para hogares y empresas.',
            'founded_year' => 2020,
            'facebook_url'  => 'https://www.facebook.com/',
            'twitter_url'   => 'https://twitter.com/',
            'instagram_url' => 'https://www.instagram.com/',
            'linkedin_url'  => 'https://www.linkedin.com/in/',
            'youtube_url'   => 'https://www.youtube.com/',
            // Sección About
            'about_title' => 'Bienvenido al Mejor Centro de Servicios de Climatización',
            'about_description' => 'Contamos con técnicos altamente capacitados y equipos de última generación para brindar el mejor servicio de climatización. Nuestra experiencia y compromiso nos posicionan como líderes en el sector.',
            'feature_1_title' => 'Técnico Experto',
            'feature_1_icon' => 'img/icon/icon-07-primary.png',
            'feature_2_title' => 'Servicios de Mejor Calidad',
            'feature_2_icon' => 'img/icon/icon-09-primary.png',
            'about_image_1' => 'img/about-1.jpg',
            'about_image_2' => 'img/about-2.jpg',
            'about_image_3' => 'img/about-3.jpg',
            'about_image_4' => 'img/about-4.jpg',
            // Sección Features
            'features_title' => '¡Algunas Razones Por Las Que La Gente Nos Elige!',
            'features_description' => 'Somos una empresa comprometida con la excelencia en el servicio, ofreciendo soluciones integrales de climatización con la mejor relación calidad-precio del mercado.',
            'feature_1_description' => 'Más de 5 años de experiencia nos respaldan como el centro de servicio más confiable de la región.',
            'feature_2_description' => 'Ofrecemos los mejores precios del mercado sin comprometer la calidad de nuestros servicios.',
            'feature_3_description' => 'Estamos disponibles las 24 horas del día, los 7 días de la semana para atender tus emergencias.',
            'feature_description_1_icon' => 'img/icon/icon-08-light.png',
            'feature_description_2_icon' => 'img/icon/icon-10-light.png',
            'feature_description_3_icon' => 'img/icon/icon-06-light.png',
            'features_image' => 'img/feature.jpg',
            // Sección Services
            'services_title' => 'Brindamos Servicios Profesionales de Refrigeración y Más',
            'services_subtitle' => 'Nuestro equipo de expertos está listo para atender todas tus necesidades de climatización con la máxima calidad y profesionalismo.',
            // Sección Quote
            'quote_title' => 'Para Particulares y Organizaciones',
            'quote_description' => 'Ofrecemos servicios especializados tanto para hogares como para empresas, adaptándonos a las necesidades específicas de cada cliente con soluciones personalizadas.',
            'quote_button_text' => 'Contáctanos',
            'quote_button_url' => '/contacts',
            'quote_bg_image_1' => 'img/carousel-1.jpg',
            'quote_bg_image_2' => 'img/carousel-2.jpg',
            // Toggles de módulos
            'slides_enabled' => true,
            'services_enabled' => true,
            'testimonials_enabled' => true,
            'facts_enabled' => true,
            // Sección Facts
            'facts_clients_count' => '1234',
            'facts_clients_label' => 'Clientes Satisfechos',
            'facts_projects_count' => '567',
            'facts_projects_label' => 'Proyectos Completados',
            'facts_experts_count' => '89',
            'facts_experts_label' => 'Técnicos Expertos',
            'facts_support_count' => '24',
            'facts_support_label' => 'Soporte 24/7',
            'facts_bg_image' => 'img/carousel-1.jpg',
            // Sección Testimonials
            'testimonials_title' => 'Lo Que Dicen Sobre Nuestros Servicios',
            // Feature 3 title
            'feature_3_title' => 'Soporte 24/7',
            // Formulario Quote
            'quote_form_name_label' => 'Tu Nombre',
            'quote_form_email_label' => 'Tu Email',
            'quote_form_phone_label' => 'Tu Móvil',
            'quote_form_service_label' => 'Tipo de Servicio',
            'quote_form_message_label' => 'Mensaje',
            'quote_form_button_text' => 'Obtener Cotización Gratuita',
        ]);
    }
}