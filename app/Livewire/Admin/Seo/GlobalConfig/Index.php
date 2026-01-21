<?php

namespace App\Livewire\Admin\Seo\GlobalConfig;

use App\Models\SeoConfig;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

/**
 * Controlador Livewire para la gestión de configuración SEO global
 *
 * Gestiona:
 * - Información general del sitio
 * - Configuración de redes sociales
 * - Scripts de seguimiento (Google Analytics, GTM, Facebook Pixel)
 * - Verificaciones de motores de búsqueda
 * - Configuración de robots y SEO global
 */
class Index extends Component
{
    use LivewireAlert, WithFileUploads;

    public $seoConfig;

    // Información general
    public $site_name;
    public $site_description;
    public $default_og_image;
    public $newDefaultOgImage;

    // Redes sociales
    public $twitter_card_type;
    public $twitter_site;

    // Scripts de seguimiento
    public $google_analytics_id;
    public $google_tag_manager_id;
    public $facebook_pixel_id;

    // Verificaciones
    public $google_site_verification;
    public $bing_site_verification;

    // Configuración SEO
    public $robots_default;
    public $canonical_url_base;
    public $sitemap_enabled = true;
    public $structured_data_enabled = true;

    public function mount()
    {
        $this->seoConfig = SeoConfig::first();

        if ($this->seoConfig) {
            $this->fill($this->seoConfig->toArray());
        }
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'twitter_card_type' => 'nullable|string|in:summary,summary_large_image',
            'twitter_site' => 'nullable|string|max:255',
            'google_analytics_id' => 'nullable|string|max:255',
            'google_tag_manager_id' => 'nullable|string|max:255',
            'facebook_pixel_id' => 'nullable|string|max:255',
            'google_site_verification' => 'nullable|string|max:255',
            'bing_site_verification' => 'nullable|string|max:255',
            'robots_default' => 'nullable|string|max:255',
            'canonical_url_base' => 'nullable|url|max:255',
        ]);

        // Procesar imagen OG por defecto
        $ogImagePath = $this->default_og_image;
        if ($this->newDefaultOgImage) {
            $ogImagePath = $this->newDefaultOgImage->store('seo', 'public');
        }

        $data = [
            'site_name' => $this->site_name,
            'site_description' => $this->site_description,
            'default_og_image' => $ogImagePath,
            'twitter_card_type' => $this->twitter_card_type,
            'twitter_site' => $this->twitter_site,
            'google_analytics_id' => $this->google_analytics_id,
            'google_tag_manager_id' => $this->google_tag_manager_id,
            'facebook_pixel_id' => $this->facebook_pixel_id,
            'google_site_verification' => $this->google_site_verification,
            'bing_site_verification' => $this->bing_site_verification,
            'robots_default' => $this->robots_default,
            'canonical_url_base' => $this->canonical_url_base,
            'sitemap_enabled' => $this->sitemap_enabled,
            'structured_data_enabled' => $this->structured_data_enabled,
        ];

        if ($this->seoConfig) {
            $this->seoConfig->update($data);
        } else {
            $this->seoConfig = SeoConfig::create($data);
        }

        // Actualizar propiedades
        if ($ogImagePath) {
            $this->default_og_image = $ogImagePath;
        }
        $this->newDefaultOgImage = null;

        $this->alert('success', 'Configuración SEO actualizada correctamente');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.seo.global-config.index');
    }
}
