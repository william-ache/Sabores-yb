<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ $appName }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Lilita+One&display=swap" rel="stylesheet">
    <!-- FontAwesome (CDN para garantizar nuevos iconos como X) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery and Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    @php
        $primaryColor = \App\Models\Setting::get('primary_color', '#00A859');
        $secondaryColor = \App\Models\Setting::get('secondary_color', '#FFBF69');
        $favicon = \App\Models\Setting::get('favicon');
    @endphp

    @if($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $primaryColor }}',
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            background: {{ $primaryColor }};
            border-radius: 20px;
            border: 2px solid #f8fafc;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: {{ $primaryColor }};
            filter: brightness(0.9);
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: {{ $primaryColor }} #f8fafc;
        }

        body { font-family: 'Outfit', sans-serif; background-color: #fefefe; }
        .font-display { font-family: 'Lilita One', cursive; }
        /* Branded SweetAlert Style */
        .swal2-popup { border-radius: 2rem !important; font-family: 'Outfit', sans-serif !important; }
        .swal2-styled.swal2-confirm { background-color: {{ $primaryColor }} !important; border-radius: 1rem !important; font-weight: bold !important; px: 2rem !important; }
        .swal2-styled.swal2-cancel { border-radius: 1rem !important; font-weight: bold !important; }

        /* Custom Select2 Branded Style */
        .select2-container--default .select2-selection--single {
            background-color: #f9fafb !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 1rem !important;
            height: 60px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 1rem !important;
            font-weight: 700 !important;
            color: #24140a !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 1.5rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #24140a !important;
            padding-left: 0 !important;
        }
        .select2-dropdown {
            border-radius: 1.5rem !important;
            border: 1px solid #f3f4f6 !important;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1) !important;
            overflow: hidden !important;
            padding: 0.5rem !important;
        }
        .select2-results__option {
            padding: 0.75rem 1rem !important;
            border-radius: 0.75rem !important;
            font-weight: 600 !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: {{ $primaryColor }} !important;
        }
        .select2-search--dropdown .select2-search__field {
            border-radius: 0.75rem !important;
            border: 1px solid #f3f4f6 !important;
            padding: 0.5rem 1rem !important;
            outline: none !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-textMain min-h-screen flex flex-col">
    <nav class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <a href="{{ session('admin_logged_in') ? route('admin.index') : '/' }}" class="shrink-0 flex items-center">
                        @php $logo = \App\Models\Setting::get('logo'); @endphp
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-10 w-auto">
                        @else
                            <img src="/images/brand/logo.png" alt="Logo" class="h-10 w-auto">
                        @endif
                    </a>
                    <div class="h-6 w-px bg-gray-200 hidden sm:block mx-1"></div>
                    <a href="{{ session('admin_logged_in') ? route('admin.index') : '/' }}" class="font-display text-2xl text-primary tracking-wide">Administración</a>
                </div>
                <div class="flex items-center gap-4">
                    @if(session('admin_logged_in'))
                        <a href="/" target="_blank" class="bg-primary/10 text-primary hover:bg-primary hover:text-white px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                            <i class="fas fa-utensils"></i> Ver Menú
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="bg-accent/10 text-accent hover:bg-accent hover:text-white px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-4 pb-12 flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-primary/10 border border-primary/20 text-primary px-6 py-4 rounded-2xl relative mb-8 flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-accent/10 border border-accent/20 text-accent px-6 py-4 rounded-2xl relative mb-8 flex items-center gap-3 shadow-sm">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-accent/10 border border-accent/20 text-accent px-6 py-4 rounded-2xl relative mb-8 flex items-center gap-3 shadow-sm">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    <div>
                        <ul class="list-disc list-inside font-bold">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400 font-medium">
        &copy; {{ date('Y') }} {{ $appName }} - Sistema Dinámico de Gestión
    </footer>
    <script>
        $(document).ready(function() {
            $('select').select2({
                width: '100%',
                language: {
                    noResults: function() { return "No se encontraron resultados"; }
                }
            });
        });
    </script>
</body>
</html>
