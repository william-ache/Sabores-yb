@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('customer.dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
            <i class="fas fa-arrow-left text-xs"></i> Volver a mi cuenta
        </a>
        <h2 class="text-4xl font-display text-textMain tracking-tight">Métodos de Pago</h2>
        <p class="text-gray-500 font-medium">Configura cómo prefieres pagar tus pedidos.</p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Pago Móvil -->
        <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/40 border border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="h-14 w-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-orange-600 text-xl">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div>
                    <h4 class="text-lg font-display text-textMain">Pago Móvil</h4>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Configurado para agilizar tu pedido</p>
                </div>
            </div>
            <span class="text-[10px] font-bold bg-primary/10 text-primary px-3 py-1 rounded-full uppercase tracking-widest">Activo</span>
        </div>

        <!-- Zelle -->
        <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/40 border border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="h-14 w-14 bg-accent/10 rounded-2xl flex items-center justify-center text-accent text-xl">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <h4 class="text-lg font-display text-textMain">Zelle / Dólares</h4>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Disponible para pagos internacionales</p>
                </div>
            </div>
            <span class="text-[10px] font-bold bg-primary/10 text-primary px-3 py-1 rounded-full uppercase tracking-widest">Disponible</span>
        </div>
    </div>
</div>
@endsection
