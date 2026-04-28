@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('customer.dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
            <i class="fas fa-arrow-left text-xs"></i> Volver a mi cuenta
        </a>
        <h2 class="text-4xl font-display text-textMain tracking-tight">Mi Perfil</h2>
        <p class="text-gray-500 font-medium">Gestiona tu información personal.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/40 border border-gray-100 p-8 sm:p-12">
        <form class="space-y-6">
            <div>
                <label class="block text-primary text-[10px] font-bold uppercase tracking-widest mb-3 ml-1">Nombre Completo</label>
                <input type="text" value="{{ $user->name }}" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none transition" readonly>
            </div>
            <div>
                <label class="block text-primary text-[10px] font-bold uppercase tracking-widest mb-3 ml-1">Correo Electrónico</label>
                <input type="email" value="{{ $user->email }}" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none transition" readonly>
            </div>
            
            <div class="pt-4 p-6 bg-blue-50 rounded-2xl border border-blue-100 flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                <p class="text-xs text-blue-800 leading-relaxed font-medium">Tu cuenta está vinculada a Google. Los cambios de nombre o correo deben realizarse desde tu cuenta de Google.</p>
            </div>
        </form>
    </div>
</div>
@endsection
