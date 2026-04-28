@extends('customer.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header de Bienvenida -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-display text-textMain tracking-tight">Hola, {{ explode(' ', $user->name)[0] }} 👋</h2>
            <p class="text-gray-500 font-medium mt-1">Bienvenido a tu rincón de sabores. Aquí tienes todo el control.</p>
        </div>
        <a href="/" class="shrink-0 bg-primary/10 text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-2xl text-sm font-bold transition flex items-center gap-2">
            <i class="fas fa-utensils"></i> Volver a la Carta
        </a>
    </div>

    <!-- Grid de Secciones -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Mi Perfil -->
        <a href="{{ route('customer.profile') }}" class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/40 border border-gray-100 hover:border-secondary/50 transition transform hover:-translate-y-1">
            <div class="h-16 w-16 bg-secondary/10 rounded-2xl flex items-center justify-center text-orange-600 text-2xl mb-6 group-hover:bg-secondary group-hover:text-white transition">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3 class="text-xl font-display text-textMain mb-2">Mi Perfil</h3>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-loose">Gestiona tus datos personales y dirección de entrega.</p>
            
            <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">{{ $user->email }}</span>
                <i class="fas fa-arrow-right text-gray-200 group-hover:text-orange-500 transition"></i>
            </div>
        </a>

        <!-- Historial de Órdenes -->
        <a href="{{ route('customer.orders') }}" class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/40 border border-gray-100 hover:border-primary/50 transition transform hover:-translate-y-1">
            <div class="h-16 w-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-2xl mb-6 group-hover:bg-primary group-hover:text-white transition">
                <i class="fas fa-history"></i>
            </div>
            <h3 class="text-xl font-display text-textMain mb-2">Mis Órdenes</h3>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-loose">Mira lo que has pedido y repite tus favoritos.</p>
            
            <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">{{ $orders->count() ?? 0 }} Órdenes</span>
                <i class="fas fa-arrow-right text-gray-200 group-hover:text-primary transition"></i>
            </div>
        </a>

    </div>

    <!-- Banner Informativo -->
    <div class="mt-12 bg-dark rounded-[2.5rem] p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl">
        <div class="relative z-10 max-w-lg">
            <h3 class="text-3xl font-display mb-4 leading-tight">¿Hambre de algo nuevo?</h3>
            <p class="text-white/80 font-medium mb-8">Explora nuestro menú actualizado y descubre las delicias que tenemos preparadas para ti hoy.</p>
            <a href="/" class="inline-flex items-center gap-2 bg-white text-dark font-bold py-4 px-10 rounded-2xl hover:bg-secondary hover:text-white transition shadow-xl shadow-black/10">
                Mirar la Carta <i class="fas fa-external-link-alt text-xs"></i>
            </a>
        </div>
        <!-- Decoración abstracta -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute right-10 top-10 w-20 h-20 bg-secondary/20 rounded-full blur-xl"></div>
    </div>
</div>
@endsection
