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

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $page = 'home'
    ) {
        $seoService = new SeoService();

        // Obtener meta tags
        $this->metaTags = $seoService->getMetaTags($this->page);

        // Obtener datos estructurados
        $this->structuredData = $seoService->getStructuredData($this->page);

        // Obtener scripts de seguimiento
        $this->trackingScripts = $seoService->getTrackingScripts();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seo-head');
    }
}
