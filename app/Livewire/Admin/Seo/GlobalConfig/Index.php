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

    // Identidad de marca
    public $site_logo;
    public $site_favicon;
    public $site_logo_alt;
    public $newSiteLogo;
    public $newSiteFavicon;

    // Información de contacto
    public $contact_email;
    public $contact_phone;
    public $contact_address;
    public $country;
    public $language = 'es';

    // Redes sociales
    public $twitter_card_type = 'summary_large_image';
    public $twitter_site;
    public $facebook_url;
    public $instagram_url;
    public $linkedin_url;
    public $youtube_url;
    public $tiktok_url;
    public $whatsapp_number;

    // Colores de marca
    public $primary_color;
    public $secondary_color;

    // Scripts de seguimiento
    public $google_analytics_id;
    public $google_tag_manager_id;
    public $facebook_pixel_id;

    // Verificaciones
    public $google_site_verification;
    public $bing_site_verification;

    // Configuración SEO
    public $robots_default = 'index, follow';
    public $canonical_url_base;
    public $sitemap_enabled = true;
    public $structured_data_enabled = true;
    public $author;
    public $copyright;
    public $established_year;

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
            'site_logo_alt' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'country' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:10',
            'twitter_card_type' => 'nullable|string|in:summary,summary_large_image',
            'twitter_site' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'whatsapp_number' => 'nullable|string|max:50',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'google_analytics_id' => 'nullable|string|max:255',
            'google_tag_manager_id' => 'nullable|string|max:255',
            'facebook_pixel_id' => 'nullable|string|max:255',
            'google_site_verification' => 'nullable|string|max:255',
            'bing_site_verification' => 'nullable|string|max:255',
            'robots_default' => 'nullable|string|max:255',
            'canonical_url_base' => 'nullable|url|max:255',
            'author' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'newDefaultOgImage' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'newSiteLogo' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp,svg',
            'newSiteFavicon' => 'nullable|image|max:512|mimes:ico,png',
        ], [
            'contact_email.email' => 'El email de contacto debe ser una dirección válida',
            'facebook_url.url' => 'La URL de Facebook debe ser válida',
            'instagram_url.url' => 'La URL de Instagram debe ser válida',
            'linkedin_url.url' => 'La URL de LinkedIn debe ser válida',
            'youtube_url.url' => 'La URL de YouTube debe ser válida',
            'tiktok_url.url' => 'La URL de TikTok debe ser válida',
            'canonical_url_base.url' => 'La URL base canónica debe ser válida',
            'established_year.integer' => 'El año de fundación debe ser un número',
            'established_year.min' => 'El año de fundación debe ser mayor a 1900',
            'established_year.max' => 'El año de fundación no puede ser mayor al año actual',
            'newDefaultOgImage.image' => 'El archivo debe ser una imagen válida',
            'newDefaultOgImage.max' => 'La imagen no debe ser mayor a 2MB',
            'newSiteLogo.image' => 'El logo debe ser una imagen válida',
            'newSiteLogo.max' => 'El logo no debe ser mayor a 2MB',
            'newSiteFavicon.image' => 'El favicon debe ser una imagen válida',
            'newSiteFavicon.max' => 'El favicon no debe ser mayor a 512KB',
        ]);

        // Procesar imágenes
        $ogImagePath = $this->default_og_image;
        if ($this->newDefaultOgImage) {
            $ogImagePath = $this->newDefaultOgImage->store('seo', 'public');
        }

        $logoPath = $this->site_logo;
        if ($this->newSiteLogo) {
            $logoPath = $this->newSiteLogo->store('seo/brand', 'public');
        }

        $faviconPath = $this->site_favicon;
        if ($this->newSiteFavicon) {
            $faviconPath = $this->newSiteFavicon->store('seo/brand', 'public');
        }

        $data = [
            'site_name' => $this->site_name,
            'site_description' => $this->site_description,
            'default_og_image' => $ogImagePath,
            'site_logo' => $logoPath,
            'site_favicon' => $faviconPath,
            'site_logo_alt' => $this->site_logo_alt,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'contact_address' => $this->contact_address,
            'country' => $this->country,
            'language' => $this->language ?? 'es',
            'twitter_card_type' => $this->twitter_card_type ?? 'summary_large_image',
            'twitter_site' => $this->twitter_site,
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'tiktok_url' => $this->tiktok_url,
            'whatsapp_number' => $this->whatsapp_number,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'google_analytics_id' => $this->google_analytics_id,
            'google_tag_manager_id' => $this->google_tag_manager_id,
            'facebook_pixel_id' => $this->facebook_pixel_id,
            'google_site_verification' => $this->google_site_verification,
            'bing_site_verification' => $this->bing_site_verification,
            'robots_default' => $this->robots_default ?? 'index, follow',
            'canonical_url_base' => $this->canonical_url_base,
            'sitemap_enabled' => $this->sitemap_enabled ?? true,
            'structured_data_enabled' => $this->structured_data_enabled ?? true,
            'author' => $this->author,
            'copyright' => $this->copyright,
            'established_year' => $this->established_year,
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
        if ($logoPath) {
            $this->site_logo = $logoPath;
        }
        if ($faviconPath) {
            $this->site_favicon = $faviconPath;
        }

        $this->reset(['newDefaultOgImage', 'newSiteLogo', 'newSiteFavicon']);

        $this->alert('success', 'Configuración SEO actualizada correctamente');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.seo.global-config.index');
    }
}
