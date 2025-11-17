<?php

namespace App\Livewire\Admin\Cms\CompanyInfo;

use App\Models\CompanyInfo as CompanyInfoModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

/**
 * Controlador Livewire para la gestión completa de CompanyInfo
 * 
 * Este componente maneja:
 * - Información básica de la empresa (nombre, contacto, descripción, redes sociales)
 * - Toggles para activar/desactivar módulos (slides, services, testimonials, facts)
 * - Contenido dinámico de todas las secciones del home:
 *   * About: títulos, descripciones, imágenes, iconos
 *   * Features: características con iconos y descripciones
 *   * Services: títulos y subtítulos
 *   * Quote: formulario, imágenes de fondo, textos
 *   * Facts: contadores y etiquetas
 *   * Testimonials: títulos
 * - Subida y gestión de múltiples archivos (logo, imágenes, iconos)
 * 
 * Funcionalidades principales:
 * - Validación de formularios
 * - Subida de archivos con preview
 * - Actualización dinámica de contenido
 * - Estados de carga durante operaciones
 */
class Index extends Component
{
    use LivewireAlert, WithFileUploads;

    /** @var CompanyInfoModel Instancia del modelo CompanyInfo */
    public $companyInfo;
    
    // === INFORMACIÓN BÁSICA DE LA EMPRESA ===
    /** @var string Nombre de la empresa */
    public $name;
    /** @var string Teléfono de contacto */
    public $phone;
    /** @var string Email de contacto */
    public $email;
    /** @var string Dirección física */
    public $address;
    /** @var string Descripción de la empresa */
    public $description;
    /** @var int Año de fundación */
    public $founded_year;
    
    // === REDES SOCIALES ===
    public $facebook_url, $twitter_url, $instagram_url, $linkedin_url, $youtube_url;
    
    // === LOGO ===
    /** @var string Ruta actual del logo */
    public $logo;
    /** @var \Livewire\TemporaryUploadedFile Nuevo logo subido */
    public $newLogo;
    
    // === SECCIÓN ABOUT ===
    public $about_title, $about_description;
    public $feature_1_title, $feature_1_icon, $feature_2_title, $feature_2_icon;
    public $about_image_1, $about_image_2, $about_image_3, $about_image_4;
    // Nuevas imágenes About para subida
    public $newAboutImage1, $newAboutImage2, $newAboutImage3, $newAboutImage4;
    // Nuevos iconos About para subida
    public $newFeature1Icon, $newFeature2Icon;
    
    // === SECCIÓN FEATURES ===
    public $features_title, $features_description;
    public $feature_1_description, $feature_2_description, $feature_3_description, $feature_3_title;
    public $feature_description_1_icon, $feature_description_2_icon, $feature_description_3_icon;
    // Nuevos iconos Features para subida
    public $newFeatureDescription1Icon, $newFeatureDescription2Icon, $newFeatureDescription3Icon;
    public $features_image, $newFeaturesImage;
    
    // === SECCIÓN SERVICES ===
    public $services_title, $services_subtitle;
    
    // === SECCIÓN QUOTE ===
    public $quote_title, $quote_description, $quote_button_text, $quote_button_url;
    public $quote_bg_image_1, $quote_bg_image_2;
    // Nuevas imágenes Quote para subida
    public $newQuoteBgImage1, $newQuoteBgImage2;

    // === SECCIÓN FACTS ===
    public $facts_clients_count, $facts_clients_label;
    public $facts_projects_count, $facts_projects_label;
    public $facts_experts_count, $facts_experts_label;
    public $facts_support_count, $facts_support_label;
    public $facts_bg_image, $newFactsBgImage;

    // === TOGGLES DE MÓDULOS ===
    /** @var bool Activar/desactivar carousel de slides */
    public $slides_enabled = true;
    /** @var bool Activar/desactivar sección servicios */
    public $services_enabled = true;
    /** @var bool Activar/desactivar sección testimonios */
    public $testimonials_enabled = true;
    /** @var bool Activar/desactivar sección facts/estadísticas */
    public $facts_enabled = true;

    /**
     * Inicializa el componente cargando la información existente
     * 
     * Se ejecuta al cargar la página y rellena automáticamente
     * todos los campos del formulario con los datos actuales
     * de la base de datos.
     */
    public function mount()
    {
        // Obtener el primer (y único) registro de company_infos
        $this->companyInfo = CompanyInfoModel::first();
        
        // Si existe información, rellenar todos los campos del formulario
        if ($this->companyInfo) {
            $this->fill($this->companyInfo->toArray());
        }
    }

    /**
     * Guarda toda la información de la empresa
     * 
     * Proceso completo:
     * 1. Valida todos los campos del formulario
     * 2. Procesa y almacena archivos subidos (imágenes/iconos)
     * 3. Actualiza o crea el registro en base de datos
     * 4. Limpia archivos temporales
     * 5. Muestra mensaje de confirmación
     * 
     * @return void
     */
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'feature_1_title' => 'nullable|string|max:255',
            'feature_2_title' => 'nullable|string|max:255',
            'feature_3_title' => 'nullable|string|max:255',
            'features_title' => 'nullable|string|max:255',
            'features_description' => 'nullable|string',
            'feature_1_description' => 'nullable|string',
            'feature_2_description' => 'nullable|string',
            'feature_3_description' => 'nullable|string',
            'services_title' => 'nullable|string|max:255',
            'services_subtitle' => 'nullable|string',
            'quote_title' => 'nullable|string|max:255',
            'quote_description' => 'nullable|string',
            'quote_button_text' => 'nullable|string|max:255',
            'quote_button_url' => 'nullable|string|max:255',
            'facts_clients_count' => 'nullable|string|max:255',
            'facts_clients_label' => 'nullable|string|max:255',
            'facts_projects_count' => 'nullable|string|max:255',
            'facts_projects_label' => 'nullable|string|max:255',
            'facts_experts_count' => 'nullable|string|max:255',
            'facts_experts_label' => 'nullable|string|max:255',
            'facts_support_count' => 'nullable|string|max:255',
            'facts_support_label' => 'nullable|string|max:255',
        ]);

        // Procesar todos los archivos subidos y obtener sus rutas finales
        $paths = $this->processFileUploads();

        // Preparar array con todos los datos a guardar
        $data = array_merge([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'description' => $this->description,
            'founded_year' => $this->founded_year,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'about_title' => $this->about_title,
            'about_description' => $this->about_description,
            'feature_1_title' => $this->feature_1_title,
            'feature_2_title' => $this->feature_2_title,
            'feature_3_title' => $this->feature_3_title,
            'features_title' => $this->features_title,
            'features_description' => $this->features_description,
            'feature_1_description' => $this->feature_1_description,
            'feature_2_description' => $this->feature_2_description,
            'feature_3_description' => $this->feature_3_description,
            'services_title' => $this->services_title,
            'services_subtitle' => $this->services_subtitle,
            'quote_title' => $this->quote_title,
            'quote_description' => $this->quote_description,
            'quote_button_text' => $this->quote_button_text,
            'quote_button_url' => $this->quote_button_url,
            'facts_clients_count' => $this->facts_clients_count,
            'facts_clients_label' => $this->facts_clients_label,
            'facts_projects_count' => $this->facts_projects_count,
            'facts_projects_label' => $this->facts_projects_label,
            'facts_experts_count' => $this->facts_experts_count,
            'facts_experts_label' => $this->facts_experts_label,
            'facts_support_count' => $this->facts_support_count,
            'facts_support_label' => $this->facts_support_label,
            'slides_enabled' => $this->slides_enabled,
            'services_enabled' => $this->services_enabled,
            'testimonials_enabled' => $this->testimonials_enabled,
            'facts_enabled' => $this->facts_enabled,
        ], $paths);

        // Actualizar registro existente o crear uno nuevo
        if ($this->companyInfo) {
            $this->companyInfo->update($data);
        } else {
            $this->companyInfo = CompanyInfoModel::create($data);
        }

        // Actualizar propiedades del componente con las nuevas rutas
        $this->updateComponentProperties($paths);
        // Limpiar archivos temporales
        $this->clearNewFileProperties();
        
        // Mostrar mensaje de éxito al usuario
        $this->alert('success', 'Información actualizada correctamente');
    }

    /**
     * Procesa todas las subidas de archivos
     * 
     * Para cada tipo de archivo:
     * - Si hay un archivo nuevo: lo almacena y retorna la nueva ruta
     * - Si no hay archivo nuevo: mantiene la ruta actual
     * 
     * @return array Array asociativo con las rutas finales de todos los archivos
     */
    private function processFileUploads()
    {
        return [
            'logo' => $this->newLogo ? $this->newLogo->store('logos', 'public') : $this->logo,
            'about_image_1' => $this->newAboutImage1 ? $this->newAboutImage1->store('about', 'public') : $this->about_image_1,
            'about_image_2' => $this->newAboutImage2 ? $this->newAboutImage2->store('about', 'public') : $this->about_image_2,
            'about_image_3' => $this->newAboutImage3 ? $this->newAboutImage3->store('about', 'public') : $this->about_image_3,
            'about_image_4' => $this->newAboutImage4 ? $this->newAboutImage4->store('about', 'public') : $this->about_image_4,
            'feature_1_icon' => $this->newFeature1Icon ? $this->newFeature1Icon->store('icons', 'public') : $this->feature_1_icon,
            'feature_2_icon' => $this->newFeature2Icon ? $this->newFeature2Icon->store('icons', 'public') : $this->feature_2_icon,
            'feature_description_1_icon' => $this->newFeatureDescription1Icon ? $this->newFeatureDescription1Icon->store('icons', 'public') : $this->feature_description_1_icon,
            'feature_description_2_icon' => $this->newFeatureDescription2Icon ? $this->newFeatureDescription2Icon->store('icons', 'public') : $this->feature_description_2_icon,
            'feature_description_3_icon' => $this->newFeatureDescription3Icon ? $this->newFeatureDescription3Icon->store('icons', 'public') : $this->feature_description_3_icon,
            'features_image' => $this->newFeaturesImage ? $this->newFeaturesImage->store('features', 'public') : $this->features_image,
            'quote_bg_image_1' => $this->newQuoteBgImage1 ? $this->newQuoteBgImage1->store('quote', 'public') : $this->quote_bg_image_1,
            'quote_bg_image_2' => $this->newQuoteBgImage2 ? $this->newQuoteBgImage2->store('quote', 'public') : $this->quote_bg_image_2,
            'facts_bg_image' => $this->newFactsBgImage ? $this->newFactsBgImage->store('facts', 'public') : $this->facts_bg_image,
        ];
    }

    /**
     * Actualiza las propiedades del componente con las rutas finales
     * 
     * Esto asegura que la interfaz muestre las imágenes actualizadas
     * inmediatamente después de guardar.
     * 
     * @param array $paths Array con las rutas finales de los archivos
     */
    private function updateComponentProperties($paths)
    {
        foreach ($paths as $property => $path) {
            $this->$property = $path;
        }
    }

    /**
     * Limpia todas las propiedades de archivos temporales
     * 
     * Esto libera memoria y evita que se muestren archivos
     * temporales en la interfaz después de guardar.
     */
    private function clearNewFileProperties()
    {
        $this->newLogo = null;
        $this->newAboutImage1 = null;
        $this->newAboutImage2 = null;
        $this->newAboutImage3 = null;
        $this->newAboutImage4 = null;
        $this->newFeature1Icon = null;
        $this->newFeature2Icon = null;
        $this->newFeatureDescription1Icon = null;
        $this->newFeatureDescription2Icon = null;
        $this->newFeatureDescription3Icon = null;
        $this->newFeaturesImage = null;
        $this->newQuoteBgImage1 = null;
        $this->newQuoteBgImage2 = null;
        $this->newFactsBgImage = null;
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.company-info.index');
    }
}