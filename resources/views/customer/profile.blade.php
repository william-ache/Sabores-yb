@extends('customer.layout')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-0 py-10">
    <!-- Header -->
    <div class="mb-10 text-center sm:text-left">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-primary transition-all mb-6">
            <i class="fas fa-home text-xs"></i> Volver a la Tienda
        </a>
        <h2 class="text-4xl sm:text-5xl font-display text-textMain tracking-tight">Mi Perfil</h2>
        <p class="text-gray-500 font-medium mt-2 italic">¡Hola de nuevo, {{ explode(' ', $user->name)[0] }}! 👋</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <!-- Banner/Avatar Background -->
        <div class="h-32 bg-gradient-to-r from-primary to-green-600 relative">
            <div class="absolute -bottom-12 left-1/2 sm:left-12 transform -translate-x-1/2 sm:translate-x-0">
                <div class="w-24 h-24 rounded-[2rem] bg-white p-1.5 shadow-xl rotate-3 hover:rotate-0 transition-transform duration-500">
                    <div class="w-full h-full rounded-[1.5rem] overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" class="w-full h-full object-cover" alt="Profile">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=00A859&color=fff&bold=true" class="w-full h-full object-cover" alt="Profile">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-20 pb-12 px-8 sm:px-12">
            <div class="grid grid-cols-1 gap-8">
                <!-- Data -->
                <div class="space-y-6">
                    <div class="group">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Nombre Registrado</label>
                        <div class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold group-hover:border-primary/20 transition-all flex items-center gap-3">
                            <i class="fas fa-user text-gray-300"></i>
                            <span>{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Correo Electrónico</label>
                        <div class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold group-hover:border-primary/20 transition-all flex items-center gap-3">
                            <i class="fas fa-envelope text-gray-300"></i>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-6 bg-blue-50 rounded-3xl border border-blue-100 flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-500 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-blue-500/20">
                        <i class="fab fa-google"></i>
                    </div>
                    <div>
                        <h5 class="text-[10px] font-black text-blue-800 uppercase tracking-tight">Cuenta Vinculada</h5>
                        <p class="text-[11px] text-blue-700 leading-relaxed mt-1 font-medium italic">Tu perfil está sincronizado con Google. Los cambios de foto o datos deben hacerse desde tu cuenta de Google.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row gap-4">
                    <form action="{{ route('customer.logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white font-black py-4 rounded-2xl transition-all flex items-center justify-center gap-3 group">
                            <i class="fas fa-sign-out-alt transition-transform group-hover:-translate-x-1"></i>
                            <span class="uppercase text-[11px] tracking-widest">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-12 text-center">
        <p class="text-gray-300 text-[10px] font-bold uppercase tracking-[0.2em]">Sabores Y&B - Sabor Tradicional</p>
    </div>
</div>
@endsection
