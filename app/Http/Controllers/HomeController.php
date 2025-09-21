<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Models\Service;
use App\Models\Slide;
use App\Models\Testimonial;
use Illuminate\Http\Request;

/**
 * Controlador para la página principal (Home)
 * 
 * Gestiona la carga optimizada de datos para el home,
 * respetando los toggles de módulos activos/inactivos.
 * Solo carga datos de módulos habilitados para mejorar rendimiento.
 */
class HomeController extends Controller
{
    /**
     * Muestra la página principal
     * 
     * Carga condicionalmente los datos según los toggles:
     * - slides: solo si slides_enabled = true
     * - services: solo si services_enabled = true  
     * - testimonials: solo si testimonials_enabled = true
     * - facts: se muestran/ocultan directamente en la vista
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener información de la empresa (siempre necesaria)
        $companyInfo = CompanyInfo::first();
        
        // Carga condicional: solo cargar datos de módulos activos
        // Esto mejora el rendimiento evitando consultas innecesarias
        
        $slides = $companyInfo && $companyInfo->slides_enabled 
            ? Slide::active()->ordered()->get() 
            : collect(); // Colección vacía si está deshabilitado
            
        $services = $companyInfo && $companyInfo->services_enabled 
            ? Service::active()->ordered()->get() 
            : collect();
            
        $testimonials = $companyInfo && $companyInfo->testimonials_enabled 
            ? Testimonial::active()->ordered()->get() 
            : collect();

        // Retornar vista con todos los datos necesarios
        return view('home', compact(
            'companyInfo',
            'slides', 
            'services',
            'testimonials'
        ));
    }
}