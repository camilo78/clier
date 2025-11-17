<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_configs', function (Blueprint $table) {
            $table->id();

            // Información general del sitio
            $table->string('site_name')->nullable();
            $table->text('site_description')->nullable();
            $table->string('default_og_image')->nullable();

            // Configuración de redes sociales
            $table->string('twitter_card_type')->default('summary_large_image');
            $table->string('twitter_site')->nullable();

            // Scripts de seguimiento
            $table->string('google_analytics_id')->nullable();
            $table->string('google_tag_manager_id')->nullable();
            $table->string('facebook_pixel_id')->nullable();

            // Verificaciones de motores de búsqueda
            $table->string('google_site_verification')->nullable();
            $table->string('bing_site_verification')->nullable();

            // Configuración de robots y SEO
            $table->string('robots_default')->default('index, follow');
            $table->string('canonical_url_base')->nullable();
            $table->boolean('sitemap_enabled')->default(true);
            $table->boolean('structured_data_enabled')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_configs');
    }
};
