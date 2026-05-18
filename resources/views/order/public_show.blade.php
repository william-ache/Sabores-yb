<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detalle público de tu pedido en Sabores Y&B.">
    <title>Orden #{{ $order->id }} | {{ $appName }}</title>
    
    <!-- Google Fonts & Tailwind & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Lilita+One&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $systemPrimary }}',
                        secondary: '#FFBF69',
                        dark: '#24140a',
                        textMain: '#24140a',
                        accent: '#E71D36',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        display: ['Lilita One', 'cursive'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #fcfbf9;
        }
        .font-display {
            font-family: 'Lilita One', cursive;
        }
    </style>
</head>
<body class="min-h-screen pb-16">
    <div class="max-w-xl mx-auto px-4 sm:px-6 pt-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8 flex flex-col items-center">
            <a href="/">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-20 w-auto drop-shadow-md hover:scale-105 transition-transform">
                @else
                    <img src="/images/brand/logo.png" alt="Logo" class="h-20 w-auto drop-shadow-md hover:scale-105 transition-transform">
                @endif
            </a>
            <h1 class="font-display text-4xl text-primary mt-4 tracking-wide">{{ $appName }}</h1>
            <p class="text-gray-400 text-xs font-black uppercase tracking-widest mt-1">Detalle Público del Pedido</p>
        </div>

        <!-- Order Information Card -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 p-6 sm:p-8 space-y-6 relative overflow-hidden">
            <!-- Order ID & Status Ribbon -->
            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                <div>
                    <h2 class="text-2xl font-display text-dark tracking-tight leading-none">Orden #{{ $order->id }}</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">{{ $order->created_at->format('d/m/Y h:i a') }}</p>
                </div>
                <div>
                    @if($order->status === 'Pendiente')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-orange-100 text-orange-600 uppercase tracking-widest">
                            <i class="fas fa-clock mr-1.5 animate-pulse"></i> {{ $order->status }}
                        </span>
                    @elseif($order->status === 'Procesando')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-blue-100 text-blue-600 uppercase tracking-widest">
                            <i class="fas fa-spinner mr-1.5 fa-spin"></i> {{ $order->status }}
                        </span>
                    @elseif($order->status === 'Completado')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-green-100 text-green-700 uppercase tracking-widest">
                            <i class="fas fa-check-circle mr-1.5"></i> {{ $order->status }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black bg-red-100 text-red-600 uppercase tracking-widest">
                            <i class="fas fa-times-circle mr-1.5"></i> {{ $order->status }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Client / Delivery Details -->
            <div class="space-y-3 bg-gray-50/50 rounded-3xl p-5 border border-gray-50/80">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1"><i class="fas fa-user-circle mr-1 text-primary"></i> Información del Cliente</h3>
                <div class="grid grid-cols-2 gap-4 text-xs font-bold text-dark">
                    <div>
                        <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">Nombre</span>
                        {{ $order->customer_name }}
                    </div>
                    <div>
                        <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">Método</span>
                        @if($order->type === 'delivery')
                            🚀 Envío a Domicilio
                        @else
                            🏬 Retiro en Local
                        @endif
                    </div>
                    @if($order->type === 'delivery')
                        <div class="col-span-2 border-t border-gray-100 pt-2">
                            <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">Dirección</span>
                            <span class="font-semibold text-gray-600 leading-relaxed">{{ $order->delivery_address }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items list -->
            <div class="space-y-4">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest"><i class="fas fa-hamburger mr-1 text-primary"></i> Productos Solicitados</h3>
                <div class="divide-y divide-gray-100 bg-white rounded-3xl border border-gray-100 p-4 shadow-sm">
                    @foreach($order->items as $item)
                        @php $itemTotalBs = number_format($item->price * $item->quantity * \App\Models\Setting::get('last_bcv_rate', 40.00), 2); @endphp
                        <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0">
                            <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border border-gray-55 bg-gray-100">
                                @if($item->product && $item->product->image_path)
                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="/images/brand/logo.png" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-sm font-bold text-dark leading-tight">{{ $item->product->title ?? 'Producto Editado' }}</h4>
                                <p class="text-[10px] text-gray-400 font-black uppercase mt-0.5">{{ $item->quantity }} unidades x ${{ number_format($item->price, 2) }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-black text-primary">Bs. {{ $itemTotalBs }}</p>
                                <p class="text-[9px] text-gray-400 font-bold">Ref: ${{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals block -->
            <div class="bg-primary/5 rounded-3xl p-5 border border-primary/10 flex justify-between items-center shadow-inner">
                <div>
                    <span class="text-[9px] text-primary font-black uppercase tracking-widest block">Total Neto del Pedido</span>
                    @if($order->type === 'delivery')
                        <span class="text-[9px] text-gray-400 font-bold block">(Delivery incluido: ${{ number_format($order->delivery_cost, 2) }})</span>
                    @endif
                </div>
                <div class="text-right">
                    @php $bcvPrice = number_format($order->total * \App\Models\Setting::get('last_bcv_rate', 40.00), 2); @endphp
                    <span class="font-display text-3xl text-primary block leading-none">Bs. {{ $bcvPrice }}</span>
                    <span class="text-xs text-gray-500 font-black uppercase tracking-tight mt-1.5 block">Ref: ${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="space-y-4">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest"><i class="fas fa-receipt mr-1 text-primary"></i> Información del Pago</h3>
                <div class="bg-gray-50/50 rounded-3xl p-5 border border-gray-50 grid grid-cols-2 gap-4 text-xs font-bold text-dark">
                    <div>
                        <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">Método</span>
                        💳 {{ $order->payment_method }}
                    </div>
                    <div>
                        <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest">Referencia</span>
                        {{ $order->payment_reference ?? 'Sin reportar' }}
                    </div>
                    @if($order->payment_receipt)
                        <div class="col-span-2 border-t border-gray-100 pt-3">
                            <span class="block text-[8px] text-gray-400 font-black uppercase tracking-widest mb-2">Comprobante de Pago</span>
                            <div class="relative rounded-2xl overflow-hidden border border-gray-200 bg-white max-h-64 flex justify-center items-center shadow-inner group">
                                <img src="{{ asset('storage/' . $order->payment_receipt) }}" class="w-full h-full object-contain hover:scale-105 transition-transform duration-300 max-h-64">
                                <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="absolute bottom-3 right-3 bg-dark/80 text-white rounded-lg px-3 py-1.5 text-[9px] font-black uppercase tracking-widest hover:bg-primary transition-colors flex items-center gap-1.5 backdrop-blur-sm">
                                    <i class="fas fa-expand"></i> Ampliar Capture
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-10">
            <p class="text-gray-400 text-[10px] font-semibold">Generado por <a href="/" class="text-primary font-bold hover:underline">{{ $appName }}</a> - Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
