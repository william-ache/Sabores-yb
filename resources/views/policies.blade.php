<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    @php 
        $primaryColor = \App\Models\Setting::get('primary_color', '#00A859');
        $appName = \App\Models\Setting::get('app_name', 'Sabores Y&B');
        $logo = \App\Models\Setting::get('logo');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Políticas de Uso y Privacidad - {{ $appName }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Lilita+One&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="/js/tailwindcss.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $primaryColor }}',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        display: ['Lilita One', 'cursive'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-8">
            <a href="/" class="inline-block hover:opacity-80 transition hover:scale-105 duration-300">
                <img src="{{ $logo ? asset('storage/' . $logo) : '/images/brand/logo.png' }}" alt="{{ $appName }}" class="h-24 md:h-32 mx-auto mb-4 drop-shadow-md">
            </a>
            <h1 class="text-4xl md:text-5xl font-display text-primary mb-2">Políticas de Uso y Privacidad</h1>
            <p class="text-gray-500 font-medium">Última actualización: {{ date('d/m/Y') }}</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8 md:p-12 space-y-10">
            <section>
                <div class="flex items-center gap-3 mb-4 border-b pb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex justify-center items-center">
                        <i class="fas fa-file-contract text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">1. Términos de Uso</h2>
                </div>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Al utilizar los servicios de <strong>{{ $appName }}</strong>, usted acepta cumplir con nuestros términos y condiciones. Nuestros servicios están destinados al pedido y consumo de los productos publicados en nuestra plataforma. 
                    El mal uso del sistema o el envío reiterado de pedidos falsos podrá resultar en la suspensión de acceso a nuestros servicios. Las imágenes son de referencia.
                </p>
            </section>

            <section>
                <div class="flex items-center gap-3 mb-4 border-b pb-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex justify-center items-center">
                        <i class="fas fa-user-shield text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">2. Política de Privacidad y Manejo de Datos</h2>
                </div>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Protegemos la información personal proporcionada al momento de realizar un pedido (como nombre, número de teléfono y dirección).
                    Estos datos son utilizados exclusivamente para la gestión y entrega de su compra, así como para informar el estado de sus pedidos.
                    <strong>{{ $appName }}</strong> no compartirá, venderá ni distribuirá su información personal a terceros bajo ninguna circunstancia sin su consentimiento explícito.
                </p>
            </section>

            <section>
                <div class="flex items-center gap-3 mb-4 border-b pb-3">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex justify-center items-center">
                        <i class="fas fa-money-bill-wave text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">3. Política de Pagos y Reembolsos</h2>
                </div>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Los pagos deben realizarse según los métodos habilitados en el sistema y reportados adecuadamente en el tiempo estipulado tras la generación del pedido.
                    No procesamos reembolsos una vez que el pedido se encuentra en preparación, dada la naturaleza perecedera de nuestros productos. Si existe un fallo en el pedido entregado que sea responsabilidad de <strong>{{ $appName }}</strong>, contáctenos inmediatamente a través de nuestros canales de atención al cliente para ofrecer una solución adecuada.
                </p>
            </section>
        </div>

        <div class="text-center mt-12 mb-8">
            <a href="/" class="inline-flex items-center gap-2 bg-primary text-white font-bold py-4 px-10 rounded-full hover:bg-green-600 transition shadow-lg shadow-primary/30 text-lg group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Volver al Inicio
            </a>
        </div>
    </div>
</body>
</html>
