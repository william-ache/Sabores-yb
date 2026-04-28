@extends('admin.layout')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.index') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
        <i class="fas fa-arrow-left text-xs"></i> Volver al Inicio
    </a>
</div>

<div class="mb-10 flex flex-col items-center text-center gap-6">
    <div>
        <h2 class="text-4xl font-display text-textMain tracking-tight">Gestión de Categorías</h2>
        <p class="text-gray-500 font-medium">Organiza el menú digital mediante categorías.</p>
    </div>
    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('categories.create') }}" class="bg-secondary hover:bg-orange-500 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-secondary/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
            <i class="fas fa-plus"></i> Añadir Categoría
        </a>
        <a href="{{ route('categories.reorder') }}" class="bg-dark hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-dark/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
            <i class="fas fa-sort-amount-down"></i> Organizar Menú
        </a>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-secondary/10 border-b border-secondary/10">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Orden</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Nombre</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Estado</th>
                    <th class="px-8 py-5 text-right text-xs font-bold text-textMain uppercase tracking-widest">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($categories as $category)
                <tr class="hover:bg-secondary/5 transition-colors duration-200">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-xs font-bold text-gray-400 bg-gray-50 h-8 w-8 flex items-center justify-center rounded-lg border border-gray-100">
                            {{ $category->sort_order }}
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-base font-bold text-textMain">{{ $category->name }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($category->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-600 uppercase tracking-widest">
                                <i class="fas fa-check-circle mr-1"></i> Activa
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-400 uppercase tracking-widest">
                                <i class="fas fa-times-circle mr-1"></i> Inactiva
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block" 
                                onsubmit="event.preventDefault(); Swal.fire({
                                    title: '¿Eliminar Categoría?',
                                    text: 'Los productos asociados podrían quedarse sin categoría.',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#E71D36',
                                    cancelButtonColor: '#24140a',
                                    confirmButtonText: '¡Sí, borrar!',
                                    cancelButtonText: 'No, cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) { this.submit(); }
                                })">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('categories.edit', $category) }}" class="bg-primary/10 text-primary hover:bg-primary hover:text-white h-10 w-10 flex items-center justify-center rounded-xl transition shadow-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" class="bg-accent/10 text-accent hover:bg-accent hover:text-white h-10 w-10 flex items-center justify-center rounded-xl transition shadow-sm" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="text-gray-400 font-medium">Aún no hay categorías registradas.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
