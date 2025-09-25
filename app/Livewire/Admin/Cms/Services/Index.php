<?php

namespace App\Livewire\Admin\Cms\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// Gestión de servicios: listar, buscar, reordenar y eliminar
class Index extends Component
{
    use LivewireAlert;

    public $search = ''; // Término de búsqueda

    // Obtiene servicios filtrados por búsqueda
    public function getServices()
    {
        return Service::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('order')
            ->get();
    }

    // Actualiza orden mediante drag & drop
    public function updateOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Service::where('id', $id)->update(['order' => $index + 1]);
        }
        $this->alert('success', 'Orden actualizado correctamente');
    }

    // Elimina servicio
    public function delete($serviceId)
    {
        Service::find($serviceId)?->delete();
        $this->alert('success', 'Servicio eliminado correctamente');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.services.index', [
            'services' => $this->getServices(),
        ]);
    }
}