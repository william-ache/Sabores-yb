@extends('admin.layout')

@section('content')
<div class="max-w-md mx-auto mt-2">
    <div class="text-center mb-8">
        <img src="/images/brand/logo.png" alt="Logo" class="h-24 mx-auto mb-4">
        <h2 class="text-4xl font-display text-textMain tracking-tight">Acceso Restringido</h2>
        <p class="text-gray-500 font-medium">Solo para administradores de {{ $appName }}</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transform transition hover:shadow-2xl">
        <div class="p-10">
            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="mb-8">
                    <label for="password" class="block text-gray-500 text-xs font-bold uppercase tracking-widest mb-3 ml-1">Contraseña de Seguridad</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="password" name="password" id="password" 
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-12 pr-12 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" 
                            placeholder="••••••••" required autofocus>
                        <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition focus:outline-none">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-green-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary/20 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-lg">
                    <span>Entrar al Sistema</span>
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </form>
        </div>
        <div class="bg-gray-50/50 py-4 px-10 border-t border-gray-50 text-center">
            <a href="/" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center justify-center gap-2">
                <i class="fas fa-home"></i> Volver a la página principal
            </a>
        </div>
    </div>
</div>

<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
