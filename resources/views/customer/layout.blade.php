<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appName }} - Mi Perfil</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @php
        $systemPrimary = \App\Models\Setting::get('primary_color', '#00A859');
        $secondaryColor = \App\Models\Setting::get('secondary_color', '#FFBF69');
        $favicon = \App\Models\Setting::get('favicon');
    @endphp

    <link rel="icon" href="{{ $favicon ? asset('storage/' . $favicon) : asset('favicon.ico') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $systemPrimary }}',
                        secondary: '{{ $secondaryColor }}',
                        accent: '#E71D36',
                        dark: '#2EC4B6',
                        light: '#FDFFFC',
                        textMain: '#24140a'
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        display: ['Lilita One', 'cursive']
                    }
                }
            }
        }
    </script>
    <style>
        /* Modern Slim Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        ::-webkit-scrollbar-thumb {
            background: {{ $systemPrimary }};
            border-radius: 20px;
            border: 2px solid #f8fafc;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: {{ $systemPrimary }};
            filter: brightness(0.9);
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: {{ $systemPrimary }} #f8fafc;
        }

        body { font-family: 'Outfit', sans-serif; background-color: #FDFFFC; }
        .font-display { font-family: 'Lilita One', cursive; }
    </style>
</head>
<body class="bg-gray-50 text-textMain min-h-screen flex flex-col">
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        @php $logo = \App\Models\Setting::get('logo'); @endphp
                        <img src="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}" alt="Logo" class="h-10 w-auto">
                        <span class="font-display text-2xl text-primary tracking-wide hidden sm:block">Mi Cuenta</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
                            <i class="fas fa-power-off"></i> <span class="hidden sm:inline">Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 py-10 text-center">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.3em]">&copy; {{ date('Y') }} {{ $appName }}</p>
        </div>
    </footer>
</body>
</html>
