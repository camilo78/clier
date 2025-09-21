{{--
    Vista principal para gestionar servicios de la empresa
    
    Funcionalidades:
    - Listado de servicios con búsqueda
    - Drag & drop para reordenar
    - Eliminación con confirmación modal
    - Navegación a formularios CRUD
--}}
<section class="w-full">
    {{-- Encabezado de la página --}}
    <x-page-heading>
        <x-slot:title>Servicios</x-slot:title>
        <x-slot:subtitle>Gestiona los servicios que ofrece tu empresa</x-slot:subtitle>
        <x-slot:buttons>
            <flux:button href="{{ route('admin.cms.services.create') }}" variant="primary" icon="plus">
                Crear Servicio
            </flux:button>
        </x-slot:buttons>
    </x-page-heading>

    {{-- Barra de herramientas --}}
    <div class="flex items-center justify-between w-full mb-6 gap-2">
        <flux:input wire:model.live="search" placeholder="Buscar servicios..." class="!w-auto"/>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody id="sortable-services" class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-800">
                    @foreach($services as $service)
                        <tr wire:key="service-{{ $service->id }}" data-id="{{ $service->id }}" class="cursor-move hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors border-t border-b border-zinc-200 dark:border-zinc-800">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 drag-handle hover:text-zinc-600 dark:hover:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 2a1 1 0 000 2h6a1 1 0 100-2H7zM4 6a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM4 10a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM5 13a1 1 0 100 2h10a1 1 0 100-2H5z"/>
                                    </svg>
                                    <img src="{{ $service->image ? (str_starts_with($service->image, 'img/') ? asset($service->image) : asset('storage/' . $service->image)) : asset('img/service-1.jpg') }}" alt="{{ $service->name }}" class="w-16 h-10 object-cover rounded-md border border-zinc-200 dark:border-zinc-700">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-zinc-900 dark:text-white">{{ $service->order }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">{{ $service->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($service->is_active)
                                    <flux:badge color="green">Activo</flux:badge>
                                @else
                                    <flux:badge color="red">Inactivo</flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex gap-2 justify-center">
                                    <flux:button href="{{ route('admin.cms.services.edit', $service) }}" size="sm">
                                        Editar
                                    </flux:button>
                                    
                                    <flux:modal.trigger name="delete-service-{{ $service->id }}">
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
    @foreach($services as $service)
        <flux:modal name="delete-service-{{ $service->id }}" class="min-w-[22rem] space-y-6 flex flex-col justify-between fixed inset-0 z-50 items-center justify-center bg-black/50">
            <div>
                <flux:heading size="lg">¿Eliminar servicio?</flux:heading>
                <flux:subheading>
                    <p>Estás a punto de eliminar este servicio.</p>
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
                <flux:button type="submit" variant="danger" wire:click.prevent="delete('{{ $service->id }}')">
                    Eliminar Servicio
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
            const sortableElement = document.getElementById('sortable-services');
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