@extends('admin.layout')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.index') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
        <i class="fas fa-arrow-left text-xs"></i> Volver al Inicio
    </a>
</div>

<div class="mb-10 flex flex-col items-center text-center gap-6">
    <div>
        <h2 class="text-4xl font-display text-textMain tracking-tight">Gestión de Productos</h2>
        <p class="text-gray-500 font-medium">Administra el menú digital que ven tus clientes.</p>
    </div>
    <a href="{{ route('admin.create') }}" class="bg-primary hover:bg-green-600 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-primary/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
        <i class="fas fa-plus"></i> Añadir Producto
    </a>
</div>

<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-primary/10 border-b border-primary/10">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Orden</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Imagen</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Producto</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Categoría</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Precio</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Estado</th>
                    <th class="px-8 py-5 text-right text-xs font-bold text-textMain uppercase tracking-widest">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-primary/5 transition-colors duration-200">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-xs font-bold text-gray-400 bg-gray-50 h-8 w-8 flex items-center justify-center rounded-lg border border-gray-100">
                            {{ $product->sort_order }}
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="relative h-14 w-14 rounded-2xl overflow-hidden bg-gray-100 border border-gray-100 shadow-sm">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full w-full bg-gray-50 text-gray-300">
                                    <i class="fas fa-image text-xl"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-base font-bold text-textMain">{{ $product->title }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-secondary/10 text-orange-600">
                            {{ $product->category_rel->name ?? 'Sin categoría' }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-lg font-display text-accent tracking-tighter">${{ number_format($product->price, 2) }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($product->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-primary/10 text-primary uppercase tracking-widest">
                                <i class="fas fa-eye mr-1"></i> Visible
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-400 uppercase tracking-widest">
                                <i class="fas fa-eye-slash mr-1"></i> Oculto
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.edit', $product) }}" class="bg-dark/10 text-dark hover:bg-dark hover:text-white h-10 w-10 flex items-center justify-center rounded-xl transition shadow-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.destroy', $product) }}" method="POST" class="inline-block" 
                                onsubmit="event.preventDefault(); Swal.fire({
                                    title: '¿Eliminar ' + '{{ $product->title }}' + '?',
                                    text: 'Esta acción no se puede deshacer.',
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
                                <button type="submit" class="bg-accent/10 text-accent hover:bg-accent hover:text-white h-10 w-10 flex items-center justify-center rounded-xl transition shadow-sm" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-4xl">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="text-gray-400 font-medium">Aún no hay productos registrados.</div>
                            <a href="{{ route('admin.create') }}" class="text-primary font-bold hover:underline">¡Agrega tu primer producto ahora!</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
