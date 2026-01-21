<?php

namespace App\Livewire\Admin\Seo\PageSettings;

use App\Models\PageSeoSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Cache;

/**
 * Controlador Livewire para la gestión de SEO por página
 */
class Index extends Component
{
    use LivewireAlert, WithFileUploads;

    public $pages;
    public $selectedPage;
    public $showModal = false;

    // Campos del formulario
    public $page_identifier;
    public $page_name;
    public $title;
    public $meta_description;
    public $meta_keywords;
    public $og_title;
    public $og_description;
    public $og_image;
    public $og_type;
    public $twitter_title;
    public $twitter_description;
    public $twitter_image;
    public $canonical_url;
    public $robots;
    public $is_active = true;

    // Archivos nuevos
    public $newOgImage;
    public $newTwitterImage;

    public function mount()
    {
        $this->loadPages();
    }

    public function loadPages()
    {
        $this->pages = PageSeoSetting::orderBy('page_identifier')->get();
    }

    public function edit($pageId)
    {
        $this->selectedPage = PageSeoSetting::find($pageId);

        if ($this->selectedPage) {
            $this->fill($this->selectedPage->toArray());
            $this->showModal = true;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_type' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'canonical_url' => ['nullable', 'url', 'regex:/^https?:\/\/' . preg_quote(parse_url(url('/'), PHP_URL_HOST), '/') . '/'],
            'robots' => 'nullable|string|max:255',
            'newOgImage' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'newTwitterImage' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
        ], [
            'canonical_url.regex' => 'La URL canónica debe pertenecer al dominio ' . parse_url(url('/'), PHP_URL_HOST),
            'newOgImage.image' => 'El archivo debe ser una imagen válida',
            'newOgImage.max' => 'La imagen no debe ser mayor a 2MB',
            'newTwitterImage.image' => 'El archivo debe ser una imagen válida',
            'newTwitterImage.max' => 'La imagen no debe ser mayor a 2MB',
        ]);

        // Procesar imágenes
        $ogImagePath = $this->og_image;
        if ($this->newOgImage) {
            $ogImagePath = $this->newOgImage->store('seo/pages', 'public');
        }

        $twitterImagePath = $this->twitter_image;
        if ($this->newTwitterImage) {
            $twitterImagePath = $this->newTwitterImage->store('seo/pages', 'public');
        }

        $data = [
            'title' => $this->title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'og_title' => $this->og_title,
            'og_description' => $this->og_description,
            'og_image' => $ogImagePath,
            'og_type' => $this->og_type,
            'twitter_title' => $this->twitter_title,
            'twitter_description' => $this->twitter_description,
            'twitter_image' => $twitterImagePath,
            'canonical_url' => $this->canonical_url,
            'robots' => $this->robots,
            'is_active' => $this->is_active,
        ];

        if ($this->selectedPage) {
            $this->selectedPage->update($data);

            // Invalidar cache del sitemap cuando se actualiza una página
            Cache::forget('sitemap_xml');
        }

        $this->loadPages();
        $this->showModal = false;
        $this->reset(['newOgImage', 'newTwitterImage']);
        $this->alert('success', 'SEO de página actualizado correctamente');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'selectedPage',
            'page_identifier',
            'page_name',
            'title',
            'meta_description',
            'meta_keywords',
            'og_title',
            'og_description',
            'og_image',
            'og_type',
            'twitter_title',
            'twitter_description',
            'twitter_image',
            'canonical_url',
            'robots',
            'newOgImage',
            'newTwitterImage'
        ]);
        $this->is_active = true;
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.seo.page-settings.index');
    }
}
