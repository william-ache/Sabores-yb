<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    @php 
        $primaryColor = \App\Models\Setting::get('primary_color', '#00A859');
        $secondaryColor = \App\Models\Setting::get('secondary_color', '#FFBF69');
        $logo = \App\Models\Setting::get('logo');
        $favicon = \App\Models\Setting::get('favicon');
        $appName = \App\Models\Setting::get('app_name', 'Sabores Y&B');
        $address = \App\Models\Setting::get('address', 'Maracay, Venezuela');
        $mapsLink = \App\Models\Setting::get('maps_link', 'https://maps.app.goo.gl/q1pFAsYWsYEuoX4i6');
        $schedule = \App\Models\Setting::get('schedule', 'Lunes a Sábado de 6:00 am a 1:00 pm');
        $slogan = \App\Models\Setting::get('slogan', 'Hechas con amor desde nuestra familia para la tuya.');
        $instagramUser = \App\Models\Setting::get('instagram_user', 'saboresyb');
        $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '584128853518');
        $notificationMsg = \App\Models\Setting::get('notification_msg', 'Crujientes, calientes y deliciosas. ¡Pide la tuya ahora!');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $appName }} ofrece las mejores empanadas y productos frescos.">
    <meta name="keywords" content="empanadas, comida, delivery, {{ $appName }}, {{ $address }}">
    <meta name="author" content="{{ $appName }}">
    <meta property="og:title" content="{{ $appName }} | Sabor Tradicional">
    <meta property="og:description" content="Pide online las mejores empanadas y productos frescos en {{ $address }}.">
    <meta property="og:image" content="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}">
    <meta property="og:type" content="website">
    <title>{{ $appName }}</title>

    <!-- Favicon & PWA -->
    <link rel="icon" type="image/png" href="{{ $favicon ? asset('storage/' . $favicon) : ($logo ? asset('storage/' . $logo) : '/images/brand/logo.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="{{ $primaryColor }}">
    <!-- Mobile Optimization -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $appName }}">
    <link rel="apple-touch-icon" href="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Lilita+One&display=swap"
        rel="stylesheet">

    <!-- SweetAlert2 -->
    <style>
    .swal2-popup { border-radius: 2rem !important; font-family: 'Outfit', sans-serif !important; border: 4px solid #fefefe !important; }
    .swal2-title { font-family: 'Lilita One', cursive !important; color: #24140a !important; font-size: 1.8rem !important; }
    .swal2-confirm { background-color: {{ $primaryColor }} !important; border-radius: 1rem !important; font-weight: 800 !important; padding: 0.8rem 2rem !important; box-shadow: 0 10px 15px -3px rgba(0, 168, 89, 0.2) !important; }
    .swal2-cancel { border-radius: 1rem !important; font-weight: 600 !important; }
</style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Tailwind CSS (Local) -->
    <script src="/js/tailwindcss.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $primaryColor }}',    /* Green (Logo) */
                        secondary: '{{ $secondaryColor }}',  /* Light Orange */
                        accent: '#E71D36',     /* Redish */
                        dark: '#2EC4B6',       /* Teal accent */
                        light: '#FDFFFC',      /* Off White */
                        textMain: '#24140a'
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        display: ['Lilita One', 'cursive']
                    },
                    keyframes: {
                        shake: {
                            '0%, 100%': { transform: 'translateX(0)' },
                            '25%': { transform: 'translateX(-4px)' },
                            '75%': { transform: 'translateX(4px)' },
                        }
                    },
                    animation: {
                        'shake': 'shake 0.3s ease-in-out infinite',
                        'shake-slow': 'shake 2s ease-in-out infinite'
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome for Icons (CDN para garantizar nuevos iconos como X) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS Base -->
    <style>
        body {
            background-color: #FDFFFC;
            color: #24140a;
        }

        /* Smooth reveal animation for elements */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Nice blob background for hero */
        .hero-blob {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 159, 28, 0.2) 0%, rgba(255, 159, 28, 0) 70%);
            border-radius: 50%;
            z-index: -1;
        }

        .food-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .food-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .counter-btn:active {
            transform: scale(0.9);
        }

        /* Attention-grabbing shake animation */
        @keyframes shake-btn {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-2px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(2px);
            }
        }

        .animate-shake-attention {
            animation: shake-btn 5s cubic-bezier(.36, .07, .19, .97) infinite;
        }

        /* Jumping animation for Google Login */
        @keyframes jump-google {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-jump-google {
            animation: jump-google 1.5s ease-in-out infinite;
        }

        /* Adjustments for Installed App (Standalone) Mode */
        @media (display-mode: standalone) {
            #navbar .nav-logo {
                height: 3rem !important;
            }

            /* h-12 instead of h-14 */
            footer {
                display: none !important;
            }
        }
    </style>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>

<body class="font-sans antialiased overflow-x-hidden relative">

    <!-- Splash Screen / Loading View (App launch simulation) -->
    <div id="pwa-splash" class="fixed inset-0 bg-white z-[1000] flex flex-col items-center justify-center transition-opacity duration-700">
        <div class="flex flex-col items-center animate-pulse">
            <img src="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}" alt="{{ $appName }}" class="w-48 h-48 object-contain mb-4">
            <h1 class="text-3xl font-display text-textMain tracking-wide">{!! $appName !!}</h1>
        </div>
        <div class="absolute bottom-12 left-0 w-full text-center">
            <p class="text-gray-300 text-[10px] font-mono tracking-widest">VERSION 1.0.0</p>
        </div>
    </div>

    <!-- Branch Selection Modal (Multi-site) -->
    @if($branches->count() > 1)
    <div id="branch-selector-modal" class="fixed inset-0 z-[900] bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-secondary/20 rounded-full flex items-center justify-center mb-6">
                <img src="/images/icons/location-marker.png" alt="Sede" class="w-16 h-16 object-contain" onerror="this.src='https://cdn-icons-png.flaticon.com/512/854/854878.png'">
            </div>
            
            <h2 class="text-2xl font-display text-textMain mb-2">Selecciona la sede más cercana a tu domicilio</h2>
            <p class="text-gray-400 text-sm mb-8">Entregas más rápidas y promociones especiales.</p>

            <button onclick="autoSelectNearestBranch()" class="w-full bg-secondary hover:bg-orange-500 text-white font-extra-bold py-4 rounded-2xl shadow-lg shadow-secondary/20 transition mb-6 flex items-center justify-center gap-2">
                <i class="fas fa-location-arrow"></i>
                Escoger sede más cercana
            </button>

            <div class="w-full border-t border-gray-100 pt-6">
                <div class="relative w-full">
                    <select id="branch-list-select" onchange="selectBranch(this.value)" class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-4 px-6 text-textMain font-bold appearance-none outline-none focus:ring-2 focus:ring-secondary/30 transition cursor-pointer">
                        <option value="">Selecciona una sede</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" data-lat="{{ $branch->lat }}" data-lng="{{ $branch->lng }}" data-name="{{ $branch->name }}" data-whatsapp="{{ $branch->whatsapp }}" data-address="{{ $branch->address }}">
                            {{ $branch->name }} - Delivery - PickUp
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- PWA Installation Modal (Onboarding) -->
    <div id="install-pwa-modal"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div
            class="bg-white rounded-[2.5rem] p-8 max-w-sm w-full shadow-2xl transform scale-95 transition-transform duration-300 relative overflow-hidden text-center border border-orange-100">
            <!-- Decorative blur background -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-accent/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <h2 class="text-2xl font-display font-medium text-textMain mb-2">¡{{ $appName }} en el Inicio de tu
                    dispositivo!</h2>

                <!-- Company Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}" alt="{{ $appName }}" class="w-28 h-28 object-contain drop-shadow-md hover:scale-105 transition-transform duration-500">
                </div>

                <!-- Android Specific Section -->
                <div id="android-install-view" class="hidden animate-in fade-in zoom-in duration-300">
                    <p class="text-gray-600 mb-8 text-sm leading-relaxed font-medium">Instala nuestra App para pedir más
                        rápido y disfrutar de la mejor experiencia.</p>
                    <button id="btn-pwa-install-now"
                        class="w-full bg-gradient-to-r from-primary to-green-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary/25 hover:scale-[1.02] active:scale-95 transition-all text-base mb-3">
                        Instalar aplicación
                    </button>
                </div>

                <!-- iOS Specific Section -->
                <div id="ios-install-view" class="hidden animate-in fade-in zoom-in duration-300">
                    <p class="text-gray-600 mb-6 text-sm leading-relaxed font-medium">Instala nuestra App para pedir más
                        rápido.</p>

                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl text-left mb-6">
                        <p class="text-xs text-blue-700 font-medium mb-3 leading-relaxed text-center">
                            Sigue estos pasos en tu iPhone/iPad:
                        </p>
                        <ol class="text-[11px] text-blue-600 space-y-2 list-decimal list-inside ml-1 font-medium">
                            <li>Presiona el botón <span
                                    class="bg-white px-1.5 py-0.5 rounded border border-blue-200">Compartir <i
                                        class="far fa-share-square"></i></span></li>
                            <li>Selecciona <span class="bg-white px-1.5 py-0.5 rounded border border-blue-200">"Añadir a
                                    la pantalla de inicio" <i class="far fa-plus-square"></i></span></li>
                            <li>Pulsa <span class="font-bold text-blue-800 underline">Añadir</span> en la esquina
                                superior.</li>
                        </ol>
                    </div>
                </div>

                <button id="btn-pwa-close-modal"
                    class="w-full bg-gray-50 text-gray-400 font-semibold py-3 rounded-2xl hover:bg-gray-100 transition-colors text-sm">
                    Luego
                </button>
            </div>
        </div>
    </div>

    <!-- Floating Cart Button -->
    <button id="cart-toggle-btn"
        class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-accent text-white w-14 h-14 sm:w-16 sm:h-16 rounded-full shadow-2xl flex items-center justify-center text-xl sm:text-2xl z-50 hover:bg-red-700 transition hover:scale-110">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-badge"
            class="absolute -top-2 -right-2 bg-yellow-400 text-textMain text-sm font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-white scale-0 transition-transform duration-300">0</span>
    </button>

    <!-- Unified Checkout MODAL (Full Screen Flow) -->
    <div id="checkout-modal" class="fixed inset-0 h-screen h-[100dvh] z-[100] bg-white hidden flex-col transition-all duration-500 overflow-hidden">
        <!-- Header -->
        <div class="px-4 py-4 sm:px-6 sm:py-6 border-b border-gray-100 flex items-center justify-between bg-white shrink-0 relative">
            <div class="absolute left-6 top-1/2 -translate-y-1/2">
                <button id="btn-checkout-back" class="text-gray-400 hover:text-textMain transition flex items-center gap-2 p-2 -ml-2">
                    <i class="fas fa-arrow-left"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest mt-0.5">Atrás</span>
                </button>
            </div>
            <h3 class="font-display text-xl sm:text-2xl text-textMain mx-auto tracking-tight">Finalizar Pedido</h3>
            <div class="absolute right-6 top-1/2 -translate-y-1/2">
                <button id="btn-checkout-close" class="text-gray-400 hover:text-red-500 transition p-2 -mr-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Progress Stepper -->
        <div class="px-4 py-3 sm:px-6 sm:py-4 bg-gray-50/50 border-b border-gray-100 flex justify-center items-center gap-6 sm:gap-10 shrink-0 overflow-x-auto scrollbar-hide">
            <div class="flex flex-col items-center gap-2">
                <div class="checkout-step-dot active w-3 h-3 rounded-full bg-primary ring-4 ring-primary/10 transition-all duration-300" data-step="1"></div>
                <span class="text-[8px] font-black text-primary uppercase whitespace-nowrap">Tu Orden</span>
            </div>
            <div class="w-8 sm:w-12 h-px bg-gray-200 -mt-5"></div>
            <div class="flex flex-col items-center gap-2">
                <div class="checkout-step-dot w-3 h-3 rounded-full bg-gray-200 transition-all duration-300" data-step="2"></div>
                <span class="text-[8px] font-black text-gray-400 uppercase whitespace-nowrap">Entrega</span>
            </div>
            <div class="w-8 sm:w-12 h-px bg-gray-200 -mt-5"></div>
            <div class="flex flex-col items-center gap-2">
                <div class="checkout-step-dot w-3 h-3 rounded-full bg-gray-200 transition-all duration-300" data-step="3"></div>
                <span class="text-[8px] font-black text-gray-400 uppercase whitespace-nowrap">Detalles</span>
            </div>
            <div class="w-8 sm:w-12 h-px bg-gray-200 -mt-5"></div>
            <div class="flex flex-col items-center gap-2">
                <div class="checkout-step-dot w-3 h-3 rounded-full bg-gray-200 transition-all duration-300" data-step="4"></div>
                <span class="text-[8px] font-black text-gray-400 uppercase whitespace-nowrap">Confirmar</span>
            </div>
        </div>

        <!-- Screens Container -->
        <div class="flex-grow overflow-y-auto p-4 sm:p-10 relative bg-white">
            <div class="max-w-xl mx-auto">
                
                <!-- STEP 1: Revise Items -->
                <div id="checkout-step-1" class="checkout-screen flex flex-col h-full animate-in fade-in duration-300">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h4 class="text-xl font-display text-textMain tracking-tight">Tu Selección</h4>
                            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">Revisa los productos seleccionados</p>
                        </div>
                        <button id="clear-cart-btn" class="text-[9px] text-red-500 font-black uppercase tracking-widest bg-red-50 px-3 py-2 rounded-xl hover:bg-red-200 transition active:scale-95"><i class="fas fa-trash-alt mr-1"></i>Vaciar</button>
                    </div>

                    <div id="cart-items" class="space-y-4 mb-10 overflow-y-visible">
                        <!-- Items inyectados por JS -->
                    </div>

                    <div class="mt-auto pt-6 border-t border-gray-100 bg-white sticky bottom-0 shadow-[0_-20px_20px_-10px_rgba(255,255,255,0.9)]">
                        <div class="flex justify-between items-end mb-8">
                            <div>
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest block mb-1">Monto Total</span>
                                <span id="cart-total" class="font-display text-4xl text-primary leading-none transition-all duration-300 block">Bs. 0.00</span>
                                <span id="cart-total-usd" class="text-xs text-gray-400 font-bold uppercase tracking-tight mt-2 block">Ref: $0.00</span>
                            </div>
                        </div>
                        <button id="btn-next-to-type" class="w-full bg-primary text-white font-black py-5 rounded-2xl shadow-xl shadow-primary/25 flex items-center justify-center gap-3 group transition-all hover:scale-[1.01] active:scale-95">
                            <span class="text-base uppercase tracking-widest">Siguiente Paso</span>
                            <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: Delivery Type Selection -->
                <div id="checkout-step-2" class="checkout-screen hidden animate-in fade-in slide-in-from-right duration-500">
                    <div class="text-center mb-10">
                        <h4 class="text-2xl font-display text-textMain tracking-tight">¿Cómo prefieres recibirlo?</h4>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-2">Selecciona una modalidad</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <button id="btn-select-pickup" class="relative group bg-white border-2 border-gray-100 hover:border-primary rounded-[2.5rem] p-8 text-left transition-all shadow-xl shadow-gray-200/20 active:scale-95 overflow-hidden">
                            <div class="flex items-center gap-6 relative z-10">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-primary text-2xl group-hover:bg-primary group-hover:text-white transition-all shrink-0">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="flex-grow">
                                    <h5 class="font-display text-xl text-textMain">Retiro en Local</h5>
                                    <p class="text-xs text-gray-400 font-medium leading-relaxed mt-1">PickUp directo en nuestra sede.</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-200 group-hover:text-primary transition-colors"></i>
                            </div>
                        </button>

                        <button id="btn-select-delivery" class="relative group bg-white border-2 border-gray-100 hover:border-orange-500 rounded-[2.5rem] p-8 text-left transition-all shadow-xl shadow-gray-200/20 active:scale-95 overflow-hidden">
                            <div class="flex items-center gap-6 relative z-10">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-orange-500 text-2xl group-hover:bg-orange-500 group-hover:text-white transition-all shrink-0">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <div class="flex-grow">
                                    <h5 class="font-display text-xl text-textMain">Envío (Delivery)</h5>
                                    <p class="text-xs text-gray-400 font-medium leading-relaxed mt-1">Llevamos el sabor hasta tu ubicación.</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-200 group-hover:text-orange-500 transition-colors"></i>
                            </div>
                        </button>
                    </div>

                    <div class="mt-12 text-center">
                        <button class="btn-step-back py-3 px-6 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-textMain transition-all">
                            <i class="fas fa-arrow-left mr-2"></i> Volver al Carrito
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Delivery Details (MAPA / PICKUP INFO) -->
                <div id="checkout-step-3" class="checkout-screen hidden animate-in fade-in slide-in-from-right duration-500 pb-20">
                    <div id="view-delivery-input" class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h4 class="text-xl font-display text-textMain tracking-tight">Tu Ubicación</h4>
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mt-0.5">Indica el destino del envío</p>
                            </div>
                            <div class="bg-orange-50 text-orange-600 text-[8px] font-black px-2 py-1.5 rounded-lg border border-orange-100 whitespace-nowrap">
                                TARIFA: $0.43 / KM
                            </div>
                        </div>
 
                        <div class="text-center">
                            <button id="btn-use-gps" type="button" class="group inline-flex items-center gap-3 bg-white border-2 border-primary/20 hover:border-primary px-5 py-3 rounded-[2rem] text-[11px] font-black uppercase tracking-widest text-primary shadow-xl shadow-primary/5 transition-all active:scale-95 mb-3">
                                <div class="w-8 h-8 bg-primary/10 rounded-xl flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                                    <i class="fas fa-location-arrow text-xs"></i>
                                </div>
                                <div class="text-left">
                                    <div class="text-[7px] text-gray-400 font-bold leading-none mb-0.5">Detectar automáticamente</div>
                                    <div class="leading-none tracking-tight">Mi Ubicación GPS</div>
                                </div>
                            </button>
                            <p class="text-[9px] text-gray-400 font-medium italic mb-4">
                                <i class="fas fa-info-circle mr-1 text-primary/40"></i> Mueve el marcador naranja si es necesario
                            </p>
                        </div>

                        <div id="delivery-map" class="w-full h-40 sm:h-64 bg-gray-100 rounded-[2rem] border-4 border-gray-50 shadow-inner z-0 overflow-hidden mb-4 relative">
                        </div>

                        <div class="space-y-1 mb-4">
                            <label class="text-[8px] text-gray-300 font-black uppercase tracking-widest ml-1">Tu Dirección (Referencial)</label>
                            <textarea id="delivery-address-manual" rows="2" placeholder="Cargando dirección..." class="w-full bg-gray-50 border border-gray-100 rounded-xl py-3 px-5 text-[11px] font-bold focus:bg-white focus:ring-4 focus:ring-primary/5 transition outline-none resize-none leading-tight"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="text-[8px] text-gray-300 font-black uppercase tracking-widest ml-1">Tu Nombre</label>
                                <input type="text" id="delivery-name" placeholder="Ej: Juan P." class="w-full bg-gray-50 border border-gray-100 rounded-xl py-3 px-5 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-primary/5 transition outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[8px] text-gray-300 font-black uppercase tracking-widest ml-1">Tu Teléfono</label>
                                <input type="tel" id="delivery-phone" placeholder="Ej: 0412..." class="w-full bg-gray-50 border border-gray-100 rounded-xl py-3 px-5 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-primary/5 transition outline-none">
                            </div>
                        </div>

                        <div class="bg-orange-50/40 p-4 rounded-[1.5rem] border border-orange-100 flex justify-between items-center mt-4">
                            <div>
                                <span class="text-[8px] text-orange-400 font-black uppercase tracking-widest ml-1 block mb-0.5">Costo Estimado</span>
                                <p class="text-[9px] text-gray-500 font-black italic"><i class="fas fa-route mr-1 text-orange-300"></i> <span id="delivery-distance">0.00</span> km</p>
                            </div>
                            <div class="text-right">
                                <span id="delivery-cost" class="font-display text-2xl text-orange-600 tracking-tighter leading-none block">Bs. 0.00</span>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tight opacity-70">Ref: $0.00</span>
                            </div>
                        </div>

                        <button id="btn-confirm-delivery" class="w-full bg-orange-500 text-white font-black py-4 rounded-[1.5rem] shadow-xl shadow-orange-500/20 flex items-center justify-center gap-3 mt-4 transition-all hover:scale-[1.01] active:scale-95">
                            <span class="uppercase text-xs tracking-widest">Confirmar Datos</span>
                            <i class="fas fa-check-circle text-sm"></i>
                        </button>

                        <button class="btn-step-back w-full py-2 text-[9px] font-black uppercase tracking-widest text-gray-400 hover:text-textMain transition-all">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </button>
                    </div>
                </div>

                    <div id="view-pickup-info" class="hidden text-center py-10 animate-in zoom-in duration-300 space-y-8">
                        <div class="w-32 h-32 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-primary text-5xl ring-8 ring-primary/5 animate-pulse">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <h4 class="text-3xl font-display text-textMain tracking-tight">¡Genial! Vienes al Local</h4>
                            <p class="text-gray-400 text-sm max-w-xs mx-auto mt-6 leading-relaxed font-medium">Te esperamos en la siguiente dirección: <br><b class="text-textMain block mt-2 text-base font-display">{!! $address !!}</b></p>
                        </div>
                        <button id="btn-confirm-pickup" class="w-full bg-primary text-white font-black py-5 rounded-[2rem] shadow-2xl shadow-primary/30 flex items-center justify-center gap-4 transition-all hover:scale-[1.01] active:scale-95">
                            <span class="uppercase tracking-widest">Siguiente</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>

                        <button class="btn-step-back w-full py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-textMain transition-all">
                            <i class="fas fa-arrow-left mr-2"></i> Volver al paso anterior
                        </button>
                    </div>
                </div>

                <!-- STEP 4: Checkout Summary -->
                <div id="checkout-step-4" class="checkout-screen hidden animate-in fade-in duration-500 text-center space-y-10 pb-32">
                    <div class="space-y-3">
                        <h4 class="text-3xl font-display text-textMain tracking-tight">Resumen Final</h4>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Todo listo para enviar</p>
                    </div>

                    <div class="bg-gray-50/50 rounded-[3rem] p-8 sm:p-10 space-y-6 text-left border border-gray-100 shadow-inner">
                        <!-- Items List -->
                        <div id="summary-items" class="space-y-4 border-b border-gray-200 pb-6 mb-6">
                            <!-- Items inyectados por JS -->
                        </div>

                        <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                            <span class="text-[10px] text-gray-300 font-black uppercase tracking-widest">Tipo de Orden</span>
                            <span id="summary-type" class="text-sm font-black uppercase text-textMain tracking-tight">---</span>
                        </div>
                        <div id="summary-delivery-row" class="hidden flex justify-between items-center border-b border-gray-200 pb-4">
                            <span class="text-[10px] text-gray-300 font-black uppercase tracking-widest">Costo Delivery</span>
                            <span id="summary-delivery-cost" class="text-sm font-black text-orange-600 italic">Bs. 0.00</span>
                        </div>
                        <div class="flex justify-between items-end pt-6">
                            <span class="text-lg font-display text-textMain leading-none">TOTAL NETO</span>
                            <div class="text-right">
                                <span id="summary-total-bs" class="text-4xl font-display text-primary block leading-none">Bs. 0.00</span>
                                <span id="summary-total-usd" class="text-xs text-gray-400 font-black uppercase tracking-tight mt-2 block">Ref: $0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-sky-50 p-6 rounded-[2.5rem] border border-sky-100 text-left flex gap-5">
                        <div class="w-12 h-12 bg-sky-500 rounded-2xl flex items-center justify-center text-white text-xl shrink-0 shadow-lg shadow-sky-500/20">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div>
                            <h5 class="text-[10px] font-black text-sky-800 uppercase tracking-tight">Instrucciones WhatsApp</h5>
                            <p class="text-[11px] text-sky-700 leading-relaxed mt-1 font-medium italic">Al presionar el botón inferior se abrirá WhatsApp. Envía el mensaje generado para que podamos comenzar con tu pedido.</p>
                        </div>
                    </div>

                    <button id="btn-confirm-whatsapp" class="w-full bg-green-500 text-white font-black py-6 rounded-[2.5rem] shadow-2xl shadow-green-500/40 flex items-center justify-center gap-4 transition-all hover:scale-[1.02] active:scale-95 group relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <i class="fab fa-whatsapp text-3xl transition-transform group-hover:scale-110 group-hover:rotate-6"></i>
                        <span class="text-xl uppercase tracking-widest">Enviar por WhatsApp</span>
                    </button>
                    
                    <button class="btn-step-back w-full py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-textMain transition-all">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al paso anterior
                    </button>

                    <button id="btn-test-continue" class="text-[9px] text-gray-300 font-black uppercase tracking-widest hover:text-gray-500 transition mt-4">Omitir horario para pruebas</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-md shadow-sm z-40 top-0 left-0 transition-all duration-300"
        id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="#menu" class="flex-shrink-0 flex items-center space-x-3 cursor-pointer">
                    <img class="h-20 w-auto drop-shadow-md nav-logo hover:scale-105 transition-transform duration-300" src="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}"
                        alt="{{ $appName }} Logo">
                    <span class="font-display tracking-wide text-xl text-primary drop-shadow-sm hidden sm:block">{!! $appName !!}</span>
                </a>

                <!-- Navbar BCV Rate Display -->
                <div class="flex-grow flex flex-col items-center justify-center md:flex-initial mx-2">
                    <div id="bcv-rate-navbar"
                        class="bg-blue-50 border border-blue-100 px-3 py-1 rounded-full shadow-sm flex items-center gap-2 whitespace-nowrap leading-none">
                        <span class="text-blue-800 font-bold text-sm sm:text-base">
                            <i class="fas fa-money-bill-wave mr-1 text-green-600"></i> Tasa BCV: <span
                                class="rate-val text-green-600 ml-1">...</span>
                        </span>
                    </div>
                    <span id="bcv-date" class="text-[10px] sm:text-xs text-gray-500 font-medium mt-1"></span>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Google Login Button (Jumping) - Now always visible and in place of the menu -->
                    <button onclick="showGoogleLoginAlert()" class="flex flex-col items-center group animate-jump-google hover:animate-none">
                        <div class="bg-white border-2 border-gray-100 shadow-sm rounded-full p-2 group-hover:bg-gray-50 transition-colors">
                            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-6 h-6">
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 uppercase -mt-0.5">Entrar</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Schedule & Location Banner -->
        <div class="bg-primary py-1.5 border-t border-white/10">
            <div
                class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-center items-center gap-1 sm:gap-4 text-xs sm:text-sm font-bold text-white sm:whitespace-nowrap sm:overflow-x-auto scrollbar-hide">
                <div class="flex flex-row items-center gap-2">
                    <span id="schedule-text" class="flex items-center gap-1.5">
                        <i class="fas fa-clock text-white/80"></i> {{ $schedule }}
                    </span>
                    <span id="store-status-badge"
                        class="px-2 py-0.5 text-[9px] sm:text-[10px] rounded-full uppercase tracking-wider font-extrabold shadow-sm transition-colors duration-300"></span>
                </div>
                <span class="opacity-30 hidden sm:inline">|</span>
                <a id="branch-banner-link" href="{{ $mapsLink }}" target="_blank"
                    class="flex items-center gap-1.5 hover:text-white/80 transition group">
                    <i class="fas fa-map-marker-alt text-red-500/80 group-hover:animate-bounce"></i>
                    <span id="branch-banner-text"
                        class="underline decoration-2 underline-offset-4 decoration-red-500/30 group-hover:decoration-red-500">Ubícanos
                        en {!! $address !!}</span>
                </a>
                @if($branches->count() > 1)
                <button onclick="showBranchSelector()" class="ml-2 text-[10px] bg-white/20 hover:bg-white/40 px-2 py-0.5 rounded-md transition border border-white/20 whitespace-nowrap">
                    Cambiar Sede <i class="fas fa-sync-alt ml-1 text-[8px]"></i>
                </button>
                @endif
            </div>
        </div>
    </nav>

    <!-- Padding for fixed navbar + banner -->
    <div class="pt-32"></div>

    <!-- Menu Section -->
    <section id="menu" class="py-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-5xl text-textMain font-display mb-4">Menú</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Selecciona tus empanadas y cantidades. Luego
                    <b>confirma la disponibilidad</b> en WhatsApp antes de realizar tu pago.
                </p>
                <div class="w-24 h-1 bg-accent mx-auto rounded-full mt-6"></div>
            </div>

            <!-- Search & Filters Container -->
            <div class="mb-12 max-w-2xl mx-auto space-y-6 reveal">
                <!-- Search Bar -->
                <div class="relative group">
                    <div class="absolute left-5 top-1/2 -translate-y-1/2 flex items-center gap-2">
                        <div class="w-0.5 h-6 bg-primary/20 rounded-full"></div>
                        <i class="fas fa-search text-gray-300 text-sm group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input type="text" id="product-search" placeholder="¿Qué se te antoja?" 
                           class="w-full bg-white border-2 border-gray-100 rounded-2xl py-3.5 pl-14 pr-6 text-textMain font-bold text-base shadow-xl shadow-gray-200/40 focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition-all placeholder:text-gray-300">
                </div>

                <!-- Categories Filter Horizontal -->
                <div class="relative">
                    <div class="flex items-center gap-4 overflow-x-auto pb-4 px-2 scrollbar-hide -mx-2 scroll-smooth" id="categories-scroller">
                        <!-- Botón TODO -->
                        <button class="category-filter-btn flex flex-col items-center gap-2 shrink-0 group active" data-category="all">
                            <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 group-hover:bg-primary group-hover:text-white group-[.active]:bg-primary group-[.active]:text-white shadow-lg shadow-transparent group-[.active]:shadow-primary/20 transition-all duration-300 border-2 border-transparent group-[.active]:border-white">
                                <i class="fas fa-border-all text-xl"></i>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 group-[.active]:text-primary transition-all">Todo</span>
                        </button>

                        @foreach($categories as $category)
                        <button class="category-filter-btn flex flex-col items-center gap-2 shrink-0 group" data-category="cat-{{ $category->id }}">
                            <div class="w-14 h-14 rounded-2xl bg-white border-2 border-gray-50 flex items-center justify-center text-gray-400 group-hover:text-white group-[.active]:text-white shadow-lg shadow-transparent group-[.active]:shadow-primary/20 transition-all duration-300 group-hover:scale-105 active:scale-95"
                                 style="--cat-color: {{ $category->color }}"
                                 onmouseover="this.style.backgroundColor='{{ $category->color }}'; this.style.borderColor='{{ $category->color }}'"
                                 onmouseout="if(!this.closest('.group').classList.contains('active')){ this.style.backgroundColor='white'; this.style.borderColor='#f9fafb' }">
                                <i class="{{ $category->icon ?: 'fas fa-utensils' }} text-xl transition-transform group-hover:rotate-12"></i>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 group-hover:text-textMain group-[.active]:text-primary transition-all">{{ $category->name }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Dynamic Menu Section -->
            @foreach($categories as $category)
            @if($category->products->count() > 0)
            <div class="mb-20 category-section" id="cat-{{ $category->id }}">
                <div class="flex items-center gap-4 mb-10 reveal">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg" style="background-color: {{ $category->color }}">
                        <i class="{{ $category->icon ?: 'fas fa-utensils' }} text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-display text-textMain">{{ $category->name }}</h3>
                    <div class="h-px bg-gray-200 flex-grow"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-6">
                    @foreach($category->products as $product)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 food-card reveal" data-title="{{ strtolower($product->title) }}">
                        <div class="relative h-28 sm:h-36 lg:h-40 overflow-hidden bg-gray-100">
                            @if(str_contains(strtolower($category->name), 'especial'))
                                <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-accent to-orange-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    <i class="fas fa-crown mr-1"></i> Especial
                                </div>
                            @endif
                            <!-- Product Image -->
                            <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : '/images/brand/logo.png' }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-3 sm:p-5">
                            <h4 class="text-sm sm:text-base font-bold text-center text-textMain mb-1 sm:mb-2 leading-tight min-h-[40px] flex items-center justify-center">{{ $product->title }}</h4>
                            <div class="flex flex-col items-center justify-center text-center mb-2 sm:mb-4">
                                <div><span class="price-display font-display text-base sm:text-xl text-accent block" data-dolar="{{ $product->price }}"><i class="fas fa-spinner fa-spin text-sm"></i></span><span class="text-[9px] sm:text-xs text-gray-400 block -mt-1 sm:mt-0">Ref: ${{ number_format($product->price, 2) }}</span></div>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex items-center bg-gray-50 rounded-xl overflow-hidden border border-gray-200 shadow-sm transition-all hover:border-gray-300 w-1/2">
                                    <button class="qty-btn minus flex-1 py-1.5 text-base font-bold hover:bg-white transition-colors text-accent counter-btn" data-target="qty-prod-{{ $product->id }}">-</button>
                                    <input type="number" id="qty-prod-{{ $product->id }}" class="w-10 text-center bg-white border-x border-gray-200 font-bold text-base px-0 py-1.5 focus:ring-0 outline-none" value="1" min="1" readonly>
                                    <button class="qty-btn plus flex-1 py-1.5 text-base font-bold hover:bg-white transition-colors text-primary counter-btn" data-target="qty-prod-{{ $product->id }}">+</button>
                                </div>
                                <button class="add-to-cart-btn w-1/2 bg-primary text-white font-bold py-2 text-xs sm:text-sm rounded-full hover:bg-green-600 transition shadow-md flex items-center justify-center text-center leading-[1.1]" data-qty="qty-prod-{{ $product->id }}" data-name="{{ $product->title }}" data-price="{{ $product->price }}">Añadir</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach

            @if($categories->isEmpty())
            <div class="text-center text-gray-500 py-10">
                <i class="fas fa-box-open text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg">Pronto subiremos nuestros deliciosos productos.</p>
            </div>
            @endif

        </div>
    </section>

    <!-- Payment Section (Hidden initially) -->
    <section id="pagos" class="py-24 bg-gray-50 hidden">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center active">
                <div
                    class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h2 class="text-3xl font-display text-textMain mb-4">¡Casi listo! Realiza tu Pago</h2>
                <p class="text-gray-600 mb-6 font-medium">Por favor realiza el pago y repórtalo en WhatsApp antes de que
                    el tiempo termine.<br><span class="text-sm font-normal text-gray-500">De lo contrario, tu sesión se
                        reiniciará por seguridad para evitar errores con los montos a transferir.</span></p>

                <!-- Countdown Timer -->
                <div
                    class="bg-orange-50 border border-orange-200 rounded-2xl p-4 mb-8 mx-auto max-w-sm flex flex-col items-center justify-center shadow-sm">
                    <p class="text-orange-800 text-sm font-bold mb-1"><i
                            class="fas fa-stopwatch mr-1 animate-pulse"></i> Tienes 20 minutos para pagar</p>
                    <div id="payment-timer" class="text-4xl font-display text-orange-600 font-bold tracking-wider">20:00
                    </div>
                </div>

                <div class="mb-8 max-w-md mx-auto">
                    <div
                        class="bg-red-50 rounded-3xl p-6 md:p-8 border-2 border-red-200 text-left relative overflow-hidden shadow-lg shadow-red-100/50">
                        <!-- Decorative circle -->
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-red-100 rounded-full opacity-50"></div>

                        <div class="flex justify-between items-end mb-6 relative z-10">
                            <h3 class="font-bold text-red-800 text-xl flex items-center gap-2">
                                <i class="fas fa-mobile-alt text-2xl"></i> Pago Móvil
                            </h3>
                            <span
                                class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-md font-semibold uppercase tracking-wide">Bco.
                                Venezuela</span>
                        </div>

                        <div
                            class="space-y-3 relative z-10 bg-white/70 p-4 rounded-2xl border border-red-100 mb-6 shadow-inner overflow-hidden">
                            <div class="flex justify-between items-center border-b border-red-50 pb-2">
                                <span class="text-gray-500 text-sm">Banco</span>
                                <div class="flex items-center gap-1 sm:gap-2">
                                    <span class="text-red-900 font-sans font-semibold text-base sm:text-lg">0102
                                        (Venezuela)</span>
                                    <button
                                        class="text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition p-1 sm:p-2 copy-btn-single"
                                        data-copy="0102" title="Copiar Banco"><i class="far fa-copy"></i></button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center border-b border-red-50 pb-2">
                                <span class="text-gray-500 text-sm">Teléfono</span>
                                <div class="flex items-center gap-1 sm:gap-2">
                                    <span
                                        class="text-red-900 font-sans font-semibold text-base sm:text-lg">04161071344</span>
                                    <button
                                        class="text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition p-1 sm:p-2 copy-btn-single"
                                        data-copy="04161071344" title="Copiar Teléfono"><i
                                            class="far fa-copy"></i></button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center border-b border-red-50 pb-2">
                                <span class="text-gray-500 text-sm">Cédula</span>
                                <div class="flex items-center gap-1 sm:gap-2">
                                    <span
                                        class="text-red-900 font-sans font-semibold text-base sm:text-lg">V12993940</span>
                                    <button
                                        class="text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition p-1 sm:p-2 copy-btn-single"
                                        data-copy="V12993940" title="Copiar Cédula"><i class="far fa-copy"></i></button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-2 mt-2">
                                <span class="text-primary text-sm font-semibold">Monto Exacto</span>
                                <div class="flex items-center gap-1 sm:gap-2">
                                    <span
                                        class="text-primary font-sans font-semibold text-xl sm:text-2xl drop-shadow-sm"
                                        id="pago-total-bs">Bs. 0.00</span>
                                    <button
                                        class="text-red-400 hover:text-red-700 hover:bg-red-50 rounded-lg transition p-1 sm:p-2 copy-btn-single text-lg"
                                        id="btn-copy-monto" data-copy="0.00" title="Copiar Monto exacto"><i
                                            class="far fa-copy"></i></button>
                                </div>
                            </div>
                        </div>

                        <button id="btn-copy-data"
                            class="relative z-10 w-full bg-white text-red-600 border border-red-200 font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition hover:bg-red-600 hover:text-white hover:border-red-600 shadow-sm group">
                            <i class="fas fa-copy group-hover:scale-110 transition-transform"></i> <span
                                id="text-copy-data">Copiar datos del pago</span>
                        </button>
                    </div>
                </div>

                <button id="btn-completar-pedido"
                    class="w-full bg-green-500 text-white font-bold py-4 rounded-full hover:bg-green-600 transition shadow-lg shadow-green-500/30 text-lg flex items-center justify-center mt-6 group">
                    <i class="fab fa-whatsapp text-2xl mr-2 group-hover:scale-110 transition-transform"></i> Reportar
                    Pago en WhatsApp
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-textMain py-8 text-white text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <img src="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}" alt="{{ $appName }}"
                class="h-16 mx-auto mb-4 brightness-0 invert opacity-90 footer-logo">
            <h5 class="text-2xl font-display mb-2 text-primary">{{ $appName }}</h5>
            <p class="text-gray-400 mb-6 max-w-sm mx-auto text-sm">{{ $slogan }}</p>
 
            <div class="flex justify-center flex-wrap gap-x-8 gap-y-4 text-gray-300 font-bold mb-8 text-sm">
                @if($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" class="hover:text-primary transition flex items-center gap-2">
                    <i class="fab fa-instagram text-lg"></i> Instagram
                </a>
                @endif
                
                @if($tiktokUrl)
                <a href="{{ $tiktokUrl }}" target="_blank" class="hover:text-primary transition flex items-center gap-2">
                    <i class="fab fa-tiktok text-lg"></i> TikTok
                </a>
                @endif

                @if($facebookUrl)
                <a href="{{ $facebookUrl }}" target="_blank" class="hover:text-primary transition flex items-center gap-2">
                    <i class="fab fa-facebook text-lg"></i> Facebook
                </a>
                @endif

                @if($youtubeUrl)
                <a href="{{ $youtubeUrl }}" target="_blank" class="hover:text-primary transition flex items-center gap-2">
                    <i class="fab fa-youtube text-lg"></i> YouTube
                </a>
                @endif

                @if($twitterUrl)
                <a href="{{ $twitterUrl }}" target="_blank" class="hover:text-primary transition flex items-center gap-2">
                    <i class="fab fa-x-twitter text-lg"></i> X (Twitter)
                </a>
                @endif

                @if($telegramUrl)
                <a href="{{ $telegramUrl }}" target="_blank" class="hover:text-primary transition flex items-center gap-2">
                    <i class="fab fa-telegram text-lg"></i> Telegram
                </a>
                @endif

                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $whatsappNumber ?? '') }}?text=%C2%A1Hola%20{{ $appName }}!%20Quiero%20hacerles%20una%20consulta."
                    target="_blank" class="hover:text-primary transition flex items-center gap-2">
                    <i class="fab fa-whatsapp text-lg"></i> {{ $whatsappNumber ?? '' }}
                </a>
            </div>
 
            <div class="flex justify-center px-4 mb-6 text-sm text-gray-300 font-light text-center">
                <a id="footer-address-link" href="{{ $mapsLink }}" target="_blank"
                    class="hover:text-primary transition max-w-lg">
                    <span id="footer-address-text">{{ $address }}</span>
                </a>
            </div>
 
            <div class="border-t border-gray-700 pt-6 flex flex-col items-center justify-center">
                <div class="flex flex-wrap justify-center gap-4 mb-4">
                    <button id="btn-test-notification" class="text-[10px] text-gray-500 hover:text-primary transition underline decoration-1">
                        <i class="fas fa-bell mr-1"></i> Probar Notificación
                    </button>
                    <a href="/admin/login" class="text-[10px] text-gray-500 hover:text-primary transition underline decoration-1 border-l border-gray-700 pl-4">
                        <i class="fas fa-user-shield mr-1"></i> Panel Admin
                    </a>
                </div>
                <div class="text-xs text-gray-500 text-center">
                    &copy; 2026 {{ $appName }}. Todos los derechos reservados.
                </div>
                <div class="text-xs text-gray-400 mt-2 flex items-center justify-center gap-1">
                    <span>Desarrollado con</span>
                    <i class="fas fa-heart text-red-500 animate-pulse"></i>
                    <span>por</span>
                    <a href="https://github.com/wydex28" target="_blank"
                        class="text-primary hover:text-green-400 font-bold transition flex items-center gap-1 hover:-translate-y-0.5 hover:scale-105"
                        title="Creador: wydex28">
                        <i class="fab fa-github text-sm"></i> wydex28
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Confetti Local -->
    <script src="/js/confetti.browser.min.js"></script>
    <!-- Leaflet JS Local -->
    <script src="/js/leaflet.js"></script>
    <!-- jQuery Local -->
    <script src="/js/jquery.min.js"></script>
    <script>
        // Audio Helper for "Pop" sound
        var audioCtx;
        function playPopSound() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            var oscillator = audioCtx.createOscillator();
            var gainNode = audioCtx.createGain();

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(600, audioCtx.currentTime);
            oscillator.frequency.exponentialRampToValueAtTime(900, audioCtx.currentTime + 0.04);

            gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.08, audioCtx.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.08);

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.start(audioCtx.currentTime);
            oscillator.stop(audioCtx.currentTime + 0.08);
        }

        // Audio Helper for "Delete" sound
        function playDeleteSound() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            var oscillator = audioCtx.createOscillator();
            var gainNode = audioCtx.createGain();

            oscillator.type = 'triangle';
            oscillator.frequency.setValueAtTime(200, audioCtx.currentTime);
            oscillator.frequency.exponentialRampToValueAtTime(80, audioCtx.currentTime + 0.08);

            gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.05, audioCtx.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.1);

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.start(audioCtx.currentTime);
            oscillator.stop(audioCtx.currentTime + 0.1);
        }

        $(document).ready(function () {
            // Logica para mostrar splash SOLO en modo APP instalada
            var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            
            function hideSplash() {
                setTimeout(function() {
                    $('#pwa-splash').addClass('opacity-0 pointer-events-none');
                    setTimeout(function() { $('#pwa-splash').addClass('hidden'); }, 600);
                }, 1500);
            }

            if (!isStandalone) {
                // Si es navegador normal, ocultar de inmediato sin animación
                $('#pwa-splash').addClass('hidden');
            } else {
                // Si es App, esperar a que cargue todo para quitarlo
                if (document.readyState === 'complete') {
                    hideSplash();
                } else {
                    $(window).on('load', hideSplash);
                }
            }

            // Delivery Global State
            var orderConfig = { type: 'pickup', distance: 0, deliveryCost: 0, lat: null, lng: null, confirmed: false, clientName: '', clientPhone: '' };
            // Sucursales Logic (Dynamic from Database)
            var APP_BRANCHES = @json($branches);
            var SELECTED_BRANCH = JSON.parse(localStorage.getItem('selected_branch')) || null;

            // Global Brand Config for Fallback
            var GLOBAL_CONFIG = {
                appName: "{{ $appName }}",
                address: "{{ $address }}",
                mapsLink: "{{ $mapsLink }}",
                logo: "{{ $logo }}",
                lat: 10.2586, 
                lng: -67.5856
            };

            var STORE_LAT = SELECTED_BRANCH ? parseFloat(SELECTED_BRANCH.lat) : GLOBAL_CONFIG.lat;
            var STORE_LNG = SELECTED_BRANCH ? parseFloat(SELECTED_BRANCH.lng) : GLOBAL_CONFIG.lng;
            var DELIVERY_RATE_PER_KM = 0.43;
            var deliveryMap = null;
            var deliveryMarker = null;

            // Funciones de Distancia Haversine
            function deg2rad(deg) { return deg * (Math.PI / 180); }
            function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
                var R = 6371;
                var dLat = deg2rad(lat2 - lat1);
                var dLon = deg2rad(lon2 - lon1);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
            }

            var osrmTimeout = null;
            function updateDeliveryCost(lat, lng) {
                // Actualización inmediata estimada (Haversine * 1.35) para respuesta rápida en UI
                var straightDist = getDistanceFromLatLonInKm(STORE_LAT, STORE_LNG, lat, lng);
                var estDist = straightDist * 1.35;
                renderDistAndCost(estDist, lat, lng);

                // Consulta de ruta real por calles (OSRM) + Geocodificación Inversa con debounce
                clearTimeout(osrmTimeout);
                osrmTimeout = setTimeout(function() {
                    // 1. Ruta Driving (OSRM)
                    var osrmUrl = 'https://router.project-osrm.org/route/v1/driving/' + STORE_LNG + ',' + STORE_LAT + ';' + lng + ',' + lat + '?overview=false';
                    fetch(osrmUrl)
                        .then(function(res) { return res.json(); })
                        .then(function(data) {
                            if (data && data.routes && data.routes.length > 0) {
                                var realDist = data.routes[0].distance / 1000;
                                renderDistAndCost(realDist, lat, lng);
                            }
                        })
                        .catch(function(err) { console.log("Routing Error:", err); });

                    // 2. Dirección Texto (Reverse Geocoding)
                    fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng + '&zoom=18&addressdetails=1')
                        .then(function(res) { return res.json(); })
                        .then(function(data) {
                            if (data && data.display_name) {
                                $('#delivery-address-manual').val(data.display_name);
                            }
                        })
                        .catch(function() { 
                            $('#delivery-address-manual').attr('placeholder', 'Escribe tu dirección aquí...');
                        });
                }, 600);
            }

            function renderDistAndCost(dist, lat, lng) {
                var cost = dist * DELIVERY_RATE_PER_KM;
                orderConfig.distance = dist;
                orderConfig.deliveryCost = cost;
                orderConfig.lat = lat;
                orderConfig.lng = lng;

                var bsCost = cost * bcvRate;
                $('#delivery-distance').text(dist.toFixed(2));
                $('#delivery-cost').html('Bs. ' + bsCost.toFixed(2) + '<br><span class="text-xs text-gray-500 font-sans tracking-normal opacity-80">Ref: $' + cost.toFixed(2) + '</span>');

                var currentTotalStr = '';
                if (cart.length > 0) {
                    var baseTotal = cart.reduce(function(acc, current) { return acc + (current.price * current.qty); }, 0);
                    var finalTotal = baseTotal + cost;
                    var bsFinalTotal = finalTotal * bcvRate;
                    currentTotalStr = '- Total Orden: Bs. ' + bsFinalTotal.toFixed(2);
                }
                $('#delivery-total-btn').text(currentTotalStr);

                if (cost >= 0.20) {
                    $('#delivery-warning-box').addClass('hidden');
                    var btn = $('#btn-confirm-delivery');
                    if (btn.hasClass('bg-red-500')) {
                        btn.removeClass('bg-red-500').addClass('bg-orange-500').html('Confirmar <span id="delivery-total-btn" class="ml-1 text-orange-100 font-normal"></span> <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>');
                        $('#delivery-total-btn').text(currentTotalStr);
                    }
                }
            }

            function checkBranchSelection() {
                // Si NO hay sedes o hay SOLO UNA, usamos la config global de Identidad de Marca
                if (APP_BRANCHES.length <= 1) {
                    localStorage.removeItem('selected_branch');
                    SELECTED_BRANCH = null;
                    updateBranchUI();
                    return;
                }

                if (!SELECTED_BRANCH || !APP_BRANCHES.find(function(b) { return b.id == SELECTED_BRANCH.id; })) {
                    $('#branch-selector-modal').removeClass('hidden').addClass('flex');
                    setTimeout(function() {
                        $('#branch-selector-modal').find('.scale-95').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                    }, 50);
                } else {
                    updateBranchUI();
                }
            }

            window.selectBranch = function(branchId) {
                if (!branchId) return;
                var branch = APP_BRANCHES.find(function(b) { return b.id == branchId; });
                if (branch) {
                    localStorage.setItem('selected_branch', JSON.stringify(branch));
                    SELECTED_BRANCH = branch;
                    STORE_LAT = parseFloat(branch.lat);
                    STORE_LNG = parseFloat(branch.lng);
                    
                    $('#branch-selector-modal').addClass('opacity-0');
                    setTimeout(function() {
                        $('#branch-selector-modal').addClass('hidden').removeClass('flex opacity-0');
                        updateBranchUI();
                        // Al seleccionar sede, iniciamos el flujo de PWA
                        if (typeof window.initPWAFlow === 'function') {
                            window.initPWAFlow();
                        }
                        if (deliveryMap) {
                            deliveryMap.setView([STORE_LAT, STORE_LNG], 13);
                            if (window.storeMarker) {
                                storeMarker.setLatLng([STORE_LAT, STORE_LNG]);
                                storeMarker.setPopupContent('<b>' + branch.name + '</b>');
                            }
                        }
                    }, 300);
                }
            };

            function updateBranchUI() {
                if (SELECTED_BRANCH) {
                    $('#branch-banner-text').html(SELECTED_BRANCH.name);
                    $('#branch-banner-link').attr('href', 'https://www.google.com/maps?q=' + SELECTED_BRANCH.lat + ',' + SELECTED_BRANCH.lng);
                    
                    $('#footer-address-text').html(SELECTED_BRANCH.address);
                    $('#footer-address-link').attr('href', 'https://www.google.com/maps?q=' + SELECTED_BRANCH.lat + ',' + SELECTED_BRANCH.lng);
                } else {
                    // Fallback to Brand Identity module
                    $('#branch-banner-text').html(GLOBAL_CONFIG.appName);
                    $('#branch-banner-link').attr('href', GLOBAL_CONFIG.mapsLink);

                    $('#footer-address-text').html(GLOBAL_CONFIG.address);
                    $('#footer-address-link').attr('href', GLOBAL_CONFIG.mapsLink);
                }
            }

            window.showBranchSelector = function() {
                $('#branch-selector-modal').removeClass('hidden').addClass('flex');
                setTimeout(() => {
                    $('#branch-selector-modal').find('.scale-95').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                }, 10);
            };

            window.autoSelectNearestBranch = function() {
                if (!navigator.geolocation) {
                    Swal.fire({ title: "No compatible", text: "Tu navegador no soporta geolocalización.", icon: "error" });
                    return;
                }

                // Verificar si estamos en un contexto seguro (HTTPS)
                if (!window.isSecureContext && window.location.hostname !== 'localhost') {
                    Swal.fire({ 
                        title: "Conexión no segura", 
                        text: "Para usar la detección automática, la página debe usar HTTPS. Por favor, selecciona tu sede en la lista inferior.", 
                        icon: "warning" 
                    });
                    return;
                }

                Swal.fire({
                    title: 'Detectando ubicación...',
                    text: 'Por favor, permite el acceso al GPS de tu dispositivo.',
                    allowOutsideClick: false,
                    didOpen: function() { Swal.showLoading(); }
                });

                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;
                    var nearest = null;
                    var minDistance = Infinity;

                    APP_BRANCHES.forEach(function(branch) {
                        var dist = getDistanceFromLatLonInKm(userLat, userLng, branch.lat, branch.lng);
                        if (dist < minDistance) {
                            minDistance = dist;
                            nearest = branch;
                        }
                    });

                    if (nearest) {
                        Swal.fire({
                            title: 'Sede detectada',
                            text: 'Hemos encontrado que la sede de "' + nearest.name + '" es la más cercana a ti.',
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        selectBranch(nearest.id);
                    }
                }, function(error) {
                    var errorMsg = "No pudimos acceder a tu ubicación. Por favor, asegúrate de tener el GPS encendido y haber dado permisos.";
                    if (error.code === 1) errorMsg = "Has denegado el acceso a tu ubicación. Por favor, actívala en la configuración de tu navegador o selecciona manualmente.";
                    
                    Swal.fire({ 
                        title: "Ubicación no disponible", 
                        text: errorMsg, 
                        icon: "info",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#FFBF69"
                    });
                }, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                });
            };
 
            // Si la sede ya está seleccionada de antes, iniciamos PWA tras un pequeño delay
            $(document).ready(function() {
                if (localStorage.getItem('selected_branch')) {
                    setTimeout(() => {
                        if (typeof window.initPWAFlow === 'function') window.initPWAFlow();
                    }, 2000);
                }
            });
 
            checkBranchSelection();
            
            function initLeafletMap() {
                if (deliveryMap) return;
                // Maracay center
                deliveryMap = L.map('delivery-map', { attributionControl: false }).setView([STORE_LAT, STORE_LNG], 13);
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png').addTo(deliveryMap);

                // Icono tienda
                var currentLogo = SELECTED_BRANCH && SELECTED_BRANCH.logo ? SELECTED_BRANCH.logo : GLOBAL_CONFIG.logo;
                var storeIcon = L.divIcon({
                    html: '<div class="w-8 h-8 bg-white border-2 border-primary rounded-full shadow-lg flex items-center justify-center p-1"><img src="' + (currentLogo ? '/storage/' + currentLogo : '/images/brand/logo.png') + '" class="w-full h-full object-cover"></div>',
                    className: 'store-marker-icon',
                    iconSize: [32, 32],
                    iconAnchor: [16, 16]
                });
                var branchNameForMarker = SELECTED_BRANCH ? SELECTED_BRANCH.name : GLOBAL_CONFIG.appName;
                window.storeMarker = L.marker([STORE_LAT, STORE_LNG], { icon: storeIcon }).addTo(deliveryMap).bindPopup('<b>' + branchNameForMarker + '</b>').openPopup();

                // Icono cliente
                var clientIcon = L.divIcon({
                    html: '<div class="text-orange-500 text-3xl drop-shadow-md -mt-8 -ml-3"><i class="fas fa-map-marker-alt"></i></div>',
                    className: 'client-marker-icon'
                });
                deliveryMarker = L.marker([STORE_LAT, STORE_LNG], { icon: clientIcon, draggable: true, zIndexOffset: 1000 }).addTo(deliveryMap);
                updateDeliveryCost(STORE_LAT, STORE_LNG);

                deliveryMarker.on('dragend', function (e) {
                    var coords = e.target.getLatLng();
                    updateDeliveryCost(coords.lat, coords.lng);
                });

                deliveryMap.on('click', function (e) {
                    deliveryMarker.setLatLng(e.latlng);
                    updateDeliveryCost(e.latlng.lat, e.latlng.lng);
                });

                // --- MAP SEARCH & GPS ---
                $('#btn-use-gps').click(function() {
                    var $btn = $(this);
                    var $icon = $btn.find('i');
                    var originalHtml = $btn.html();
                    
                    $btn.addClass('opacity-50 pointer-events-none');
                    $icon.addClass('fa-spin-pulse');

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;
                            
                            if (deliveryMap) {
                                deliveryMap.setView([lat, lng], 16);
                                if (deliveryMarker) {
                                    deliveryMarker.setLatLng([lat, lng]);
                                }
                                updateDeliveryCost(lat, lng);
                            }
                            
                            $btn.removeClass('opacity-50 pointer-events-none').html(originalHtml);
                            Swal.fire({ 
                                title: "¡Ubicación Detectada!", 
                                text: "Hemos ajustado el marcador a tu posición actual.", 
                                icon: "success", 
                                timer: 2000, 
                                showConfirmButton: false 
                            });
                        }, function(error) {
                            $btn.removeClass('opacity-50 pointer-events-none').html(originalHtml);
                            var errorMsg = "No pudimos obtener tu ubicación.";
                            if (error.code === 1) errorMsg = "Has denegado el acceso al GPS. Por favor, actívalo en la configuración de tu navegador.";
                            Swal.fire({ title: "GPS No Disponible", text: errorMsg, icon: "info" });
                        }, { enableHighAccuracy: true, timeout: 8000 });
                    } else {
                        $btn.removeClass('opacity-50 pointer-events-none').html(originalHtml);
                        Swal.fire({ title: "GPS No Soportado", text: "Tu navegador no soporta geolocalización.", icon: "error" });
                    }
                });
            }

            console.log(
                "%c🚀 Proyecto {{ $appName }}\n%cDesarrollado por %cwydex28\n%c🔥 Visita mi GitHub: https://github.com/wydex28",
                "color: #ff5722; font-size: 20px; font-weight: bold; padding-bottom: 5px;",
                "color: #4CAF50; font-size: 14px;",
                "color: #2196F3; font-size: 16px; font-weight: bold;",
                "color: #9e9e9e; font-size: 12px; font-style: italic; margin-top: 5px;"
            );

            checkBranchSelection();

            // Tasa BCV Logic
            var bcvRate = 1.0;
            var isBcvLoaded = false;

            function fetchBcvRate() {
                fetch('https://ve.dolarapi.com/v1/dolares/oficial')
                    .then(function(response) { return response.json(); })
                    .then(function(data) {
                        if (data && data.promedio) {
                            bcvRate = data.promedio;
                            isBcvLoaded = true;
                            $('.rate-val').text('Bs. ' + bcvRate.toFixed(2));
                            if (data.fechaActualizacion) {
                                var dateObj = new Date(data.fechaActualizacion);
                                $('#bcv-date').text('Actualizado: ' + dateObj.toLocaleString('es-VE', { dateStyle: 'short', timeStyle: 'short' }));
                            }
                        } else {
                            throw new Error("Formato inválido");
                        }
                    })
                    .catch(function(error) {
                        bcvRate = 50.00;
                        $('.rate-val').text('Bs. ' + bcvRate.toFixed(2) + ' (Ref)');
                        $('#bcv-date').text('Tasa Referencial Manual');
                    })
                    .finally(function() {
                        // Actualizar precios en pantalla
                        $('.price-display').each(function () {
                            var usdPrice = parseFloat($(this).data('dolar'));
                            var bsPrice = usdPrice * bcvRate;
                            $(this).text('Bs. ' + bsPrice.toFixed(2));
                        });
                        updateCartUI();
                    });
            }

            fetchBcvRate();

            var isStoreOpen = false;
            // Horario Logic
            function updateScheduleBadge() {
                var now = new Date();
                var day = now.getDay(); // 0-6: Sun-Sat
                var hours = now.getHours();

                var isSunday = (day === 0);
                var isOpenTime = (hours >= 6 && hours < 13);
                isStoreOpen = !isSunday && isOpenTime;

                var badge = $('#store-status-badge');
                if (isStoreOpen) {
                    badge.text('Abierto').removeClass('bg-red-500 border-red-400 text-white').addClass('bg-green-100 text-green-800 border-green-300');
                } else {
                    badge.text('Cerrado').removeClass('bg-green-100 text-green-800 border-green-300').addClass('bg-red-500 text-white border-red-400');
                }
            }
            updateScheduleBadge();
            setInterval(updateScheduleBadge, 60000);

            // Navbar Background on Scroll
            $(window).scroll(function () {
                if ($(window).scrollTop() > 50) {
                    $('#navbar').addClass('shadow-md bg-white/95').removeClass('bg-white/90 shadow-sm');
                } else {
                    $('#navbar').removeClass('shadow-md bg-white/95').addClass('bg-white/90 shadow-sm');
                }

                // Reveal animations
                $('.reveal').each(function () {
                    var windowHeight = $(window).height();
                    var elementTop = $(this).offset().top;
                    var elementVisible = 100;
                    if (elementTop < $(window).scrollTop() + windowHeight - elementVisible) {
                        $(this).addClass('active');
                    }
                });
            });

            // Search and Category Filter Logic
            var productSearch = $('#product-search');
            var categoryBtns = $('.category-filter-btn');
            var categorySections = $('.category-section');

            function filterProducts() {
                var query = productSearch.val().trim().toLowerCase();
                var activeCategory = $('.category-filter-btn.active').data('category');

                categorySections.each(function() {
                    var section = $(this);
                    var sectionId = section.attr('id');
                    
                    // Primero ocultamos si la categoría no coincide con la seleccionada
                    if (activeCategory !== 'all' && activeCategory !== sectionId) {
                        section.addClass('hidden');
                        return;
                    }

                    // Dentro de la categoría permitida, filtramos los productos por búsqueda
                    var hasVisibleProductsInSection = false;
                    section.find('.food-card').each(function() {
                        var card = $(this);
                        var title = card.data('title') || "";
                        var matchesQuery = query === "" || title.includes(query);

                        if (matchesQuery) {
                            card.removeClass('hidden').addClass('reveal active');
                            hasVisibleProductsInSection = true;
                        } else {
                            card.addClass('hidden');
                        }
                    });

                    // Mostramos u ocultamos la sección completa según si hay productos visibles
                    if (hasVisibleProductsInSection) {
                        section.removeClass('hidden');
                    } else {
                        section.addClass('hidden');
                    }
                });

                // Mensaje de "No se encontró nada"
                if ($('.category-section:not(.hidden)').length === 0) {
                    if ($('#no-results-msg').length === 0) {
                        $('#menu .max-w-7xl').append(
                            '<div id="no-results-msg" class="text-center py-20 reveal active">' +
                                '<div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-3xl mx-auto mb-6">' +
                                    '<i class="fas fa-search"></i>' +
                                '</div>' +
                                '<h3 class="text-xl font-display text-textMain mb-2">No encontramos resultados</h3>' +
                                '<p class="text-gray-400 text-sm">Prueba buscando otro ingrediente o cambia de categoría.</p>' +
                            '</div>'
                        );
                    }
                } else {
                    $('#no-results-msg').remove();
                }
            }

            productSearch.on('input', filterProducts);

            categoryBtns.on('click', function() {
                categoryBtns.removeClass('active');
                $(this).addClass('active');
                filterProducts();
            });

            // Initial trigger for reveal elements currently in view
            setTimeout(function () {
                $(window).trigger('scroll');
            }, 100);

            // Mobile menu toggle
            $('#mobile-menu-btn').click(function () {
                $('#mobile-menu').removeClass('hidden').toggleClass('opacity-0 opacity-100');
            });
            $('#close-mobile-menu, #mobile-menu a').click(function () {
                $('#mobile-menu').removeClass('opacity-100').addClass('opacity-0');
                setTimeout(function () {
                    $('#mobile-menu').addClass('hidden');
                }, 300);
            });

            // Counter Logic ([-] 0 [+])
            $('.qty-btn').click(function () {
                var isPlus = $(this).hasClass('plus');
                var targetId = $(this).data('target');
                var inputEl = $('#' + targetId);
                var currentVal = parseInt(inputEl.val()) || 1;

                if (isPlus) {
                    inputEl.val(currentVal + 1);
                } else {
                    if (currentVal > 1) {
                        inputEl.val(currentVal - 1);
                    }
                }
            });

            // Visual Cart Logic & Functionality
            var cart = [];

            $('.add-to-cart-btn').click(function () {
                var qtyInputId = $(this).data('qty');
                var qty = parseInt($('#' + qtyInputId).val());
                var name = $(this).data('name');
                var price = parseFloat($(this).data('price'));

                var existingItem = null;
                for (var i = 0; i < cart.length; i++) {
                    if (cart[i].name === name) {
                        existingItem = cart[i];
                        break;
                    }
                }

                if (existingItem) {
                    existingItem.qty += qty;
                } else {
                    cart.push({ name: name, price: price, qty: qty });
                }

                playPopSound();
                if (typeof confetti === 'function') {
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: { y: 0.6 },
                        colors: ['#00A859', '#FFBF69', '#E71D36']
                    });
                }

                updateCartUI();
                
                // Opción visual de feedback en el botón
                var $btn = $(this);
                var originalText = $btn.text();
                $btn.addClass('bg-green-700').text('¡Agregado!');
                setTimeout(function () {
                    $btn.removeClass('bg-green-700').text(originalText);
                    $('#' + qtyInputId).val(1);
                }, 1000);
            });

            // --- CHECKOUT NAVIGATION LOGIC ---
            var currentCheckoutStep = 1;
            var checkoutModal = $('#checkout-modal');
            var stepDots = $('.checkout-step-dot');

            function goToCheckoutStep(step) {
                if (step < 1 || step > 4) return;
                
                // Play subtle transition sound
                playPopSound();

                // Fade out current screen
                $('.checkout-screen:not(.hidden)').fadeOut(200, function() {
                    $(this).addClass('hidden');
                    currentCheckoutStep = step;
                    
                    // Update Stepper UI
                    stepDots.each(function() {
                        var d = $(this);
                        var dotStep = d.data('step');
                        var label = d.next('span');
                        
                        if (dotStep < step) {
                            d.removeClass('bg-gray-200 ring-4 ring-primary/10 shadow-lg').addClass('bg-primary');
                            label.removeClass('text-gray-400').addClass('text-primary');
                        } else if (dotStep === step) {
                            d.removeClass('bg-gray-200 bg-primary').addClass('bg-primary ring-4 ring-primary/10 shadow-lg');
                            label.removeClass('text-gray-400').addClass('text-primary');
                        } else {
                            d.removeClass('bg-primary ring-4 ring-primary/10 shadow-lg').addClass('bg-gray-200');
                            label.removeClass('text-primary').addClass('text-gray-400');
                        }
                    });

                    // Show and fade in new screen
                    var nextScreen = $('#checkout-step-' + step);
                    nextScreen.removeClass('hidden').hide().fadeIn(300);
                    
                    // Dynamic Logic depending on step
                    if (step === 3) {
                        if (orderConfig.type === 'delivery') {
                            $('#view-delivery-input').removeClass('hidden');
                            $('#view-pickup-info').addClass('hidden');
                            initLeafletMap();
                            setTimeout(function() { if(window.deliveryMap) deliveryMap.invalidateSize(); }, 400);
                        } else {
                            $('#view-delivery-input').addClass('hidden');
                            $('#view-pickup-info').removeClass('hidden');
                        }
                    } else if (step === 4) {
                        renderOrderSummary();
                    }
                });
            }

            function openCheckout() {
                if (cart.length === 0) return;

                if (!isStoreOpen) {
                    Swal.fire({
                        title: '¡Sede Cerrada!',
                        text: 'Nuestro horario es: {{ $schedule }}. ¿Deseas continuar en modo prueba?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Probar Pedido',
                        cancelButtonText: 'Entendido'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            isStoreOpen = true;
                            openCheckout();
                        }
                    });
                    return;
                }

                currentCheckoutStep = 1;
                $('.checkout-screen').addClass('hidden');
                $('#checkout-step-1').removeClass('hidden');
                
                // Reset dots
                stepDots.removeClass('bg-primary ring-4 ring-primary/10 shadow-lg').addClass('bg-gray-200');
                stepDots.first().addClass('bg-primary ring-4 ring-primary/10');
                $('.checkout-step-dot + span').removeClass('text-primary').addClass('text-gray-400');
                stepDots.first().next('span').addClass('text-primary');

                checkoutModal.removeClass('hidden').hide().fadeIn(400);
                updateCartUI();
            }

            function closeCheckout() {
                checkoutModal.fadeOut(300, function() {
                    $(this).addClass('hidden');
                });
            }

            // --- CART UI UPDATE ---
            function updateCartUI() {
                var totalItems = 0;
                var totalPrice = 0;
                var html = '';

                if (cart.length === 0) {
                    html = '<div class="text-center text-gray-300 py-10 font-medium">Tu carrito está vacío</div>';
                    $('#clear-cart-btn').addClass('hidden');
                    $('#checkout-step-1 button#btn-next-to-type').prop('disabled', true).addClass('opacity-50');
                } else {
                    $('#clear-cart-btn').removeClass('hidden');
                    $('#checkout-step-1 button#btn-next-to-type').prop('disabled', false).removeClass('opacity-50');
                    
                    cart.forEach(function (item, index) {
                        totalItems += item.qty;
                        totalPrice += (item.price * item.qty);
                        var bsPrice = (item.price * bcvRate).toFixed(2);
                        var bsTotal = (item.price * item.qty * bcvRate).toFixed(2);
                        
                        html += '<div class="cart-item-row group bg-gray-50/50 hover:bg-white border border-gray-100 p-4 rounded-3xl transition-all duration-300">' +
                                '<div class="flex justify-between items-start gap-4">' +
                                    '<div class="flex-grow">' +
                                        '<h5 class="font-bold text-textMain text-sm mb-2">' + item.name + '</h5>' +
                                        '<div class="flex items-center gap-3">' +
                                            '<div class="flex items-center bg-white rounded-xl border border-gray-100 p-1 shadow-sm">' +
                                                '<button class="w-8 h-8 rounded-lg hover:bg-red-50 text-red-500 transition cart-qty-minus" data-index="' + index + '">-</button>' +
                                                '<span class="w-10 text-center font-black text-xs">' + item.qty + '</span>' +
                                                '<button class="w-8 h-8 rounded-lg hover:bg-green-50 text-primary transition cart-qty-plus" data-index="' + index + '">+</button>' +
                                            '</div>' +
                                            '<span class="text-[10px] text-gray-400 font-bold">Bs. ' + bsPrice + ' c/u</span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="text-right">' +
                                        '<p class="font-display text-lg text-primary leading-none">Bs. ' + bsTotal + '</p>' +
                                        '<button class="text-[9px] text-red-400 font-black uppercase tracking-widest mt-2 hover:text-red-600 delete-item transition" data-index="' + index + '">Eliminar</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                    });
                }

                $('#cart-items').html(html);

                var bsTotal = (totalPrice * bcvRate).toFixed(2);
                $('#cart-total').text('Bs. ' + bsTotal);
                $('#cart-total-usd').text('Ref: $' + totalPrice.toFixed(2));

                $('#cart-badge').text(totalItems);
                if (totalItems > 0) {
                    $('#cart-badge').removeClass('scale-0').addClass('scale-100');
                } else {
                    $('#cart-badge').removeClass('scale-100').addClass('scale-0');
                    closeCheckout();
                }
            }

            function renderOrderSummary() {
                var subtotalUSD = cart.reduce(function(acc, item) { return acc + (item.price * item.qty); }, 0);
                var deliveryUSD = (orderConfig.type === 'delivery') ? orderConfig.deliveryCost : 0;
                var totalUSD = subtotalUSD + deliveryUSD;

                // Render Items for Summary
                var itemsHtml = '';
                for (var i = 0; i < cart.length; i++) {
                    var item = cart[i];
                    var itemTotalBs = (item.price * item.qty * bcvRate).toFixed(2);
                    itemsHtml += '<div class="flex justify-between items-center text-sm">' +
                                    '<span class="text-gray-400 font-bold">' + item.qty + 'x <span class="text-textMain">' + item.name + '</span></span>' +
                                    '<span class="font-black text-primary">Bs. ' + itemTotalBs + '</span>' +
                                 '</div>';
                }
                $('#summary-items').html(itemsHtml);

                $('#summary-type').text(orderConfig.type === 'pickup' ? 'Retiro en Local' : 'Envío a Domicilio');
                
                if (orderConfig.type === 'delivery') {
                    $('#summary-delivery-row').removeClass('hidden');
                    $('#summary-delivery-cost').text('Bs. ' + (deliveryUSD * bcvRate).toFixed(2) + ' ($' + deliveryUSD.toFixed(2) + ')');
                } else {
                    $('#summary-delivery-row').addClass('hidden');
                }

                $('#summary-total-bs').text('Bs. ' + (totalUSD * bcvRate).toFixed(2));
                $('#summary-total-usd').text('Ref: $' + totalUSD.toFixed(2));
            }

            // EVENT BINDINGS
            $('#cart-toggle-btn').click(openCheckout);
            $('#btn-checkout-close').click(closeCheckout);
            $('#btn-checkout-back, .btn-step-back').click(function() {
                if (currentCheckoutStep > 1) goToCheckoutStep(currentCheckoutStep - 1);
                else closeCheckout();
            });

            $('#btn-next-to-type').click(function() { goToCheckoutStep(2); });
            
            $('#btn-select-pickup').click(function() {
                orderConfig.type = 'pickup';
                orderConfig.deliveryCost = 0;
                orderConfig.distance = 0;
                goToCheckoutStep(3);
            });

            $('#btn-select-delivery').click(function() {
                orderConfig.type = 'delivery';
                goToCheckoutStep(3);
            });

            $('#btn-confirm-pickup').click(function() { goToCheckoutStep(4); });

            $('#btn-confirm-delivery').click(function() {
                var cName = $('#delivery-name').val().trim();
                var cPhone = $('#delivery-phone').val().trim();

                if (!cName || !cPhone) {
                    Swal.fire({ title: "Datos Incompletos", text: "Por favor, ingresa tu nombre y celular para coordinar el envío.", icon: "info" });
                    return;
                }

                if (orderConfig.deliveryCost < 0.20) {
                     // Warning already handled? Or just alert
                }

                orderConfig.clientName = cName;
                orderConfig.clientPhone = cPhone;
                goToCheckoutStep(4);
            });

            $(document).on('click', '.cart-qty-plus', function () {
                var index = $(this).data('index');
                cart[index].qty++;
                playPopSound();
                updateCartUI();
            });

            $(document).on('click', '.cart-qty-minus', function () {
                var index = $(this).data('index');
                if (cart[index].qty > 1) {
                    cart[index].qty--;
                    playPopSound();
                    updateCartUI();
                }
            });

            $(document).on('click', '.delete-item', function (e) {
                var index = $(this).data('index');
                playDeleteSound();
                cart.splice(index, 1);
                updateCartUI();
            });

            $('#clear-cart-btn').click(function () {
                playDeleteSound();
                cart = [];
                updateCartUI();
            });

            $('#btn-confirm-whatsapp').click(function () {
                // Close the full checkout modal
                closeCheckout();

                // Generar Mensaje de Orden directo (Estandar UTF-8 para WhatsApp)
                var branchName = SELECTED_BRANCH ? SELECTED_BRANCH.name : "{{ $appName }}";
                var orderMsg = "👋 ¡Hola, *" + branchName + "*!\n\n";
                orderMsg += "📝 *¡NUEVO PEDIDO DESDE LA WEB!*:\n";

                if (orderConfig.type === 'delivery') {
                    orderMsg += "🚀 *TIPO DE ORDEN:* ENVÍO (DELIVERY)\n";
                    orderMsg += "👤 *Cliente:* " + orderConfig.clientName + "\n";
                    orderMsg += "📞 *Celular:* " + orderConfig.clientPhone + "\n";
                    orderMsg += "📍 *Ubicación:* https://www.google.com/maps?q=" + orderConfig.lat + "," + orderConfig.lng + "\n";
                    orderMsg += "🛵 *Distancia calculada:* " + orderConfig.distance.toFixed(1) + " km\n";
                } else {
                    orderMsg += "🏬 *TIPO DE ORDEN:* RETIRO EN LOCAL (PICKUP)\n";
                }

                orderMsg += "---------------------------------------\n";
                var totalPriceUSD = 0;
                cart.forEach(function (item) {
                    var bsRowTotal = (item.price * item.qty * bcvRate).toFixed(2);
                    orderMsg += "▸ " + item.qty + "x " + item.name + "\n      💵 Bs. " + bsRowTotal + "  |  $" + (item.price * item.qty).toFixed(2) + "\n";
                    totalPriceUSD += (item.price * item.qty);
                });

                if (orderConfig.type === 'delivery') {
                    var costBs = (orderConfig.deliveryCost * bcvRate).toFixed(2);
                    totalPriceUSD += orderConfig.deliveryCost;
                    orderMsg += "\n🛵 *Servicio Delivery:* Bs. " + costBs + " ($" + orderConfig.deliveryCost.toFixed(2) + ")\n";
                }

                var bsTotalOrder = (totalPriceUSD * bcvRate).toFixed(2);
                orderMsg += "---------------------------------------\n";
                orderMsg += "💰 *TOTAL A PAGAR: Bs. " + bsTotalOrder + "*\n";
                orderMsg += "💵 *(Ref: $" + totalPriceUSD.toFixed(2) + ")*\n";
                orderMsg += "📊 _Tasa BCV del día: Bs. " + bcvRate.toFixed(2) + "_\n\n";
                orderMsg += "✅ Envíame la disponibilidad para poder realizar el pago. ¡Quedo atento(a)!";

                var waNumber = SELECTED_BRANCH ? SELECTED_BRANCH.whatsapp : "{{ $whatsappNumber }}";
                waNumber = waNumber.replace(/\+/g, '').trim(); 
                var waLink = "https://wa.me/" + waNumber + "?text=" + encodeURIComponent(orderMsg);

                // Store formatted data for copy button
                var copyText = 'Pago Móvil {{ $appName }}\nBanco: Venezuela (0102)\nTel: 04161071344\nCI: V-12993940\nMonto: Bs. ' + bsTotalOrder;
                $('#btn-copy-data').attr('data-copy', copyText);
                $('#btn-copy-monto').attr('data-copy', bsTotalOrder);

                // Copiar los datos del pago móvil directamente al portapapeles del cliente
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(copyText).catch(function (err) { });
                }

                // Abrir en WhatsApp
                window.open(waLink, '_blank');

                // Inject values into Payment Section
                $('#pago-total-bs').text('Bs. ' + bsTotalOrder);

                // Mostrar pagos
                $('#pagos').removeClass('hidden');

                // Scroll a pagos
                $('html, body').animate({
                    scrollTop: $("#pagos").offset().top - 80
                }, 800, 'swing');

                // Expiración de sesión y Cronómetro (20 minutos)
                var timeLeft = 20 * 60; // 1200 seconds
                $('#payment-timer').text("20:00");

                if (window.paymentInterval) clearInterval(window.paymentInterval);

                window.paymentInterval = setInterval(function () {
                    timeLeft--;
                    var m = Math.floor(timeLeft / 60);
                    var s = timeLeft % 60;
                    $('#payment-timer').text((m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s);

                    if (timeLeft <= 0) {
                        clearInterval(window.paymentInterval);
                        Swal.fire({ title: "{{ $appName }}", text: "⏱️ Tu sesión de pago ha expirado. La página se recargará por seguridad para evitar errores con los precios y montos a transferir.", icon: "info" });
                        window.location.reload();
                    }
                }, 1000);
            });

            // Logica para copiar datos de pago
            $('#btn-copy-data, #btn-copy-all-final').click(function () {
                var textToCopy = $('#btn-copy-data').attr('data-copy');
                var $btn = $(this);
                var isFinal = $btn.attr('id') === 'btn-copy-all-final';

                navigator.clipboard.writeText(textToCopy).then(function () {
                    if (isFinal) {
                        var originalHtml = $btn.html();
                        $btn.html('<i class="fas fa-check text-green-500"></i> ¡Todo copiado!');
                        $btn.addClass('bg-green-50 border-green-200');
                        setTimeout(() => {
                            $btn.html(originalHtml);
                            $btn.removeClass('bg-green-50 border-green-200');
                        }, 2500);
                    } else {
                        var $textSpan = $('#text-copy-data');
                        var $icon = $btn.find('i');
                        // Success visual feedback
                        $btn.removeClass('bg-white text-red-600 hover:bg-red-600 hover:text-white border-red-200');
                        $btn.addClass('bg-green-500 text-white border-green-500');
                        $icon.removeClass('fa-copy').addClass('fa-check-circle');
                        $textSpan.text('¡Datos copiados!');

                        setTimeout(function () {
                            // Revert visual change after 2.5s
                            $btn.removeClass('bg-green-500 text-white border-green-500');
                            $btn.addClass('bg-white text-red-600 hover:bg-red-600 hover:text-white border-red-200');
                            $icon.removeClass('fa-check-circle').addClass('fa-copy');
                            $textSpan.text('Copiar datos del pago');
                        }, 2500);
                    }
                }).catch(function (err) {
                    Swal.fire({ title: "Â¡Ups!", text: "No se pudo copiar el texto. IntÃ©ntalo manualmente.", icon: "error" });
                });
            });

            // Logica para los botones pequeños individuales
            $('.copy-btn-single').click(function () {
                var textToCopy = $(this).attr('data-copy');
                var $icon = $(this).find('i');
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(textToCopy).then(function () {
                        $icon.removeClass('far fa-copy').addClass('fas fa-check text-green-500 scale-125');
                        setTimeout(function () {
                            $icon.removeClass('fas fa-check text-green-500 scale-125').addClass('far fa-copy');
                        }, 1300);
                    }).catch(function (err) { });
                }
            });

            $('#btn-completar-pedido').click(function () {
                var waNumber = SELECTED_BRANCH ? SELECTED_BRANCH.whatsapp : "{{ $whatsappNumber }}";
                waNumber = waNumber.replace(/\+/g, '').trim();
                var branchName = SELECTED_BRANCH ? SELECTED_BRANCH.name : "{{ $appName }}";
                var compMsg = `¡Listo! Ya realicé el pago de mi pedido para la sede *${branchName}*. Te mando la imagen del comprobante por acá 📸.`;
                var waLink = `https://wa.me/${waNumber}?text=${encodeURIComponent(compMsg)}`;
                window.open(waLink, '_blank');
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function (e) {
                e.preventDefault();
                var target = this.hash;
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 80
                }, 600, 'swing');
            });

            // Logica para probar notificación local
            $('#btn-test-notification').click(function () {
                if (!("Notification" in window)) {
                    Swal.fire({ title: "No compatible", text: "Este navegador no soporta notificaciones de escritorio.", icon: "warning", confirmButtonColor: "#FFBF69" });
                    return;
                }

                if (Notification.permission === "granted") {
                    sendTestNotification();
                } else if (Notification.permission !== "denied") {
                    Notification.requestPermission().then(function(permission) {
                        if (permission === "granted") sendTestNotification();
                    });
                } else {
                    Swal.fire({ title: "{{ $appName }}", text: "Permiso de notificación denegado. Actívalo en la configuración de la página.", icon: "info" });
                }
            });

            function sendTestNotification() {
                var title = "¡Es hora de {{ $appName }}! 🥟";
                var options = {
                    body: "{{ $notificationMsg }}",
                    icon: "{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}",
                    image: "{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}",
                    badge: "{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}",
                    vibrate: [200, 100, 200],
                    tag: 'test-notification',
                    renotify: true
                };

                if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
                    navigator.serviceWorker.ready.then(function(registration) {
                        registration.showNotification(title, options);
                    });
                } else {
                    // Fallback for desktop or non-SW env
                    try {
                        var n = new Notification(title, options);
                        n.onclick = function() { window.focus(); n.close(); };
                    } catch (e) {
                        console.error("Error enviando notificación:", e);
                    }
                }
            }

            window.showGoogleLoginAlert = function() {
                Swal.fire({
                    title: '¡Hola! 👋',
                    text: 'Inicia sesión con Google para llevar el historial de tus pedidos y pedir tus empanadas favoritas más rápido.',
                    imageUrl: 'https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg',
                    imageWidth: 60,
                    imageHeight: 60,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fab fa-google mr-2"></i> Usar mi cuenta de Google',
                    cancelButtonText: 'Luego',
                    confirmButtonColor: '#00A859',
                    cancelButtonColor: '#f3f4f6',
                    customClass: {
                        confirmButton: 'text-white font-bold rounded-2xl px-6 py-3',
                        cancelButton: 'text-gray-400 font-bold rounded-2xl px-6 py-3'
                    },
                    buttonsStyling: true,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('auth.google') }}";
                    }
                });
            };
        });

        // Add slow bounce to utility
        tailwind.config.theme.extend.animation = {
            'bounce-slow': 'bounce 3s infinite',
        }
    </script>
    <!-- Service Worker Registration & PWA Install -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(err => { });
            });
        }

        var deferredPrompt;
        var installModal = document.getElementById('install-pwa-modal');
        var installNowBtn = document.getElementById('btn-pwa-install-now');
        var closeModalBtn = document.getElementById('btn-pwa-close-modal');
        var androidView = document.getElementById('android-install-view');
        var iosView = document.getElementById('ios-install-view');

        // Detectar si ya está instalada
        var isAppInstalled = function() {
            return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        }

        var isIOS = function() {
            return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        };

        var showInstallModal = function() {
            if (isAppInstalled()) return;
            if (sessionStorage.getItem('pwa-modal-dismissed')) return;

            // Prioritize iOS Guide if on iOS, else Auto-Prompt
            if (isIOS()) {
                androidView.classList.add('hidden');
                iosView.classList.remove('hidden');
            } else if (deferredPrompt) {
                androidView.classList.remove('hidden');
                iosView.classList.add('hidden');
            } else {
                return;
            }

            installModal.classList.remove('hidden');
            installModal.classList.add('flex');
            setTimeout(function() {
                installModal.classList.remove('opacity-0');
                if (installModal.querySelector('.transition-transform')) {
                    installModal.querySelector('.transition-transform').classList.remove('scale-95');
                    installModal.querySelector('.transition-transform').classList.add('scale-100');
                }
            }, 10);
        };

        var hideInstallModal = function() {
            installModal.classList.add('opacity-0');
            installModal.querySelector('.scale-100').classList.remove('scale-100');
            installModal.querySelector('.transition-transform').classList.add('scale-95');
            setTimeout(function() {
                installModal.classList.add('hidden');
                installModal.classList.remove('flex');
            }, 300);
        };

        window.initPWAFlow = function() {
            console.log('PWA: Iniciando flujo de invitación...');
            if (deferredPrompt) {
                setTimeout(showInstallModal, 500);
            } else if (isIOS() && !isAppInstalled()) {
                setTimeout(showInstallModal, 500);
            }
        };

        window.addEventListener('beforeinstallprompt', function(e) {
            console.log('PWA: beforeinstallprompt fired');
            e.preventDefault();
            deferredPrompt = e;
            if (localStorage.getItem('selected_branch')) {
                setTimeout(showInstallModal, 3000);
            }
        });

        if (isIOS() && !isAppInstalled() && localStorage.getItem('selected_branch')) {
            console.log('PWA: iOS detected and branch selected');
            setTimeout(showInstallModal, 3000);
        }

        installNowBtn.addEventListener('click', function() {
            if (!deferredPrompt) {
                console.warn('PWA: No deferredPrompt available for native install.');
                return;
            }

            // Show the native install prompt
            deferredPrompt.prompt();

            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then(function(choiceResult) {
                console.log('PWA: User response to install prompt: ' + choiceResult.outcome);
                if (choiceResult.outcome === 'accepted') {
                    hideInstallModal();
                }
                deferredPrompt = null;
            });
        });

        closeModalBtn.addEventListener('click', function() {
            console.log('PWA: User dismissed the install modal');
            sessionStorage.setItem('pwa-modal-dismissed', 'true');
            hideInstallModal();
        });

        window.addEventListener('appinstalled', function() {
            hideInstallModal();
            deferredPrompt = null;
        });
    </script>
</body>

</html>