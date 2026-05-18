@extends('admin.layout')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.index') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
        <i class="fas fa-arrow-left text-xs"></i> Volver al Dashboard
    </a>
</div>

<div class="mb-10 flex flex-col items-center text-center gap-6">
    <div>
        <h2 class="text-4xl font-display text-textMain tracking-tight">Gestión de Administradores</h2>
        <p class="text-gray-500 font-medium">Controla quién tiene acceso a la plataforma.</p>
    </div>
    <a href="{{ route('users.create') }}" class="bg-dark hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-dark/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
        <i class="fas fa-plus"></i> Añadir Administrador
    </a>
</div>

<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px]">
            <thead class="bg-dark/10 border-b border-dark/10">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">ID</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Nombre</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-textMain uppercase tracking-widest">Correo Electrónico</th>
                    <th class="px-8 py-5 text-right text-xs font-bold text-textMain uppercase tracking-widest">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="hover:bg-dark/5 transition-colors duration-200">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-base font-bold text-gray-400">#{{ $user->id }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-base font-bold text-textMain">{{ $user->name }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-500">{{ $user->email }}</div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" 
                                onsubmit="event.preventDefault(); Swal.fire({
                                    title: '¿Eliminar Administrador?',
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
                                <a href="{{ route('users.edit', $user) }}" class="bg-primary/10 text-primary hover:bg-primary hover:text-white h-10 w-10 flex items-center justify-center rounded-xl transition shadow-sm" title="Editar">
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
                            <div class="text-gray-400 font-medium">Aún no hay administradores registrados.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
