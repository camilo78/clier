<?php

namespace App\Livewire\Admin\Cms\Slides;

use App\Models\Slide;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// Gestión de slides: listar, buscar, reordenar y eliminar
class Index extends Component
{
    use LivewireAlert;

    public $search = ''; // Término de búsqueda

    // Obtiene slides filtrados por búsqueda
    public function getSlides()
    {
        return Slide::query()
            ->when($this->search, fn($query) => $query->where('title', 'like', '%' . $this->search . '%'))
            ->orderBy('order')
            ->get();
    }

    // Actualiza orden mediante drag & drop
    public function updateOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Slide::where('id', $id)->update(['order' => $index + 1]);
        }
        $this->alert('success', 'Orden actualizado correctamente');
    }

    // Elimina slide
    public function delete($slideId)
    {
        Slide::find($slideId)?->delete();
        $this->alert('success', 'Slide eliminado correctamente');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.slides.index', [
            'slides' => $this->getSlides(),
        ]);
    }
}