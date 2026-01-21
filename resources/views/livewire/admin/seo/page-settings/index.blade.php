{{-- Gestión de SEO por página --}}
<section class="w-full">
    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">SEO por Página</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Configura el SEO específico de cada página de tu sitio</p>
        </div>
        <flux:button wire:click="create" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Página
        </flux:button>
    </div>

    {{-- Tabla de páginas --}}
    <div class="bg-white dark:bg-zinc-900 shadow ring-1 ring-zinc-950/5 dark:ring-white/10 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                {{-- Encabezados --}}
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Página</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Título SEO</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                {{-- Filas --}}
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($pages as $page)
                        <tr wire:key="page-{{ $page->id }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors border-t border-b border-zinc-200 dark:border-zinc-800">
                            {{-- Página --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ $page->page_name }}
                                </div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $page->page_identifier }}
                                </div>
                            </td>
                            {{-- Título SEO --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-zinc-900 dark:text-white">
                                    {{ $page->title ?? 'Sin configurar' }}
                                </div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 truncate max-w-md">
                                    {{ $page->meta_description }}
                                </div>
                            </td>
                            {{-- Estado --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($page->is_active)
                                    <flux:badge color="green">Activo</flux:badge>
                                @else
                                    <flux:badge color="red">Inactivo</flux:badge>
                                @endif
                            </td>
                            {{-- Acciones --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <flux:button wire:click="edit({{ $page->id }})" size="sm" variant="ghost">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </flux:button>
                                    <flux:button
                                        wire:click="delete({{ $page->id }})"
                                        wire:confirm="¿Estás seguro de eliminar esta página SEO?"
                                        size="sm"
                                        variant="danger">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">
                                No hay páginas configuradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal de edición --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" wire:click="closeModal">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col"
                 wire:click.stop>

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                    <div>
                        <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ $isEditing ? 'Editar SEO: ' . $page_name : 'Nueva Página SEO' }}
                        </h3>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $isEditing ? 'Configura los meta tags y configuración SEO de esta página' : 'Crea una nueva configuración SEO para una página' }}
                        </p>
                    </div>
                    <button type="button"
                            wire:click="closeModal"
                            class="text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Contenido scrolleable --}}
                <form wire:submit="save" class="flex-1 flex flex-col overflow-hidden">
                    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-8">

                        {{-- Información de la Página --}}
                        <div>
                            <h4 class="text-base font-semibold text-zinc-900 dark:text-white border-b border-zinc-200 dark:border-zinc-800 pb-2 mb-4">
                                Información de la Página
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <flux:input
                                    wire:model="page_identifier"
                                    label="Identificador de Página *"
                                    placeholder="home, about, contact, etc."
                                    :disabled="$isEditing"
                                    required />
                                @error('page_identifier') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror

                                <flux:input
                                    wire:model="page_name"
                                    label="Nombre de la Página *"
                                    placeholder="Página de Inicio"
                                    required />
                                @error('page_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Meta Tags Básicos --}}
                        <div>
                            <h4 class="text-base font-semibold text-zinc-900 dark:text-white border-b border-zinc-200 dark:border-zinc-800 pb-2 mb-4">
                                Meta Tags Básicos
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2" x-data="{ count: $wire.entangle('title').live.length }">
                                    <div class="flex items-center gap-2 mb-2">
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Título SEO</label>
                                        <flux:tooltip content="El título que aparecerá en los resultados de búsqueda de Google. Longitud ideal: 50-60 caracteres." position="right">
                                            <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </flux:tooltip>
                                    </div>
                                    <flux:input wire:model.live="title" />
                                    <p class="text-xs mt-1" :class="count > 60 ? 'text-red-500' : (count > 50 ? 'text-amber-500' : 'text-green-500')">
                                        <span x-text="count"></span>/60 caracteres
                                        <span x-show="count > 60" class="ml-1">⚠️ Muy largo</span>
                                        <span x-show="count >= 50 && count <= 60" class="ml-1">✓ Buena longitud</span>
                                    </p>
                                </div>
                                <div class="md:col-span-2" x-data="{ count: $wire.entangle('meta_description').live.length }">
                                    <div class="flex items-center gap-2 mb-2">
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Meta Descripción</label>
                                        <flux:tooltip content="Resumen de la página que aparece bajo el título en Google. Debe ser atractiva para generar clics. Longitud ideal: 140-160 caracteres." position="right">
                                            <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </flux:tooltip>
                                    </div>
                                    <flux:textarea wire:model.live="meta_description" rows="3" />
                                    <p class="text-xs mt-1" :class="count > 160 ? 'text-red-500' : (count > 140 ? 'text-amber-500' : 'text-green-500')">
                                        <span x-text="count"></span>/160 caracteres
                                        <span x-show="count > 160" class="ml-1">⚠️ Muy larga</span>
                                        <span x-show="count >= 140 && count <= 160" class="ml-1">✓ Buena longitud</span>
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <div class="flex items-center gap-2 mb-2">
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Palabras Clave</label>
                                        <flux:tooltip content="Términos relevantes para tu página. Separa con comas. Ejemplo: climatización, aire acondicionado, La Ceiba" position="right">
                                            <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </flux:tooltip>
                                    </div>
                                    <flux:textarea wire:model="meta_keywords" rows="2" />
                                    <p class="text-xs mt-1 text-zinc-500 dark:text-zinc-400">Separa las palabras clave con comas. Ej: climatización, aire acondicionado, La Ceiba</p>
                                </div>
                            </div>
                        </div>

                        {{-- Open Graph --}}
                        <div>
                            <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2 mb-4">
                                <h4 class="text-base font-semibold text-zinc-900 dark:text-white">
                                    Open Graph (Facebook)
                                </h4>
                                <flux:tooltip content="Controla cómo se ve tu página cuando se comparte en Facebook, WhatsApp y otras redes sociales" position="right">
                                    <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </flux:tooltip>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <flux:input wire:model="og_title" label="OG Título" />
                                <flux:input wire:model="og_type" label="OG Type" placeholder="website" />
                                <div class="md:col-span-2">
                                    <flux:textarea wire:model="og_description" label="OG Descripción" rows="2" />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                        Imagen Open Graph (1200x630px recomendado)
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- Preview OG Image --}}
                                        <div class="border border-zinc-300 dark:border-zinc-600 rounded-lg p-4 bg-zinc-50 dark:bg-zinc-800 h-[150px] flex items-center justify-center">
                                            @if($newOgImage)
                                                <img src="{{ $newOgImage->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg" alt="Nueva imagen OG">
                                            @elseif($og_image)
                                                <img src="{{ str_starts_with($og_image, 'img/') ? asset($og_image) : asset('storage/' . $og_image) }}" class="w-full h-full object-cover rounded-lg" alt="Imagen OG actual">
                                            @else
                                                <div class="text-center text-zinc-400">
                                                    <svg class="h-10 w-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-xs">Sin imagen</span>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- Upload OG Image --}}
                                        <div x-data="{ isDragging: false }"
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="isDragging = false; $refs.ogImageInput.files = $event.dataTransfer.files; $refs.ogImageInput.dispatchEvent(new Event('change'))"
                                            :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' : 'border-zinc-300 dark:border-zinc-600'"
                                            class="border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:border-zinc-400 dark:hover:border-zinc-500 transition-colors h-[150px] flex flex-col items-center justify-center"
                                            onclick="this.querySelector('input[type=file]').click()">
                                            <svg class="h-8 w-8 mx-auto mb-2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400">Arrastra o haz clic para subir</p>
                                            <input x-ref="ogImageInput" type="file" wire:model="newOgImage" accept="image/*" class="hidden">
                                        </div>
                                    </div>
                                    @error('newOgImage') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                    <p class="text-xs mt-1 text-zinc-500 dark:text-zinc-400">Tamaño recomendado: 1200x630px para mejor visualización en Facebook</p>
                                </div>
                            </div>
                        </div>

                        {{-- Twitter Card --}}
                        <div>
                            <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2 mb-4">
                                <h4 class="text-base font-semibold text-zinc-900 dark:text-white">
                                    Twitter Card
                                </h4>
                                <flux:tooltip content="Controla cómo se ve tu página cuando se comparte en Twitter/X" position="right">
                                    <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </flux:tooltip>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <flux:input wire:model="twitter_title" label="Twitter Título" />
                                </div>
                                <div class="md:col-span-2">
                                    <flux:textarea wire:model="twitter_description" label="Twitter Descripción" rows="2" />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                        Imagen Twitter Card (1200x675px recomendado)
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- Preview Twitter Image --}}
                                        <div class="border border-zinc-300 dark:border-zinc-600 rounded-lg p-4 bg-zinc-50 dark:bg-zinc-800 h-[150px] flex items-center justify-center">
                                            @if($newTwitterImage)
                                                <img src="{{ $newTwitterImage->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg" alt="Nueva imagen Twitter">
                                            @elseif($twitter_image)
                                                <img src="{{ str_starts_with($twitter_image, 'img/') ? asset($twitter_image) : asset('storage/' . $twitter_image) }}" class="w-full h-full object-cover rounded-lg" alt="Imagen Twitter actual">
                                            @else
                                                <div class="text-center text-zinc-400">
                                                    <svg class="h-10 w-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-xs">Sin imagen</span>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- Upload Twitter Image --}}
                                        <div x-data="{ isDragging: false }"
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="isDragging = false; $refs.twitterImageInput.files = $event.dataTransfer.files; $refs.twitterImageInput.dispatchEvent(new Event('change'))"
                                            :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' : 'border-zinc-300 dark:border-zinc-600'"
                                            class="border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:border-zinc-400 dark:hover:border-zinc-500 transition-colors h-[150px] flex flex-col items-center justify-center"
                                            onclick="this.querySelector('input[type=file]').click()">
                                            <svg class="h-8 w-8 mx-auto mb-2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400">Arrastra o haz clic para subir</p>
                                            <input x-ref="twitterImageInput" type="file" wire:model="newTwitterImage" accept="image/*" class="hidden">
                                        </div>
                                    </div>
                                    @error('newTwitterImage') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                    <p class="text-xs mt-1 text-zinc-500 dark:text-zinc-400">Tamaño recomendado: 1200x675px para mejor visualización en Twitter</p>
                                </div>
                            </div>
                        </div>

                        {{-- Configuración Avanzada --}}
                        <div>
                            <h4 class="text-base font-semibold text-zinc-900 dark:text-white border-b border-zinc-200 dark:border-zinc-800 pb-2 mb-4">
                                Configuración Avanzada
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">URL Canónica</label>
                                        <flux:tooltip content="La URL oficial de esta página. Previene contenido duplicado en Google. Debe ser del mismo dominio." position="right">
                                            <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </flux:tooltip>
                                    </div>
                                    <flux:input wire:model="canonical_url" type="url" />
                                    @error('canonical_url') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Robots</label>
                                        <flux:tooltip content="Controla si los motores de búsqueda pueden indexar esta página. Valores comunes: 'index, follow' o 'noindex, nofollow'" position="right">
                                            <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </flux:tooltip>
                                    </div>
                                    <flux:input wire:model="robots" placeholder="index, follow" />
                                </div>
                                <div class="md:col-span-2">
                                    <div class="flex items-center gap-2">
                                        <flux:checkbox wire:model="is_active" label="Página Activa en Sitemap" />
                                        <flux:tooltip content="Si está activa, la página aparecerá en el sitemap.xml y será visible para motores de búsqueda" position="right">
                                            <svg class="w-4 h-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </flux:tooltip>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Footer fijo con botones --}}
                    <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex justify-end gap-3">
                        <flux:button type="button" variant="ghost" wire:click="closeModal">
                            Cancelar
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            Guardar Cambios
                        </flux:button>
                    </div>
                </form>

            </div>
        </div>
    @endif
</section>
