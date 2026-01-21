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
        Schema::table('seo_configs', function (Blueprint $table) {
            // Identidad de marca
            $table->string('site_logo')->nullable()->after('default_og_image');
            $table->string('site_favicon')->nullable()->after('site_logo');
            $table->string('site_logo_alt')->nullable()->after('site_favicon');

            // Información de contacto y localización
            $table->string('contact_email')->nullable()->after('site_logo_alt');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('contact_address')->nullable()->after('contact_phone');
            $table->string('country')->nullable()->after('contact_address');
            $table->string('language')->default('es')->after('country');

            // Redes sociales (URLs completas)
            $table->string('facebook_url')->nullable()->after('twitter_site');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('youtube_url')->nullable()->after('linkedin_url');
            $table->string('tiktok_url')->nullable()->after('youtube_url');
            $table->string('whatsapp_number')->nullable()->after('tiktok_url');

            // Colores de marca (para theme-color y PWA)
            $table->string('primary_color')->nullable()->after('whatsapp_number');
            $table->string('secondary_color')->nullable()->after('primary_color');

            // Configuración adicional
            $table->string('author')->nullable()->after('secondary_color');
            $table->string('copyright')->nullable()->after('author');
            $table->year('established_year')->nullable()->after('copyright');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_configs', function (Blueprint $table) {
            $table->dropColumn([
                'site_logo',
                'site_favicon',
                'site_logo_alt',
                'contact_email',
                'contact_phone',
                'contact_address',
                'country',
                'language',
                'facebook_url',
                'instagram_url',
                'linkedin_url',
                'youtube_url',
                'tiktok_url',
                'whatsapp_number',
                'primary_color',
                'secondary_color',
                'author',
                'copyright',
                'established_year',
            ]);
        });
    }
};
