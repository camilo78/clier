<?php

namespace App\Livewire\Admin\Cms\Slides;

use App\Models\Slide;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// Crear nuevos slides con validación de imagen 16:9
class Create extends Component
{
    use LivewireAlert, WithFileUploads;

    // Constantes para validación de aspecto 16:9
    private const ASPECT_RATIO_16_9 = 1.7777777777777777;
    private const ASPECT_RATIO_TOLERANCE = 0.05;

    // Propiedades del formulario
    public $title;
    public $subtitle;
    public $newImage;
    public $button_text;
    public $button_url;
    public $order = 0;
    public $is_active = true;
    public $tempImagePath;

    // Reglas de validación
    protected $rules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string',
        'newImage' => 'required|image|max:2048',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:255',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];
    // Guarda nuevo slide
    public function save()
    {
        if (!$this->newImage) {
            $this->alert('warning', 'Por favor selecciona una imagen');
            return;
        }

        if ($this->getErrorBag()->has('newImage')) {
            $this->alert('error', 'Corrige los errores de la imagen antes de continuar');
            return;
        }

        $this->validate();
        $this->alert('info', 'Procesando imagen, por favor espera...');

        try {
            $imagePath = $this->newImage->store('slides', 'public');
            
            if (!$imagePath) {
                throw new \Exception('Error al guardar la imagen en el servidor');
            }

            Slide::create([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'image' => $imagePath,
                'button_text' => $this->button_text,
                'button_url' => $this->button_url,
                'order' => $this->order,
                'is_active' => $this->is_active,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Error al procesar la imagen: ' . $e->getMessage());
            return;
        }

        $this->alert('success', 'Slide creado correctamente');
        return $this->redirect(route('admin.cms.slides'));
    }

    // Validación en tiempo real de imagen 16:9
    public function updatedNewImage()
    {
        if (!$this->newImage) return;

        $this->cleanupTempImage();
        $imageSize = @getimagesize($this->newImage->getRealPath());
        
        if ($imageSize === false) {
            $this->addError('newImage', 'No se pudo procesar la imagen. Verifica que sea un archivo válido.');
            return;
        }

        [$width, $height] = $imageSize;
        $aspectRatio = $width / $height;

        if (abs($aspectRatio - self::ASPECT_RATIO_16_9) > self::ASPECT_RATIO_TOLERANCE) {
            $currentRatio = round($aspectRatio, 2);
            $this->addError('newImage', "La imagen debe tener relación de aspecto 16:9. Actual: {$currentRatio}:1 ({$width}x{$height}). Requerido: 1.78:1 (ej: 1920x1080, 1280x720).");
        } else {
            $this->resetErrorBag('newImage');
        }
    }

    // Limpia archivos temporales
    private function cleanupTempImage()
    {
        if ($this->tempImagePath && file_exists($this->tempImagePath)) {
            @unlink($this->tempImagePath);
            $this->tempImagePath = null;
        }
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.slides.create');
    }
    
    public function __destruct()
    {
        $this->cleanupTempImage();
    }
}