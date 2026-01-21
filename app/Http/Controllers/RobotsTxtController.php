<?php

namespace App\Http\Controllers;

use App\Models\SeoConfig;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Controlador para generar robots.txt dinámicamente
 */
class RobotsTxtController extends Controller
{
    /**
     * Genera y retorna el robots.txt
     *
     * @return Response
     */
    public function index(): Response
    {
        // Cachear robots.txt por 1 hora
        $content = Cache::remember('robots_txt', 3600, function () {
            $seoConfig = SeoConfig::first();
            return $this->generateRobotsTxt($seoConfig);
        });

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Genera el contenido del robots.txt
     *
     * @param SeoConfig|null $seoConfig
     * @return string
     */
    protected function generateRobotsTxt($seoConfig): string
    {
        $content = "# Robots.txt generado dinámicamente" . PHP_EOL;
        $content .= "# " . now()->toDateTimeString() . PHP_EOL . PHP_EOL;

        $content .= "User-agent: *" . PHP_EOL;

        // Usar configuración personalizada o por defecto
        if ($seoConfig && $seoConfig->robots_default) {
            $robots = explode(',', $seoConfig->robots_default);

            foreach ($robots as $directive) {
                $directive = trim($directive);

                if (str_contains($directive, 'noindex')) {
                    $content .= "Disallow: /" . PHP_EOL;
                } elseif (str_contains($directive, 'index')) {
                    $content .= "Allow: /" . PHP_EOL;
                }
            }
        } else {
            // Por defecto permitir todo
            $content .= "Allow: /" . PHP_EOL;
        }

        $content .= PHP_EOL;

        // Agregar ruta al sitemap si está habilitado
        if ($seoConfig && $seoConfig->sitemap_enabled) {
            $content .= "Sitemap: " . url('/sitemap.xml') . PHP_EOL;
        }

        $content .= PHP_EOL;
        $content .= "# Bloquear carpetas administrativas" . PHP_EOL;
        $content .= "Disallow: /admin" . PHP_EOL;
        $content .= "Disallow: /vendor" . PHP_EOL;
        $content .= "Disallow: /storage" . PHP_EOL;

        return $content;
    }
}
