<section class="w-full">
    {{-- Encabezado de la página --}}
    <x-page-heading>
        <x-slot:title>Configuración SEO Global</x-slot:title>
        <x-slot:subtitle>Gestiona la configuración SEO general de tu sitio web</x-slot:subtitle>
    </x-page-heading>

    {{-- Formulario principal --}}
    <form wire:submit="save" class="space-y-8">

        {{-- Divisor: Información General del Sitio --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    🌐 Información General del Sitio
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <flux:input wire:model="site_name" label="Nombre del Sitio" placeholder="Mi Sitio Web" />
            </div>

            <div class="md:col-span-2">
                <flux:textarea wire:model="site_description" label="Descripción del Sitio" rows="4"
                    placeholder="Breve descripción de tu sitio web para motores de búsqueda" />
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Imagen Open Graph por Defecto
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Preview --}}
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-800 h-[200px] flex items-center justify-center">
                        @if($newDefaultOgImage)
                            <img src="{{ $newDefaultOgImage->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg" alt="Nueva imagen OG">
                        @elseif($default_og_image)
                            <img src="{{ str_starts_with($default_og_image, 'img/') ? asset($default_og_image) : asset('storage/' . $default_og_image) }}" class="w-full h-full object-cover rounded-lg" alt="Imagen OG actual">
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="h-12 w-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm">Sin imagen</span>
                            </div>
                        @endif
                    </div>

                    {{-- Upload --}}
                    <div x-data="{ isDragging: false }"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="isDragging = false; $refs.ogImageInput.files = $event.dataTransfer.files; $refs.ogImageInput.dispatchEvent(new Event('change'))"
                        :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' : 'border-gray-300 dark:border-gray-600'"
                        class="border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors h-[200px] flex flex-col items-center justify-center"
                        onclick="document.getElementById('og-image-input').click()">
                        <svg class="h-12 w-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-medium text-blue-600">Haz clic para subir</span> o arrastra aquí
                        </p>
                        <p class="text-xs text-gray-500 mt-2">PNG, JPG (1200x630px recomendado)</p>
                        <input id="og-image-input" x-ref="ogImageInput" type="file" wire:model="newDefaultOgImage" accept="image/*" class="hidden">
                    </div>
                </div>
            </div>
        </div>

        {{-- Divisor: Redes Sociales --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    📱 Configuración de Redes Sociales
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:select wire:model="twitter_card_type" label="Tipo de Tarjeta Twitter">
                <option value="summary">Summary</option>
                <option value="summary_large_image">Summary Large Image</option>
            </flux:select>

            <flux:input wire:model="twitter_site" label="Usuario de Twitter del Sitio" placeholder="@tusitio" />
        </div>

        {{-- Divisor: Scripts de Seguimiento --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    📊 Scripts de Seguimiento
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <flux:input wire:model="google_analytics_id" label="Google Analytics ID" placeholder="G-XXXXXXXXXX" />
            <flux:input wire:model="google_tag_manager_id" label="Google Tag Manager ID" placeholder="GTM-XXXXXXX" />
            <flux:input wire:model="facebook_pixel_id" label="Facebook Pixel ID" placeholder="XXXXXXXXXXXXXXX" />
        </div>

        {{-- Divisor: Verificaciones de Motores de Búsqueda --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    🔍 Verificaciones de Motores de Búsqueda
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:input wire:model="google_site_verification" label="Google Site Verification"
                placeholder="Código de verificación de Google Search Console" />
            <flux:input wire:model="bing_site_verification" label="Bing Site Verification"
                placeholder="Código de verificación de Bing Webmaster Tools" />
        </div>

        {{-- Divisor: Configuración de Robots y SEO --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    🤖 Configuración de Robots y SEO
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:input wire:model="robots_default" label="Robots por Defecto" placeholder="index, follow" />
            <flux:input wire:model="canonical_url_base" label="URL Base Canónica" placeholder="https://tusitio.com" type="url" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-gray-100">Sitemap Automático</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Generar sitemap.xml dinámicamente</p>
                </div>
                <flux:switch wire:model="sitemap_enabled" />
            </div>

            <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-gray-100">Datos Estructurados</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Habilitar JSON-LD Schema.org</p>
                </div>
                <flux:switch wire:model="structured_data_enabled" />
            </div>
        </div>

        {{-- Botón de guardar --}}
        <div class="flex justify-end">
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="newDefaultOgImage">
                <span wire:loading.remove wire:target="save">Guardar Cambios</span>
                <span wire:loading wire:target="save" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                </span>
            </flux:button>
        </div>
    </form>
</section>
