<?php

namespace App\Livewire\Admin\Cms\Slides;

use App\Models\Slide;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// Editar slides existentes con cambio opcional de imagen
class Edit extends Component
{
    use LivewireAlert, WithFileUploads;

    // Constantes para validación de aspecto 16:9
    private const ASPECT_RATIO_16_9 = 1.7777777777777777;
    private const ASPECT_RATIO_TOLERANCE = 0.05;

    public Slide $slide; // Slide a editar
    
    // Propiedades del formulario
    public $title;
    public $subtitle;
    public $image;
    public $button_text;
    public $button_url;
    public $order;
    public $is_active;
    public $newImage; // Nueva imagen opcional
    public $tempImagePath;

    // Reglas de validación
    protected $rules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string',
        'newImage' => 'nullable|image|max:2048',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:255',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];
    // Inicializa con datos del slide existente
    public function mount(Slide $slide)
    {
        $this->slide = $slide;
        $this->fill($slide->toArray());
    }

    // Guarda cambios del slide
    public function save()
    {
        $this->validate();

        if ($this->newImage && $this->getErrorBag()->has('newImage')) {
            $this->alert('error', 'Corrige los errores de la imagen antes de continuar');
            return;
        }

        if ($this->newImage) {
            $this->alert('info', 'Procesando imagen, por favor espera...');
        }

        try {
            $imagePath = $this->newImage ? $this->newImage->store('slides', 'public') : $this->image;
            
            if ($this->newImage && !$imagePath) {
                throw new \Exception('Error al guardar la nueva imagen en el servidor');
            }

            $this->slide->update([
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

        $this->image = $imagePath;
        $this->newImage = null;

        $this->alert('success', 'Slide actualizado correctamente');
        return $this->redirect(route('admin.cms.slides'));
    }

    // Validación en tiempo real de nueva imagen 16:9
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
        return view('livewire.admin.cms.slides.edit');
    }
    
    public function __destruct()
    {
        $this->cleanupTempImage();
    }
}