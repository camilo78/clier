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
        Schema::create('page_seo_settings', function (Blueprint $table) {
            $table->id();

            // Identificador único de la página
            $table->string('page_identifier')->unique();
            $table->string('page_name')->nullable(); // Nombre amigable de la página

            // Meta tags básicos
            $table->string('title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable(); // Legacy, pero algunas empresas lo siguen usando

            // Open Graph (Facebook, LinkedIn)
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('website');

            // Twitter Card
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();

            // SEO avanzado
            $table->string('canonical_url')->nullable();
            $table->string('robots')->nullable(); // noindex, nofollow, etc.
            $table->json('structured_data')->nullable(); // JSON-LD Schema.org

            // Control
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_seo_settings');
    }
};
