<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->integer('founded_year')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            
            // About section
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('feature_1_title')->nullable();
            $table->string('feature_1_icon')->nullable();
            $table->string('feature_2_title')->nullable();
            $table->string('feature_2_icon')->nullable();
            $table->string('about_image_1')->nullable();
            $table->string('about_image_2')->nullable();
            $table->string('about_image_3')->nullable();
            $table->string('about_image_4')->nullable();
            
            // Features section
            $table->string('features_title')->nullable();
            $table->text('features_description')->nullable();
            $table->text('feature_1_description')->nullable();
            $table->string('feature_description_1_icon')->nullable();
            $table->text('feature_2_description')->nullable();
            $table->string('feature_description_2_icon')->nullable();
            $table->text('feature_3_description')->nullable();
            $table->string('feature_description_3_icon')->nullable();
            $table->string('features_image')->nullable();
            
            // Sección Services
            $table->string('services_title')->nullable();
            $table->text('services_subtitle')->nullable();
            
            // Sección Quote
            $table->string('quote_title')->nullable();
            $table->text('quote_description')->nullable();
            $table->string('quote_button_text')->nullable();
            $table->string('quote_button_url')->nullable();
            $table->string('quote_bg_image_1')->nullable();
            $table->string('quote_bg_image_2')->nullable();
            $table->string('quote_form_name_label')->default('Tu Nombre');
            $table->string('quote_form_email_label')->default('Tu Email');
            $table->string('quote_form_phone_label')->default('Tu Móvil');
            $table->string('quote_form_service_label')->default('Tipo de Servicio');
            $table->string('quote_form_message_label')->default('Mensaje');
            $table->string('quote_form_button_text')->default('Obtener Cotización Gratuita');
            
            // Toggles para activar/desactivar módulos
            $table->boolean('slides_enabled')->default(true);
            $table->boolean('services_enabled')->default(true);
            $table->boolean('testimonials_enabled')->default(true);
            $table->boolean('facts_enabled')->default(true);
            
            // Contenido dinámico de Facts section
            $table->string('facts_clients_count')->default('1234');
            $table->string('facts_clients_label')->default('Clientes Satisfechos');
            $table->string('facts_projects_count')->default('567');
            $table->string('facts_projects_label')->default('Proyectos Completados');
            $table->string('facts_experts_count')->default('89');
            $table->string('facts_experts_label')->default('Técnicos Expertos');
            $table->string('facts_support_count')->default('24');
            $table->string('facts_support_label')->default('Soporte 24/7');
            
            // Contenido dinámico de Testimonials section
            $table->string('testimonials_title')->default('Lo Que Dicen Sobre Nuestros Servicios');
            
            // Feature 3 title
            $table->string('feature_3_title')->default('Soporte 24/7');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};