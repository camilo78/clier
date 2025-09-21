{{-- Editar servicio: formulario con cambio opcional de archivos --}}
<section class="w-full">
    {{-- Encabezado --}}
    <x-page-heading>
        <x-slot:title>Editar Servicio</x-slot:title>
        <x-slot:subtitle>Modifica los datos del servicio</x-slot:subtitle>
        <x-slot:buttons>
            <flux:button href="{{ route('admin.cms.services') }}" icon="arrow-left">
                Volver
            </flux:button>
        </x-slot:buttons>
    </x-page-heading>

    {{-- Formulario --}}
    <form wire:submit="save" class="space-y-6">
        {{-- Campos básicos --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <flux:input wire:model="name" label="Nombre del Servicio" required />
            <flux:input wire:model="order" label="Orden" type="number" required />
        </div>
        
        <flux:textarea wire:model="description" label="Descripción" rows="3" />
            
        {{-- Subida de archivos --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Imagen del servicio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Imagen del Servicio</label>
                <div class="relative">
                    <div style="height: 146px;"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                        @if ($newImage)
                            <div class="relative w-full h-full">
                                <img src="{{ $newImage->temporaryUrl() }}" alt="Nueva imagen"
                                    class="w-full h-full object-cover rounded-lg">
                                <div class="absolute bottom-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                    ✓ Nueva imagen
                                </div>
                            </div>
                        @elseif($image)
                            <div class="relative w-full h-full">
                                <img src="{{ $image ? (str_starts_with($image, 'img/') ? asset($image) : asset('storage/' . $image)) : asset('img/service-1.jpg') }}?v={{ time() }}" alt="Imagen actual"
                                    class="w-full h-full object-cover rounded-lg">
                                <div class="absolute bottom-2 left-2 bg-gray-600 text-white text-xs px-2 py-1 rounded">
                                    Imagen actual
                                </div>
                            </div>
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="h-12 w-12 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-500">Sin imagen</span>
                            </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                            onclick="document.getElementById('image-upload').click()">
                            <svg class="h-6 w-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-blue-600">Cambiar imagen</span> o arrastra aquí
                            </p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG hasta 2MB</p>
                            <input id="image-upload" type="file" wire:model="newImage" accept="image/*" class="hidden">
                        </div>
                    </div>
                    @error('newImage')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
                
            {{-- Icono del servicio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Icono del Servicio</label>
                <div class="relative">
                    <div style="height: 146px;"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 flex items-center justify-center bg-orange-600 dark:bg-orange-600">
                        @if ($newIcon)
                            <div class="relative w-full h-full">
                                <img src="{{ $newIcon->temporaryUrl() }}" alt="Nuevo icono"
                                    class="w-full h-full object-contain">
                                <div class="absolute bottom-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                    ✓ Nuevo icono
                                </div>
                            </div>
                        @elseif($icon)
                            <div class="relative w-full h-full">
                                <img src="{{ $icon ? (str_starts_with($icon, 'img/') ? asset($icon) : asset('storage/' . $icon)) : asset('img/icon/icon-01-primary.png') }}?v={{ time() }}" alt="Icono actual"
                                    class="w-full h-full object-contain">
                                <div class="absolute bottom-2 left-2 bg-gray-600 text-white text-xs px-2 py-1 rounded">
                                    Icono actual
                                </div>
                            </div>
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="h-12 w-12 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-500">Sin icono</span>
                            </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                            onclick="document.getElementById('icon-upload').click()">
                            <svg class="h-6 w-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-blue-600">Cambiar icono</span> o arrastra aquí
                            </p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG hasta 2MB</p>
                            <input id="icon-upload" type="file" wire:model="newIcon" accept="image/*" class="hidden">
                        </div>
                    </div>
                    @error('newIcon')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        {{-- Estado del servicio --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <flux:label>Estado</flux:label>
                <div class="mt-2">
                    <button 
                        type="button"
                        wire:click="$toggle('is_active')"
                        :class="{{ $is_active ? 'true' : 'false' }} ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <span 
                            :class="{{ $is_active ? 'true' : 'false' }} ? 'translate-x-6' : 'translate-x-1'"
                            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                        ></span>
                    </button>
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                        {{ $is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            <div></div>
        </div>

        {{-- Botones de acción --}}
        <div class="flex justify-end">
            <flux:button href="{{ route('admin.cms.services') }}" variant="filled" type="button">
                Cancelar
            </flux:button>
            <flux:button 
                type="submit" 
                variant="primary" 
                class="ml-3 min-w-[150px]"
            >
                <span wire:loading.remove wire:target="save">Actualizar Servicio</span>
                <span wire:loading wire:target="save" class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                </span>
            </flux:button>
        </div>
    </form>
</section>