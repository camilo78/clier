<?php

namespace App\View\Components;

use App\Services\SeoService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Componente SeoHead
 *
 * Inyecta automáticamente todos los meta tags SEO en el <head>
 * incluyendo Open Graph, Twitter Cards, y scripts de seguimiento
 */
class SeoHead extends Component
{
    public $metaTags;
    public $structuredData;
    public $trackingScripts;
    public $organizationData;
    public $favicon;
    public $brandColors;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $page = 'home'
    ) {
        $seoService = new SeoService();

        // Obtener meta tags
        $this->metaTags = $seoService->getMetaTags($this->page);

        // Obtener datos estructurados de la página
        $this->structuredData = $seoService->getStructuredData($this->page);

        // Obtener datos estructurados de la organización
        $this->organizationData = $seoService->getOrganizationStructuredData();

        // Obtener scripts de seguimiento
        $this->trackingScripts = $seoService->getTrackingScripts();

        // Obtener favicon
        $this->favicon = $seoService->getSiteFavicon();

        // Obtener colores de marca
        $this->brandColors = $seoService->getBrandColors();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seo-head');
    }
}
