<?php

namespace App\Livewire\Admin\Cms\Testimonials;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use WithFileUploads, LivewireAlert;

    public Testimonial $testimonial;
    public $client_name;
    public $client_position;
    public $content;
    public $rating;
    public $order;
    public $is_active;
    public $newImage = null;

    public function mount(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
        $this->client_name = $testimonial->client_name;
        $this->client_position = $testimonial->client_position;
        $this->content = $testimonial->content;
        $this->rating = $testimonial->rating;
        $this->order = $testimonial->order;
        $this->is_active = $testimonial->is_active;
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

        $imagePath = $this->testimonial->image;
        if ($this->newImage) {
            $imagePath = $this->newImage->store('testimonials', 'public');
        }

        $this->testimonial->update([
            'client_name' => $this->client_name,
            'client_position' => $this->client_position,
            'content' => $this->content,
            'image' => $imagePath,
            'rating' => $this->rating,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ]);

        $this->alert('success', 'Testimonio actualizado correctamente');
        return $this->redirect(route('admin.cms.testimonials'));
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.testimonials.edit');
    }
}