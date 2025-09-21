<?php

namespace App\Livewire\Admin\Cms\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// Editar servicios existentes con cambio opcional de archivos
class Edit extends Component
{
    use LivewireAlert, WithFileUploads;

    public Service $service; // Servicio a editar
    
    // Propiedades del formulario
    public $name;
    public $description;
    public $image;
    public $icon;
    public $order;
    public $is_active;
    public $newImage; // Nueva imagen opcional
    public $newIcon; // Nuevo icono opcional

    // Reglas de validación
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'newImage' => 'nullable|image|max:2048',
        'newIcon' => 'nullable|image|max:2048',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];

    // Inicializa con datos del servicio existente
    public function mount(Service $service)
    {
        $this->service = $service;
        $this->fill($service->toArray());
    }

    // Guarda cambios del servicio
    public function save()
    {
        $this->validate();

        if (($this->newImage || $this->newIcon)) {
            $this->alert('info', 'Procesando archivos, por favor espera...');
        }

        try {
            $imagePath = $this->newImage ? $this->newImage->store('services', 'public') : $this->image;
            $iconPath = $this->newIcon ? $this->newIcon->store('icons', 'public') : $this->icon;
            
            if (($this->newImage && !$imagePath) || ($this->newIcon && !$iconPath)) {
                throw new \Exception('Error al guardar los archivos en el servidor');
            }

            $this->service->update([
                'name' => $this->name,
                'description' => $this->description,
                'image' => $imagePath,
                'icon' => $iconPath,
                'order' => $this->order,
                'is_active' => $this->is_active,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Error al procesar los archivos: ' . $e->getMessage());
            return;
        }

        $this->image = $imagePath;
        $this->icon = $iconPath;
        $this->newImage = null;
        $this->newIcon = null;

        $this->alert('success', 'Servicio actualizado correctamente');
        return $this->redirect(route('admin.cms.services'));
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.services.edit');
    }
}