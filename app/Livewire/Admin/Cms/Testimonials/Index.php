<?php

namespace App\Livewire\Admin\Cms\Testimonials;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// Gestión de testimonios: listar, buscar, reordenar y eliminar
class Index extends Component
{
    use LivewireAlert;

    public $search = ''; // Término de búsqueda

    // Obtiene testimonios filtrados por búsqueda
    public function getTestimonials()
    {
        return Testimonial::query()
            ->when($this->search, fn($query) => $query->where('client_name', 'like', '%' . $this->search . '%'))
            ->orderBy('order')
            ->get();
    }

    // Actualiza orden mediante drag & drop
    public function updateOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Testimonial::where('id', $id)->update(['order' => $index + 1]);
        }
        $this->alert('success', 'Orden actualizado correctamente');
    }

    // Elimina testimonio
    public function delete($testimonialId)
    {
        Testimonial::find($testimonialId)?->delete();
        $this->alert('success', 'Testimonio eliminado correctamente');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.testimonials.index', [
            'testimonials' => $this->getTestimonials(),
        ]);
    }
}