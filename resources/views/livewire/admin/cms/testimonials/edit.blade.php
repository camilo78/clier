<section class="w-full">
    <x-page-heading>
        <x-slot:title>Editar Testimonio</x-slot:title>
        <x-slot:subtitle>Edita el testimonio de {{ $testimonial->client_name }}</x-slot:subtitle>
        <x-slot:buttons>
            <flux:button href="{{ route('admin.cms.testimonials') }}" icon="arrow-left">
                Volver
            </flux:button>
        </x-slot:buttons>
    </x-page-heading>

    <form wire:submit="save" class="space-y-6 col-span-full">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-80 flex-shrink-0">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Imagen del Cliente</label>
                <div class="relative">
                    <div wire:key="image-preview-{{ $newImage ?? $testimonial->image ?? 'empty' }}" style="height: 146px;"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                        @if ($newImage)
                            <div class="relative w-full h-full">
                                <img src="{{ $newImage->temporaryUrl() }}" alt="Nueva imagen"
                                    class="w-full h-full object-cover rounded-lg">
                                <div class="absolute bottom-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                    ✓ Nueva imagen
                                </div>
                            </div>
                        @elseif($testimonial->image)
                            <div class="relative w-full h-full">
                                <img src="{{ $testimonial->image ? (str_starts_with($testimonial->image, 'img/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image)) : asset('img/testimonial-1.jpg') }}?v={{ time() }}" alt="Imagen actual"
                                    class="w-full h-full object-cover rounded-lg">
                                <div class="absolute bottom-2 left-2 bg-gray-600 text-white text-xs px-2 py-1 rounded">
                                    Imagen actual
                                </div>
                            </div>
                        @else
                            <div class="text-center text-gray-400">
                                <svg class="h-12 w-12 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-500">Sin imagen</span>
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
                                    @this.upload('newImage', files[0]);
                                }
                            }
                        }" @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                            :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' :
                                'border-gray-300 dark:border-gray-600'"
                            class="border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                            onclick="document.getElementById('image-upload').click()">
                            <svg class="h-6 w-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-blue-600">Subir archivo</span> o arrastra aquí
                            </p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG hasta 2MB</p>
                            <input id="image-upload" type="file" wire:model="newImage" accept="image/*" class="hidden">
                        </div>
                    </div>

                    @error('newImage')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="newImage"
                        class="absolute inset-0 bg-white bg-opacity-75 dark:bg-gray-800 dark:bg-opacity-75 rounded-lg flex items-center justify-center">
                        <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 px-3 py-2 rounded shadow">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Subiendo...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input wire:model="client_name" label="Nombre del Cliente" required />
                    <flux:input wire:model="order" label="Orden" type="number" required />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input wire:model="client_position" label="Posición del Cliente" />
                    <flux:input wire:model="rating" label="Calificación (1-5)" type="number" min="1" max="5" required />
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <flux:textarea wire:model="content" label="Testimonio" rows="3" required />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <flux:button href="{{ route('admin.cms.testimonials') }}" variant="filled" type="button">
                Cancelar
            </flux:button>
            <flux:button 
                type="submit" 
                variant="primary" 
                class="ml-3 min-w-[160px]"

            >
                <span wire:loading.remove wire:target="save">Actualizar Testimonio</span>
                <span wire:loading wire:target="save" class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                </span>
            </flux:button>
        </div>
    </form>
</section>