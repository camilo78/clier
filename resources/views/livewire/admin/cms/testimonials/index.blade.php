{{--
    Vista principal para gestionar testimonios de clientes
    
    Funcionalidades:
    - Listado de testimonios con búsqueda
    - Drag & drop para reordenar
    - Eliminación con confirmación modal
    - Navegación a formularios CRUD
--}}
<section class="w-full">
    {{-- Encabezado de la página --}}
    <x-page-heading>
        <x-slot:title>Testimonios</x-slot:title>
        <x-slot:subtitle>Gestiona los testimonios de clientes</x-slot:subtitle>
        <x-slot:buttons>
            <flux:button href="{{ route('admin.cms.testimonials.create') }}" variant="primary" icon="plus">
                Crear Testimonio
            </flux:button>
        </x-slot:buttons>
    </x-page-heading>

    {{-- Barra de herramientas --}}
    <div class="flex items-center justify-between w-full mb-6 gap-2">
        <flux:input wire:model.live="search" placeholder="Buscar testimonios..." class="!w-auto"/>
        <flux:spacer/>
        <div class="text-sm text-gray-500">Arrastra las filas para reordenar</div>
    </div>

    {{-- Tabla principal --}}
    <div class="bg-white dark:bg-zinc-900 shadow ring-1 ring-zinc-950/5 dark:ring-white/10 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody id="sortable-testimonials" class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-800">
                    @foreach($testimonials as $testimonial)
                        <tr wire:key="testimonial-{{ $testimonial->id }}" data-id="{{ $testimonial->id }}" class="cursor-move hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors border-t border-b border-zinc-200 dark:border-zinc-800">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 drag-handle hover:text-zinc-600 dark:hover:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 2a1 1 0 000 2h6a1 1 0 100-2H7zM4 6a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM4 10a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM5 13a1 1 0 100 2h10a1 1 0 100-2H5z"/>
                                    </svg>
                                    <img src="{{ $testimonial->image ? (str_starts_with($testimonial->image, 'img/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image)) : asset('img/testimonial-1.jpg') }}" alt="{{ $testimonial->client_name }}" class="w-16 h-16 object-cover rounded-full border border-zinc-200 dark:border-zinc-700">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-zinc-900 dark:text-white">{{ $testimonial->order }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">{{ $testimonial->client_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($testimonial->is_active)
                                    <flux:badge color="green">Activo</flux:badge>
                                @else
                                    <flux:badge color="red">Inactivo</flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex gap-2 justify-center">
                                    <flux:button href="{{ route('admin.cms.testimonials.edit', $testimonial) }}" size="sm">
                                        Editar
                                    </flux:button>
                                    
                                    <flux:modal.trigger name="delete-testimonial-{{ $testimonial->id }}">
                                        <flux:button size="sm" variant="danger">Eliminar</flux:button>
                                    </flux:modal.trigger>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    {{-- Modales de confirmación --}}
    @foreach($testimonials as $testimonial)
        <flux:modal name="delete-testimonial-{{ $testimonial->id }}" class="min-w-[22rem] space-y-6 flex flex-col justify-between fixed inset-0 z-50 items-center justify-center bg-black/50">
            <div>
                <flux:heading size="lg">¿Eliminar testimonio?</flux:heading>
                <flux:subheading>
                    <p>Estás a punto de eliminar este testimonio.</p>
                    <p>Esta acción es irreversible.</p>
                </flux:subheading>
            </div>
            <div class="flex gap-2 !mt-auto mb-0">
                <flux:modal.close>
                    <flux:button variant="ghost">
                        Cancelar
                    </flux:button>
                </flux:modal.close>
                <flux:spacer/>
                <flux:button type="submit" variant="danger" wire:click.prevent="delete('{{ $testimonial->id }}')">
                    Eliminar Testimonio
                </flux:button>
            </div>
        </flux:modal>
    @endforeach
</section>

{{-- Script para drag & drop con SortableJS --}}
<script>
    document.addEventListener('livewire:navigated', initSortable);
    document.addEventListener('DOMContentLoaded', initSortable);
    
    function initSortable() {
        if (typeof Sortable !== 'undefined') {
            const sortableElement = document.getElementById('sortable-testimonials');
            if (sortableElement && !sortableElement.sortableInstance) {
                sortableElement.sortableInstance = Sortable.create(sortableElement, {
                    animation: 150,
                    ghostClass: 'opacity-50',
                    handle: '.drag-handle',
                    onEnd: function(evt) {
                        const orderedIds = Array.from(sortableElement.children).map(row => 
                            row.getAttribute('data-id')
                        );
                        @this.updateOrder(orderedIds);
                    }
                });
            }
        }
    }
</script>