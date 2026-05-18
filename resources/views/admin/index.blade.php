@extends('admin.layout')

@section('content')
<div class="mb-10 text-center">
    <h2 class="text-3xl sm:text-4xl font-display text-textMain tracking-tight">Menú de Gestión</h2>
    <p class="text-gray-500 font-medium italic text-sm">{{ $appName }} - Sistema Dinámico</p>
</div>

<div class="grid grid-cols-2 gap-4 sm:gap-8 max-w-4xl mx-auto px-2 sm:px-0">
    <!-- Productos -->
    <a href="{{ route('admin.products.index') }}" class="group bg-white p-6 sm:p-10 rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 hover:border-primary/30 transition transform hover:-translate-y-1 flex flex-col items-center text-center">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-primary/10 rounded-2xl sm:rounded-3xl flex items-center justify-center text-primary mb-4 sm:mb-6 group-hover:bg-primary group-hover:text-white transition shadow-sm">
            <i class="fas fa-box text-2xl sm:text-4xl"></i>
        </div>
        <h3 class="text-sm sm:text-2xl font-display text-textMain tracking-wide">Productos</h3>
    </a>

    <!-- Categorías -->
    <a href="{{ route('categories.index') }}" class="group bg-white p-6 sm:p-10 rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 hover:border-secondary/30 transition transform hover:-translate-y-1 flex flex-col items-center text-center">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-secondary/10 rounded-2xl sm:rounded-3xl flex items-center justify-center text-orange-500 mb-4 sm:mb-6 group-hover:bg-secondary group-hover:text-white transition shadow-sm">
            <i class="fas fa-tags text-2xl sm:text-4xl"></i>
        </div>
        <h3 class="text-sm sm:text-2xl font-display text-textMain tracking-wide">Categorías</h3>
    </a>

    <!-- Usuarios (Admins) -->
    <a href="{{ route('users.index') }}" class="group bg-white p-6 sm:p-10 rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 hover:border-dark/30 transition transform hover:-translate-y-1 flex flex-col items-center text-center">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-dark/10 rounded-2xl sm:rounded-3xl flex items-center justify-center text-dark mb-4 sm:mb-6 group-hover:bg-dark group-hover:text-white transition shadow-sm">
            <i class="fas fa-user-shield text-2xl sm:text-4xl"></i>
        </div>
        <h3 class="text-sm sm:text-2xl font-display text-textMain tracking-wide">Administradores</h3>
    </a>

    <!-- Clientes -->
    <a href="{{ route('customers.index') }}" class="group bg-white p-6 sm:p-10 rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 hover:border-primary/30 transition transform hover:-translate-y-1 flex flex-col items-center text-center">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-primary/10 rounded-2xl sm:rounded-3xl flex items-center justify-center text-primary mb-4 sm:mb-6 group-hover:bg-primary group-hover:text-white transition shadow-sm">
            <i class="fas fa-user-friends text-2xl sm:text-4xl"></i>
        </div>
        <h3 class="text-sm sm:text-2xl font-display text-textMain tracking-wide">Clientes</h3>
    </a>

    <!-- Ordenes -->
    <a href="{{ route('orders.index') }}" class="group bg-white p-6 sm:p-10 rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 hover:border-accent/30 transition transform hover:-translate-y-1 flex flex-col items-center text-center">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-accent/10 rounded-2xl sm:rounded-3xl flex items-center justify-center text-accent mb-4 sm:mb-6 group-hover:bg-accent group-hover:text-white transition shadow-sm">
            <i class="fas fa-shopping-cart text-2xl sm:text-4xl"></i>
        </div>
        <h3 class="text-sm sm:text-2xl font-display text-textMain tracking-wide">Órdenes</h3>
    </a>

    <!-- Inventario -->
    <a href="{{ route('inventories.index') }}" class="group bg-white p-6 sm:p-10 rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 hover:border-blue-500/30 transition transform hover:-translate-y-1 flex flex-col items-center text-center">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-blue-500/10 rounded-2xl sm:rounded-3xl flex items-center justify-center text-blue-500 mb-4 sm:mb-6 group-hover:bg-blue-500 group-hover:text-white transition shadow-sm">
            <i class="fas fa-boxes text-2xl sm:text-4xl"></i>
        </div>
        <h3 class="text-sm sm:text-2xl font-display text-textMain tracking-wide">Inventario</h3>
    </a>
    <!-- Módulos Dinámicos -->
    @php $dynamicModules = \App\Models\Module::all(); @endphp
    @foreach($dynamicModules as $module)
    <a href="{{ route('admin.modules.index', $module->name) }}" class="group bg-white p-6 sm:p-10 rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 transition transform hover:-translate-y-1 flex flex-col items-center text-center" style="border-color: {{ $module->color }}20">
        <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-2xl sm:rounded-3xl flex items-center justify-center mb-4 sm:mb-6 group-hover:text-white transition shadow-sm" style="background-color: {{ $module->color }}15; color: {{ $module->color }}; --hover-bg: {{ $module->color }}">
            <i class="{{ $module->icon }} text-2xl sm:text-4xl"></i>
        </div>
        <h3 class="text-sm sm:text-2xl font-display text-textMain tracking-wide">{{ $module->name }}</h3>
        
        <style>
            .group:hover div[style*="--hover-bg"] {
                background-color: {{ $module->color }} !important;
            }
        </style>
    </a>
    @endforeach
</div>
@endsection
