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

            <div>
                <flux:input wire:model="author" label="Autor" placeholder="Nombre del autor o empresa" />
                @error('author') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <flux:input wire:model="established_year" label="Año de Fundación" type="number" placeholder="2024" />
                @error('established_year') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <flux:input wire:model="copyright" label="Copyright" placeholder="© 2024 Mi Empresa. Todos los derechos reservados." />
                @error('copyright') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Divisor: Identidad de Marca --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    🎨 Identidad de Marca
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Logo del Sitio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Logo del Sitio
                </label>
                <div class="space-y-3">
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-800 h-[120px] flex items-center justify-center relative">
                        <div wire:loading wire:target="newSiteLogo" class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-gray-900 bg-opacity-75 rounded-lg">
                            <svg class="animate-spin h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        @if($newSiteLogo)
                            <img src="{{ $newSiteLogo->temporaryUrl() }}" class="max-h-full max-w-full object-contain" alt="Nuevo logo">
                        @elseif($site_logo)
                            <img src="{{ str_starts_with($site_logo, 'img/') ? asset($site_logo) : asset('storage/' . $site_logo) }}" class="max-h-full max-w-full object-contain" alt="Logo actual">
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="h-10 w-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs">Sin logo</span>
                            </div>
                        @endif
                    </div>
                    <input type="file" wire:model="newSiteLogo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('newSiteLogo') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <flux:input wire:model="site_logo_alt" label="Texto Alternativo del Logo" placeholder="Logo de Mi Empresa" />
                    @error('site_logo_alt') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Favicon --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Favicon
                </label>
                <div class="space-y-3">
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-800 h-[120px] flex items-center justify-center relative">
                        <div wire:loading wire:target="newSiteFavicon" class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-gray-900 bg-opacity-75 rounded-lg">
                            <svg class="animate-spin h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        @if($newSiteFavicon)
                            @php
                                $extension = strtolower($newSiteFavicon->getClientOriginalExtension());
                            @endphp
                            @if($extension === 'ico')
                                <div class="text-center text-gray-600 dark:text-gray-300">
                                    <svg class="h-12 w-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-xs font-medium">{{ $newSiteFavicon->getClientOriginalName() }}</span>
                                    <p class="text-xs text-green-600 mt-1">Archivo .ico cargado</p>
                                </div>
                            @else
                                <img src="{{ $newSiteFavicon->temporaryUrl() }}" class="h-16 w-16 object-contain" alt="Nuevo favicon">
                            @endif
                        @elseif($site_favicon)
                            <img src="{{ str_starts_with($site_favicon, 'img/') ? asset($site_favicon) : asset('storage/' . $site_favicon) }}" class="h-16 w-16 object-contain" alt="Favicon actual">
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="h-10 w-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs">Sin favicon</span>
                            </div>
                        @endif
                    </div>
                    <input type="file" wire:model="newSiteFavicon" accept=".ico,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('newSiteFavicon') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 dark:text-gray-400">ICO o PNG (32x32px recomendado)</p>
                </div>
            </div>

            {{-- Colores de Marca --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Color Primario
                </label>
                <div class="flex gap-2">
                    <input type="color" wire:model.live="primary_color" class="h-10 w-20 rounded cursor-pointer">
                    <flux:input wire:model="primary_color" placeholder="#0066CC" class="flex-1" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Color Secundario
                </label>
                <div class="flex gap-2">
                    <input type="color" wire:model.live="secondary_color" class="h-10 w-20 rounded cursor-pointer">
                    <flux:input wire:model="secondary_color" placeholder="#FF6600" class="flex-1" />
                </div>
            </div>
        </div>

        {{-- Divisor: Información de Contacto --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    📞 Información de Contacto
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <flux:input wire:model="contact_email" label="Email de Contacto" type="email" placeholder="info@ejemplo.com" />
                @error('contact_email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="contact_phone" label="Teléfono de Contacto" placeholder="+504 1234-5678" />
                @error('contact_phone') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <flux:input wire:model="contact_address" label="Dirección" placeholder="Calle Principal, Ciudad" />
                @error('contact_address') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="country" label="País" placeholder="Honduras" />
                @error('country') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:select wire:model="language" label="Idioma Principal">
                    <option value="es">Español</option>
                    <option value="en">English</option>
                    <option value="fr">Français</option>
                    <option value="pt">Português</option>
                </flux:select>
                @error('language') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Imagen Open Graph por Defecto
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Preview --}}
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-800 h-[200px] flex items-center justify-center relative">
                        <div wire:loading wire:target="newDefaultOgImage" class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-gray-900 bg-opacity-75 rounded-lg">
                            <svg class="animate-spin h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
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
            <div>
                <flux:input wire:model="facebook_url" label="Facebook" type="url" placeholder="https://facebook.com/tupagina" />
                @error('facebook_url') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="instagram_url" label="Instagram" type="url" placeholder="https://instagram.com/tuperfil" />
                @error('instagram_url') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="twitter_site" label="Twitter/X (@usuario)" placeholder="@tusitio" />
                @error('twitter_site') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="linkedin_url" label="LinkedIn" type="url" placeholder="https://linkedin.com/company/tuempresa" />
                @error('linkedin_url') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="youtube_url" label="YouTube" type="url" placeholder="https://youtube.com/@tucanal" />
                @error('youtube_url') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="tiktok_url" label="TikTok" type="url" placeholder="https://tiktok.com/@tuperfil" />
                @error('tiktok_url') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <flux:input wire:model="whatsapp_number" label="WhatsApp (con código de país)" placeholder="+504 9876-5432" />
                @error('whatsapp_number') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            <flux:select wire:model="twitter_card_type" label="Tipo de Tarjeta Twitter">
                <option value="summary">Summary</option>
                <option value="summary_large_image">Summary Large Image</option>
            </flux:select>
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
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="newDefaultOgImage,newSiteLogo,newSiteFavicon">
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
