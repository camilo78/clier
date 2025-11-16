{{--
    Vista de administración para CompanyInfo
    
    PROPÓSITO:
    Formulario completo para gestionar toda la información dinámica del sitio web.
    Permite al administrador controlar todo el contenido sin tocar código.
    
    SECCIONES GESTIONADAS:
    1. Información básica: nombre, contacto, descripción, logo
    2. Redes sociales: enlaces a todas las plataformas
    3. Toggles de módulos: activar/desactivar secciones completas
    4. About: títulos, descripciones, imágenes, iconos
    5. Features: características con iconos e imagen principal
    6. Services: títulos y subtítulos
    7. Quote: formulario, imágenes de fondo, textos
    8. Facts: contadores y etiquetas (contenido dinámico)
    9. Testimonials: títulos
    
    FUNCIONALIDADES TÉCNICAS:
    - Subida múltiple de archivos con drag & drop
    - Preview en tiempo real de imágenes
    - Estados de carga durante operaciones
    - Validación de formularios
    - Manejo de archivos temporales
    - Interfaz responsive
    
    COMPONENTES UTILIZADOS:
    - Flux UI para inputs y switches
    - Alpine.js para interactividad
    - Livewire para reactividad
--}}
<section class="w-full">
    {{-- Encabezado de la página --}}
    <x-page-heading>
        <x-slot:title>Información de la Empresa</x-slot:title>
        <x-slot:subtitle>Gestiona la información básica de tu empresa</x-slot:subtitle>
    </x-page-heading>

    {{-- Formulario principal con todas las secciones --}}
    <form wire:submit="save" class="space-y-8">
        {{-- Divisor: Información Básica --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    📋 Información Básica
                </span>
            </div>
        </div>

        {{-- Sección: Información básica --}}
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Logo de la empresa --}}
            <div class="w-full lg:w-80 flex-shrink-0">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo de la Empresa</label>
                <div class="relative">
                    <div wire:key="logo-preview-{{ $logo ?? 'empty' }}" style="height: 180px;"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 h-32 flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                        @if ($newLogo)
                            <div class="text-center">
                                <img src="{{ $newLogo->temporaryUrl() }}" alt="Nuevo logo"
                                    class="h-20 w-50 object-contain mx-auto mb-1">
                                <span class="text-xs text-green-600 dark:text-green-400 font-medium">✓ Nuevo logo</span>
                            </div>
                        @elseif($logo)
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $logo) }}?v={{ time() }}" alt="Logo actual"
                                    class="h-20 w-50 object-contain mx-auto mb-1">
                                <span class="text-xs text-gray-500">Logo actual</span>
                            </div>
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="h-12 w-12 mx-auto mb-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-500">Sin logo</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-3">
                        <div x-data="{
                            isDragging: false,
                            handleDrop(e) {
                                this.isDragging = false;
                                const files = e.dataTransfer.files;
                                if (files.length > 0) {
                                    @this.upload('newLogo', files[0]);
                                }
                            }
                        }" @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                            :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' :
                                'border-gray-300 dark:border-gray-600'"
                            class="border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                            onclick="document.getElementById('logo-upload').click()">
                            <svg class="h-6 w-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-blue-600">Subir archivo</span> o arrastra aquí
                            </p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG hasta 2MB</p>
                            <input id="logo-upload" type="file" wire:model="newLogo" accept="image/*" class="hidden">
                        </div>
                    </div>

                    @error('newLogo')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="newLogo"
                        class="absolute inset-0 bg-white bg-opacity-75 dark:bg-gray-800 dark:bg-opacity-75 rounded-lg flex items-center justify-center">
                        <div
                            class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 px-3 py-2 rounded shadow">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>Subiendo...</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Campos de información básica --}}
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input wire:model="name" label="Nombre de la Empresa" required />
                <flux:input wire:model="founded_year" label="Año de Fundación" type="number" />
                <flux:input wire:model="phone" label="Teléfono" />
                <flux:input wire:model="email" label="Email" type="email" />
                <flux:textarea wire:model="address" label="Dirección" rows="5" />
                <flux:textarea wire:model="description" label="Descripción" rows="5" />
            </div>
        </div>

        {{-- Divisor: Redes Sociales --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    🌐 Redes Sociales
                </span>
            </div>
        </div>

        {{-- Sección: Redes sociales --}}
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <flux:input wire:model="facebook_url" label="Facebook URL" />
                <flux:input wire:model="twitter_url" label="Twitter URL" />
                <flux:input wire:model="instagram_url" label="Instagram URL" />
                <flux:input wire:model="linkedin_url" label="LinkedIn URL" />
                <flux:input wire:model="youtube_url" label="YouTube URL" />
            </div>
        </div>

        {{-- Divisor: Configuración de Módulos --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    ⚙️ Configuración de Módulos
                </span>
            </div>
        </div>

        {{-- Configuración de Módulos --}}
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Slides del Carousel</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mostrar slides en la página principal</p>
                    </div>
                    <flux:switch wire:model="slides_enabled" />
                </div>
                <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Sección Servicios</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mostrar servicios y enlace de navegación</p>
                    </div>
                    <flux:switch wire:model="services_enabled" />
                </div>
                <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Sección Testimonios</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mostrar testimonios y enlace de navegación</p>
                    </div>
                    <flux:switch wire:model="testimonials_enabled" />
                </div>
                <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Sección Facts</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mostrar contadores y estadísticas</p>
                    </div>
                    <flux:switch wire:model="facts_enabled" />
                </div>
            </div>
        </div>

        {{-- Divisor: Sección Nosotros --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    👥 Sección Nosotros
                </span>
            </div>
        </div>

        {{-- Sección About --}}
        <div class="space-y-4">
            {{-- Características --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:textarea wire:model="about_title" label="Título de Nosotros" rows="3" />
                    <flux:textarea wire:model="about_description" label="Descripción de Nosotros" rows="3" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <flux:input wire:model="feature_1_title" label="Título Característica 1" />
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icono Característica 1</label>
                        <div class="relative">
                            <div class="w-full h-20 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                                @if($newFeature1Icon)
                                    <img src="{{ $newFeature1Icon->temporaryUrl() }}" class="h-16 w-16 object-contain">
                                @elseif($feature_1_icon)
                                    <img src="{{ str_starts_with($feature_1_icon, 'img/') ? asset($feature_1_icon) : asset('storage/' . $feature_1_icon) }}" class="h-16 w-16 object-contain">
                                @else
                                    <div class="text-center text-gray-400">
                                        <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <div class="w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                    onclick="document.getElementById('feature1-icon-upload').click()">
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-blue-600">Subir icono</span>
                                    </p>
                                    <input id="feature1-icon-upload" type="file" wire:model="newFeature1Icon" accept="image/*" class="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <flux:input wire:model="feature_2_title" label="Título Característica 2" />
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icono Característica 2</label>
                        <div class="relative">
                            <div class="w-full h-20 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                                @if($newFeature2Icon)
                                    <img src="{{ $newFeature2Icon->temporaryUrl() }}" class="h-16 w-16 object-contain">
                                @elseif($feature_2_icon)
                                    <img src="{{ str_starts_with($feature_2_icon, 'img/') ? asset($feature_2_icon) : asset('storage/' . $feature_2_icon) }}" class="h-16 w-16 object-contain">
                                @else
                                    <div class="text-center text-gray-400">
                                        <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <div class="w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                    onclick="document.getElementById('feature2-icon-upload').click()">
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-blue-600">Subir icono</span>
                                    </p>
                                    <input id="feature2-icon-upload" type="file" wire:model="newFeature2Icon" accept="image/*" class="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Imágenes About --}}
            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mt-6">Imágenes de Nosotros</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach(['1', '2', '3', '4'] as $num)
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen {{ $num }}</label>
                    <div class="relative">
                        <div wire:key="about-image-{{ $num }}-preview-{{ ${'about_image_' . $num} ?? 'empty' }}" 
                            class="w-full h-full border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-gray-50 dark:bg-gray-800 p-1">
                            @if(${'newAboutImage' . $num})
                                <img src="{{ ${'newAboutImage' . $num}->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg">
                            @elseif(${'about_image_' . $num})
                                <img src="{{ str_starts_with(${'about_image_' . $num}, 'img/') ? asset(${'about_image_' . $num}) : asset('storage/' . ${'about_image_' . $num}) }}?v={{ time() }}" 
                                    class="w-full h-full object-cover rounded-lg">
                            @else
                                <div class="text-center text-gray-400">
                                    <svg class="h-8 w-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs">Sin imagen</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-2">
                            <div x-data="{
                                isDragging: false,
                                handleDrop(e) {
                                    this.isDragging = false;
                                    const files = e.dataTransfer.files;
                                    if (files.length > 0) {
                                        @this.upload('newAboutImage{{ $num }}', files[0]);
                                    }
                                }
                            }" @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' :
                                    'border-gray-300 dark:border-gray-600'"
                                class="w-full border-2 border-dashed rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                onclick="document.getElementById('about-upload-{{ $num }}').click()">
                                <svg class="h-4 w-4 mx-auto mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-blue-600">Subir archivo</span> o arrastra aquí
                                </p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG hasta 2MB</p>
                                <input id="about-upload-{{ $num }}" type="file" wire:model="newAboutImage{{ $num }}" accept="image/*" class="hidden">
                            </div>
                        </div>
                        
                        @error('newAboutImage' . $num)
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        
                        <div wire:loading wire:target="newAboutImage{{ $num }}"
                            class="absolute inset-0 bg-white bg-opacity-75 dark:bg-gray-800 dark:bg-opacity-75 rounded-lg flex items-center justify-center">
                            <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 py-1 rounded shadow">
                                <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Subiendo...</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Divisor: Sección Facts --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    📊 Sección Facts (Estadísticas)
                </span>
            </div>
        </div>

        {{-- Sección Facts --}}
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Fact 1: Clientes --}}
                <div class="space-y-3 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Clientes Satisfechos
                    </h4>
                    <flux:input wire:model="facts_clients_count" label="Número" placeholder="1234" />
                    <flux:input wire:model="facts_clients_label" label="Etiqueta" placeholder="Clientes Satisfechos" />
                </div>

                {{-- Fact 2: Proyectos --}}
                <div class="space-y-3 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Proyectos Completados
                    </h4>
                    <flux:input wire:model="facts_projects_count" label="Número" placeholder="567" />
                    <flux:input wire:model="facts_projects_label" label="Etiqueta" placeholder="Proyectos Completados" />
                </div>

                {{-- Fact 3: Expertos --}}
                <div class="space-y-3 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Técnicos Expertos
                    </h4>
                    <flux:input wire:model="facts_experts_count" label="Número" placeholder="89" />
                    <flux:input wire:model="facts_experts_label" label="Etiqueta" placeholder="Técnicos Expertos" />
                </div>

                {{-- Fact 4: Soporte --}}
                <div class="space-y-3 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Soporte 24/7
                    </h4>
                    <flux:input wire:model="facts_support_count" label="Número" placeholder="24" />
                    <flux:input wire:model="facts_support_label" label="Etiqueta" placeholder="Soporte 24/7" />
                </div>
            </div>
        </div>

        {{-- Divisor: Sección Características --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    ✨ Sección Características
                </span>
            </div>
        </div>

        {{-- Sección Features --}}
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <flux:input wire:model="features_title" label="Título Principal" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <flux:input wire:model="feature_1_title" label="Título Característica 1" />
                            <flux:textarea wire:model="feature_1_description" label="Descripción Característica 1" rows="4"/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-zinc-800 dark:text-white">Descripción Icon 1</label>
                            <div class="relative">
                                <div class="w-full h-34 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-orange-600 dark:bg-orange-900">
                                    @if($newFeatureDescription1Icon)
                                        <div class="text-center">
                                            <img src="{{ $newFeatureDescription1Icon->temporaryUrl() }}" class="h-16 w-16 object-contain mx-auto">
                                        </div>
                                    @elseif($feature_description_1_icon)
                                        <div class="text-center">
                                            <img src="{{ str_starts_with($feature_description_1_icon, 'img/') ? asset($feature_description_1_icon) : asset('storage/' . $feature_description_1_icon) }}" class="h-16 w-16 object-contain mx-auto">
                                        </div>
                                    @else
                                        <div class="text-center text-gray-400">
                                            <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <div class="w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                        onclick="document.getElementById('feature-desc1-icon-upload').click()">
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-blue-600">Subir icono</span>
                                        </p>
                                        <input id="feature-desc1-icon-upload" type="file" wire:model="newFeatureDescription1Icon" accept="image/*" class="hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <flux:input wire:model="feature_2_title" label="Título Característica 2" />
                            <flux:textarea wire:model="feature_2_description" label="Descripción Característica 2" rows="4"/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-zinc-800 dark:text-white">Descripción Icon 2</label>
                            <div class="relative">
                                <div class="w-full h-34 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-orange-600 dark:bg-orange-900">
                                    @if($newFeatureDescription2Icon)
                                        <div class="text-center">
                                            <img src="{{ $newFeatureDescription2Icon->temporaryUrl() }}" class="h-16 w-16 object-contain mx-auto">
                                        </div>
                                    @elseif($feature_description_2_icon)
                                        <div class="text-center">
                                            <img src="{{ str_starts_with($feature_description_2_icon, 'img/') ? asset($feature_description_2_icon) : asset('storage/' . $feature_description_2_icon) }}" class="h-16 w-16 object-contain mx-auto">
                                        </div>
                                    @else
                                        <div class="text-center text-gray-400">
                                            <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <div class="w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                        onclick="document.getElementById('feature-desc2-icon-upload').click()">
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-blue-600">Subir icono</span>
                                        </p>
                                        <input id="feature-desc2-icon-upload" type="file" wire:model="newFeatureDescription2Icon" accept="image/*" class="hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <flux:input wire:model="feature_3_title" label="Título Característica 3" />
                            <flux:textarea wire:model="feature_3_description" label="Descripción Característica 3" rows="4"/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-zinc-800 dark:text-white">Descripción Icon 3</label>
                            <div class="relative">
                                <div class="w-full h-34 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-orange-600 dark:bg-orange-900">
                                    @if($newFeatureDescription3Icon)
                                        <div class="text-center">
                                            <img src="{{ $newFeatureDescription3Icon->temporaryUrl() }}" class="h-16 w-16 object-contain mx-auto">
                                        </div>
                                    @elseif($feature_description_3_icon)
                                        <div class="text-center">
                                            <img src="{{ str_starts_with($feature_description_3_icon, 'img/') ? asset($feature_description_3_icon) : asset('storage/' . $feature_description_3_icon) }}" class="h-16 w-16 object-contain mx-auto">
                                        </div>
                                    @else
                                        <div class="text-center text-gray-400">
                                            <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <div class="w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                        onclick="document.getElementById('feature-desc3-icon-upload').click()">
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-blue-600">Subir icono</span>
                                        </p>
                                        <input id="feature-desc3-icon-upload" type="file" wire:model="newFeatureDescription3Icon" accept="image/*" class="hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <flux:textarea wire:model="features_description" label="Descripción Principal" rows="6" />
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen Principal</label>
                        <div class="relative">
                            <div class="w-full h-114.5 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                                @if($newFeaturesImage)
                                    <img src="{{ $newFeaturesImage->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg">
                                @elseif($features_image)
                                    <img src="{{ str_starts_with($features_image, 'img/') ? asset($features_image) : asset('storage/' . $features_image) }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <div class="text-center text-gray-400">
                                        <svg class="h-8 w-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs">Sin imagen</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <div class="w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                    onclick="document.getElementById('features-upload').click()">
                                    <svg class="h-4 w-4 mx-auto mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-blue-600">Subir archivo</span> o arrastra aquí
                                    </p>
                                    <input id="features-upload" type="file" wire:model="newFeaturesImage" accept="image/*" class="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Divisor: Sección Servicios --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    🔧 Sección Servicios
                </span>
            </div>
        </div>

        {{-- Sección Services --}}
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:textarea wire:model="services_title" label="Título de Servicios" rows="2" />
                <flux:textarea wire:model="services_subtitle" label="Subtítulo de Servicios" rows="2" />
            </div>
        </div>

        {{-- Divisor: Sección Cotización --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t-2 border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="bg-white dark:bg-zinc-800 pr-3 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    💬 Sección Cotización
                </span>
            </div>
        </div>

        {{-- Sección Quote --}}
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <flux:input wire:model="quote_title" label="Título" />
                <flux:input wire:model="quote_button_text" label="Texto del Botón" />
                <flux:input wire:model="quote_button_url" label="URL del Botón" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach(['1', '2'] as $num)
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen de Fondo {{ $num }}</label>
                    <div class="relative">
                        <div class="w-full h-50 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                            @if(${'newQuoteBgImage' . $num})
                                <img src="{{ ${'newQuoteBgImage' . $num}->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg">
                            @elseif(${'quote_bg_image_' . $num})
                                <img src="{{ str_starts_with(${'quote_bg_image_' . $num}, 'img/') ? asset(${'quote_bg_image_' . $num}) : asset('storage/' . ${'quote_bg_image_' . $num}) }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <div class="text-center text-gray-400">
                                    <svg class="h-8 w-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs">Sin imagen</span>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <div class="w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                                onclick="document.getElementById('quote-bg-upload-{{ $num }}').click()">
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-blue-600">Subir imagen</span>
                                </p>
                                <input id="quote-bg-upload-{{ $num }}" type="file" wire:model="newQuoteBgImage{{ $num }}" accept="image/*" class="hidden">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="mt-0">
                <flux:textarea wire:model="quote_description" label="Descripción" rows="9" />
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <flux:button 
                type="submit" 
                variant="primary"
                wire:loading.attr="disabled"
                wire:target="newLogo,newAboutImage1,newAboutImage2,newAboutImage3,newAboutImage4,newFeature1Icon,newFeature2Icon,newFeatureDescription1Icon,newFeatureDescription2Icon,newFeatureDescription3Icon,newFeaturesImage,newQuoteBgImage1,newQuoteBgImage2"
            >
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
