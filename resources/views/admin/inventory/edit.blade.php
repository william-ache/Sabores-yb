@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('inventories.index') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
            <i class="fas fa-arrow-left text-xs"></i> Volver al Inventario
        </a>
    </div>

    <div class="mb-10">
        <h2 class="text-4xl font-display text-textMain tracking-tight">Editar Insumo / Material</h2>
        <p class="text-gray-500 font-medium">Modifica los detalles del insumo seleccionado.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-300/40 border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-12">
            <form method="POST" action="{{ route('inventories.update', $inventory->id) }}" class="space-y-8">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Nombre del Material/Insumo</label>
                        <input type="text" name="name" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" required placeholder="Ej: Harina de Trigo, Empanadas de Pollo, etc." value="{{ $inventory->name }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Cantidad en Stock</label>
                        <input type="number" min="0" name="quantity" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" required placeholder="0" value="{{ $inventory->quantity }}">
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="{{ route('inventories.index') }}" class="text-gray-400 font-bold hover:text-textMain transition order-2 sm:order-1">Cancelar</a>
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-green-600 text-white font-bold py-4 px-12 rounded-2xl shadow-lg shadow-primary/20 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 order-1 sm:order-2">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
