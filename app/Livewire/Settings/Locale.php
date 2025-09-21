<?php

namespace App\Livewire\Settings;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Locale extends Component
{
    public string $locale = '';

    public function mount(): void
    {
        $this->locale = auth()->user()->locale;
    }

    public function updateLocale(): void
    {
        $this->validate([
            'locale' => 'required|string|in:en,es',
        ]);

        auth()->user()->update([
            'locale' => $this->locale,
        ]);

        // Actualizar el idioma de la aplicación inmediatamente
        app()->setLocale($this->locale);

        $this->dispatch('locale-updated', name: auth()->user()->name);
        
        // Dispatch evento global para refrescar toda la interfaz
        $this->dispatch('locale-changed');
    }

    #[Layout('components.layouts.admin')]
    public function render(): View
    {
        return view('livewire.settings.locale', [
            'locales' => [
                'en' => 'English',
                'es' => 'Español',
            ],
        ]);
    }
}
