<?php

namespace App\Livewire\Admin\Cms\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// Crear nuevos servicios con imagen e icono
class Create extends Component
{
    use LivewireAlert, WithFileUploads;

    // Propiedades del formulario
    public $name;
    public $description;
    public $newImage;
    public $newIcon;
    public $order = 0;
    public $is_active = true;

    // Reglas de validación
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'newImage' => 'required|image|max:2048',
        'newIcon' => 'required|image|max:2048',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];

    // Guarda nuevo servicio
    public function save()
    {
        if (!$this->newImage || !$this->newIcon) {
            $this->alert('warning', 'Por favor selecciona imagen e icono');
            return;
        }

        $this->validate();
        $this->alert('info', 'Procesando archivos, por favor espera...');

        try {
            $imagePath = $this->newImage->store('services', 'public');
            $iconPath = $this->newIcon->store('icons', 'public');
            
            if (!$imagePath || !$iconPath) {
                throw new \Exception('Error al guardar los archivos en el servidor');
            }

            Service::create([
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

        $this->alert('success', 'Servicio creado correctamente');
        return $this->redirect(route('admin.cms.services'));
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.services.create');
    }
}