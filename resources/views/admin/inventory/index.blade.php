@extends('admin.layout')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.index') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
        <i class="fas fa-arrow-left text-xs"></i> Volver al Dashboard
    </a>
</div>

<div class="mb-10 flex flex-col items-center text-center gap-6">
    <div>
        <h2 class="text-4xl font-display text-textMain tracking-tight">Inventario de Empanadas & Materiales</h2>
        <p class="text-gray-500 font-medium">Controla el stock y tus insumos activos.</p>
    </div>
    <a href="{{ route('inventories.create') }}" class="bg-primary hover:bg-green-600 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-primary/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
        <i class="fas fa-plus"></i> Añadir Insumo/Material
    </a>
</div>

<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px]">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">ID</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Nombre del Material</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Cantidad en Stock</th>
                    <th class="px-8 py-5 text-right text-xs font-bold text-textMain uppercase tracking-widest">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-base font-bold text-gray-400">#{{ $item->id }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-base font-bold text-textMain">{{ $item->name }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-base font-bold text-gray-500">{{ $item->quantity }} unidades</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                             <a href="{{ route('inventories.edit', $item->id) }}" class="bg-primary/10 text-primary hover:bg-primary hover:text-white h-10 w-10 flex items-center justify-center rounded-xl transition shadow-sm float-left mr-2" title="Editar">
                                 <i class="fas fa-edit"></i>
                             </a>
                             <form action="{{ route('inventories.destroy', $item->id) }}" method="POST" class="inline-block"
                                 onsubmit="event.preventDefault(); Swal.fire({
                                     title: '¿Eliminar Material?',
                                     text: 'Esta acción no se puede revertir.',
                                     icon: 'warning',
                                     showCancelButton: true,
                                     confirmButtonColor: '{{ \App\Models\Setting::get("primary_color", "#00A859") }}',
                                     cancelButtonColor: '#d33',
                                     confirmButtonText: 'Sí, eliminar',
                                     cancelButtonText: 'Cancelar'
                                 }).then((result) => {
                                     if (result.isConfirmed) {
                                         this.submit();
                                     }
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
                    <td colspan="4" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="text-gray-400 font-medium">Aún no hay materiales o insumos registrados en el inventario.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
