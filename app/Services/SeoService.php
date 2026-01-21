<?php

namespace App\Services;

use App\Models\SeoConfig;
use App\Models\PageSeoSetting;

/**
 * Servicio SEO - Gestión centralizada de SEO
 *
 * Este servicio proporciona métodos para:
 * - Obtener configuración SEO global
 * - Obtener configuración SEO por página
 * - Generar meta tags HTML
 * - Generar datos estructurados (JSON-LD)
 */
class SeoService
{
    protected $globalConfig;

    public function __construct()
    {
        $this->globalConfig = SeoConfig::first();
    }

    /**
     * Obtiene la configuración SEO global
     *
     * @return SeoConfig|null
     */
    public function getGlobalConfig()
    {
        return $this->globalConfig;
    }

    /**
     * Obtiene la configuración SEO de una página específica
     *
     * @param string $pageIdentifier
     * @return PageSeoSetting|null
     */
    public function getPageSeo(string $pageIdentifier)
    {
        return PageSeoSetting::where('page_identifier', $pageIdentifier)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Genera todos los meta tags para una página
     *
     * @param string $pageIdentifier
     * @return array
     */
    public function getMetaTags(string $pageIdentifier): array
    {
        $pageSeo = $this->getPageSeo($pageIdentifier);
        $global = $this->globalConfig;

        if (!$pageSeo) {
            return $this->getDefaultMetaTags();
        }

        return [
            // Meta tags básicos
            'title' => $pageSeo->title ?? $global?->site_name ?? config('app.name'),
            'description' => $pageSeo->meta_description ?? $global?->site_description,
            'keywords' => $pageSeo->meta_keywords,
            'robots' => $pageSeo->robots ?? $global?->robots_default,
            'canonical' => $pageSeo->canonical_url,

            // Open Graph
            'og_title' => $pageSeo->og_title ?? $pageSeo->title ?? $global?->site_name,
            'og_description' => $pageSeo->og_description ?? $pageSeo->meta_description ?? $global?->site_description,
            'og_image' => $this->getFullImageUrl($pageSeo->og_image ?? $global?->default_og_image),
            'og_type' => $pageSeo->og_type ?? 'website',
            'og_url' => $pageSeo->canonical_url ?? url()->current(),

            // Twitter Card
            'twitter_card' => $global?->twitter_card_type ?? 'summary_large_image',
            'twitter_site' => $global?->twitter_site,
            'twitter_title' => $pageSeo->twitter_title ?? $pageSeo->title ?? $global?->site_name,
            'twitter_description' => $pageSeo->twitter_description ?? $pageSeo->meta_description ?? $global?->site_description,
            'twitter_image' => $this->getFullImageUrl($pageSeo->twitter_image ?? $pageSeo->og_image ?? $global?->default_og_image),

            // Verificaciones
            'google_site_verification' => $global?->google_site_verification,
            'bing_site_verification' => $global?->bing_site_verification,
        ];
    }

    /**
     * Genera meta tags por defecto cuando no hay configuración específica
     *
     * @return array
     */
    protected function getDefaultMetaTags(): array
    {
        $global = $this->globalConfig;

        return [
            'title' => $global?->site_name ?? config('app.name'),
            'description' => $global?->site_description,
            'robots' => $global?->robots_default ?? 'index, follow',
            'og_title' => $global?->site_name,
            'og_description' => $global?->site_description,
            'og_image' => $this->getFullImageUrl($global?->default_og_image),
            'og_type' => 'website',
            'twitter_card' => $global?->twitter_card_type,
            'twitter_site' => $global?->twitter_site,
        ];
    }

    /**
     * Obtiene los datos estructurados (JSON-LD) de una página
     *
     * @param string $pageIdentifier
     * @return array|null
     */
    public function getStructuredData(string $pageIdentifier)
    {
        if (!$this->globalConfig || !$this->globalConfig->structured_data_enabled) {
            return null;
        }

        $pageSeo = $this->getPageSeo($pageIdentifier);

        return $pageSeo?->structured_data;
    }

    /**
     * Convierte una ruta de imagen relativa a URL completa
     *
     * @param string|null $imagePath
     * @return string|null
     */
    protected function getFullImageUrl(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }

        // Si ya es una URL completa, retornarla
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        // Si empieza con 'img/', es del directorio public
        if (str_starts_with($imagePath, 'img/')) {
            return asset($imagePath);
        }

        // Si no, es del storage
        return asset('storage/' . $imagePath);
    }

    /**
     * Genera el HTML de los scripts de seguimiento
     *
     * @return array
     */
    public function getTrackingScripts(): array
    {
        if (!$this->globalConfig) {
            return [];
        }

        return [
            'google_analytics_id' => $this->globalConfig->google_analytics_id,
            'google_tag_manager_id' => $this->globalConfig->google_tag_manager_id,
            'facebook_pixel_id' => $this->globalConfig->facebook_pixel_id,
        ];
    }

    /**
     * Verifica si el sitemap está habilitado
     *
     * @return bool
     */
    public function isSitemapEnabled(): bool
    {
        return $this->globalConfig?->sitemap_enabled ?? false;
    }

    /**
     * Verifica si los datos estructurados están habilitados
     *
     * @return bool
     */
    public function isStructuredDataEnabled(): bool
    {
        return $this->globalConfig?->structured_data_enabled ?? false;
    }

    /**
     * Obtiene la URL del logo del sitio
     *
     * @return string|null
     */
    public function getSiteLogo(): ?string
    {
        return $this->getFullImageUrl($this->globalConfig?->site_logo);
    }

    /**
     * Obtiene la URL del favicon del sitio
     *
     * @return string|null
     */
    public function getSiteFavicon(): ?string
    {
        return $this->getFullImageUrl($this->globalConfig?->site_favicon);
    }

    /**
     * Obtiene los colores de marca
     *
     * @return array
     */
    public function getBrandColors(): array
    {
        return [
            'primary' => $this->globalConfig?->primary_color,
            'secondary' => $this->globalConfig?->secondary_color,
        ];
    }

    /**
     * Obtiene la información de contacto
     *
     * @return array
     */
    public function getContactInfo(): array
    {
        return [
            'email' => $this->globalConfig?->contact_email,
            'phone' => $this->globalConfig?->contact_phone,
            'address' => $this->globalConfig?->contact_address,
            'country' => $this->globalConfig?->country,
        ];
    }

    /**
     * Obtiene las URLs de redes sociales
     *
     * @return array
     */
    public function getSocialMedia(): array
    {
        return [
            'facebook' => $this->globalConfig?->facebook_url,
            'instagram' => $this->globalConfig?->instagram_url,
            'twitter' => $this->globalConfig?->twitter_site,
            'linkedin' => $this->globalConfig?->linkedin_url,
            'youtube' => $this->globalConfig?->youtube_url,
            'tiktok' => $this->globalConfig?->tiktok_url,
            'whatsapp' => $this->globalConfig?->whatsapp_number,
        ];
    }

    /**
     * Genera los datos estructurados de la organización (JSON-LD)
     *
     * @return array|null
     */
    public function getOrganizationStructuredData(): ?array
    {
        if (!$this->globalConfig || !$this->globalConfig->structured_data_enabled) {
            return null;
        }

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->globalConfig->site_name ?? config('app.name'),
        ];

        if ($this->globalConfig->site_description) {
            $data['description'] = $this->globalConfig->site_description;
        }

        if ($this->globalConfig->site_logo) {
            $data['logo'] = $this->getSiteLogo();
        }

        if ($this->globalConfig->canonical_url_base) {
            $data['url'] = $this->globalConfig->canonical_url_base;
        }

        if ($this->globalConfig->contact_email) {
            $data['email'] = $this->globalConfig->contact_email;
        }

        if ($this->globalConfig->contact_phone) {
            $data['telephone'] = $this->globalConfig->contact_phone;
        }

        if ($this->globalConfig->contact_address) {
            $data['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->globalConfig->contact_address,
                'addressCountry' => $this->globalConfig->country ?? 'HN',
            ];
        }

        // Redes sociales
        $socialLinks = array_filter([
            $this->globalConfig->facebook_url,
            $this->globalConfig->instagram_url,
            $this->globalConfig->linkedin_url,
            $this->globalConfig->youtube_url,
            $this->globalConfig->tiktok_url,
        ]);

        if (!empty($socialLinks)) {
            $data['sameAs'] = array_values($socialLinks);
        }

        if ($this->globalConfig->established_year) {
            $data['foundingDate'] = $this->globalConfig->established_year;
        }

        return $data;
    }
}
