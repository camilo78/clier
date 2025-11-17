<?php

namespace App\Http\Controllers;

use App\Models\PageSeoSetting;
use App\Models\SeoConfig;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Controlador para generar sitemap.xml dinámicamente
 */
class SitemapController extends Controller
{
    /**
     * Genera y retorna el sitemap.xml
     *
     * @return Response
     */
    public function index(): Response
    {
        // Verificar si el sitemap está habilitado
        $seoConfig = SeoConfig::first();

        if (!$seoConfig || !$seoConfig->sitemap_enabled) {
            abort(404);
        }

        // Cachear el sitemap por 1 hora
        $xml = Cache::remember('sitemap_xml', 3600, function () {
            $pages = PageSeoSetting::where('is_active', true)->get();
            return $this->generateSitemap($pages);
        });

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Genera el XML del sitemap
     *
     * @param \Illuminate\Database\Eloquent\Collection $pages
     * @return string
     */
    protected function generateSitemap($pages): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($pages as $page) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($page->canonical_url ?: url('/')) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $page->updated_at->toAtomString() . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>' . $this->getChangeFrequency($page->page_identifier) . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . $this->getPriority($page->page_identifier) . '</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Determina la frecuencia de cambio según el tipo de página
     *
     * @param string $pageIdentifier
     * @return string
     */
    protected function getChangeFrequency(string $pageIdentifier): string
    {
        return match ($pageIdentifier) {
            'home' => 'daily',
            'services', 'testimonials' => 'weekly',
            'about', 'contact' => 'monthly',
            default => 'weekly',
        };
    }

    /**
     * Determina la prioridad según el tipo de página
     *
     * @param string $pageIdentifier
     * @return string
     */
    protected function getPriority(string $pageIdentifier): string
    {
        return match ($pageIdentifier) {
            'home' => '1.0',
            'services' => '0.9',
            'about', 'contact' => '0.8',
            default => '0.7',
        };
    }
}
