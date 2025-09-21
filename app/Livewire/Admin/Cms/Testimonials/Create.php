<?php

namespace App\Livewire\Admin\Cms\Testimonials;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    public $client_name = '';
    public $client_position = '';
    public $content = '';
    public $rating = 5;
    public $order = 1;
    public $is_active = true;
    public $newImage;

    public function mount()
    {
        $this->order = Testimonial::max('order') + 1;
    }

    public function save()
    {
        $this->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'order' => 'required|integer|min:1',
            'newImage' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($this->newImage) {
            $imagePath = $this->newImage->store('testimonials', 'public');
        }

        Testimonial::create([
            'client_name' => $this->client_name,
            'client_position' => $this->client_position,
            'content' => $this->content,
            'image' => $imagePath,
            'rating' => $this->rating,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ]);

        $this->alert('success', 'Testimonio creado correctamente');
        return $this->redirect(route('admin.cms.testimonials'));
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.testimonials.create');
    }
}