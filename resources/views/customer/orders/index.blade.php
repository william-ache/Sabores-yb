@extends('customer.layout')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-4xl font-display text-textMain tracking-tight">Mis Órdenes</h2>
            <p class="text-gray-500 font-medium mt-1">Historial de tus antojos en Sabores Y&B.</p>
        </div>
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-2 bg-white border border-gray-100 text-gray-400 hover:text-textMain px-5 py-2.5 rounded-xl transition-all font-black uppercase text-[10px] tracking-widest shadow-sm">
            <i class="fas fa-arrow-left"></i> Volver al Inicio
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">ID</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Fecha</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Total</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-textMain">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-primary">Bs. {{ number_format($order->total, 2) }}</span>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tight">Ref: ${{ number_format($order->total / 36, 2) }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusClasses = [
                                    'Pendiente' => 'bg-orange-50 text-orange-600 border-orange-100',
                                    'Procesando' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'Completada' => 'bg-green-50 text-green-600 border-green-100',
                                    'Cancelada' => 'bg-red-50 text-red-600 border-red-100',
                                ];
                                $class = $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $class }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button onclick='showOrderDetails(@json($order))' 
                                    class="h-10 w-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all ml-auto group-hover:scale-110">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-3xl mb-4">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <h4 class="text-lg font-display text-textMain">No tienes órdenes aún</h4>
                                <p class="text-gray-400 text-xs font-medium mt-1">¡Tus próximas empanadas te esperan en la tienda!</p>
                                <a href="/" class="mt-6 bg-primary text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                                    Ir a la Carta
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detalles -->
<div id="orderDetailsModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-textMain/40 backdrop-blur-sm transition-opacity" onclick="closeOrderModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in duration-300 pointer-events-auto">
            <div class="p-8 sm:p-10">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-3xl font-display text-textMain tracking-tight">Detalles de Orden</h3>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1" id="modalOrderId"></p>
                    </div>
                    <button onclick="closeOrderModal()" class="w-12 h-12 bg-gray-50 text-gray-400 hover:text-red-500 rounded-2xl flex items-center justify-center transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Info de Entrega -->
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] border-b border-primary/10 pb-2">Entrega</h4>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center text-orange-500 shrink-0 mt-1">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-tight" id="modalOrderType"></p>
                                <p class="text-xs font-bold text-textMain leading-relaxed mt-0.5" id="modalOrderAddress"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Info de Pago -->
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-secondary uppercase tracking-[0.2em] border-b border-secondary/10 pb-2">Pago</h4>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-secondary/10 rounded-lg flex items-center justify-center text-secondary shrink-0 mt-1">
                                <i class="fas fa-credit-card text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-tight" id="modalOrderPayment"></p>
                                <p class="text-xs font-bold text-textMain leading-relaxed mt-0.5" id="modalOrderReference"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listado de Productos -->
                <div class="space-y-4 mb-8">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-100 pb-2">Productos</h4>
                    <div id="modalOrderItems" class="space-y-3 max-h-48 overflow-y-auto pr-2">
                        <!-- Items inyectados -->
                    </div>
                </div>

                <!-- Totales -->
                <div class="bg-gray-50 rounded-3xl p-6 space-y-3">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-widest">Subtotal</span>
                        <span class="font-black text-textMain" id="modalOrderSubtotal"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-widest">Delivery</span>
                        <span class="font-black text-orange-600" id="modalOrderDeliveryCost"></span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                        <span class="text-lg font-display text-textMain">TOTAL</span>
                        <span class="text-2xl font-display text-primary" id="modalOrderTotal"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showOrderDetails(order) {
        console.log("Mostrando orden:", order);
        document.getElementById('modalOrderId').innerText = '#' + String(order.id).padStart(5, '0');
        document.getElementById('modalOrderType').innerText = order.type || 'N/A';
        document.getElementById('modalOrderAddress').innerText = order.delivery_address || 'Retiro en Local (' + (order.branch ? order.branch.name : 'Sede Principal') + ')';
        document.getElementById('modalOrderPayment').innerText = order.payment_method || 'Por definir';
        document.getElementById('modalOrderReference').innerText = order.payment_reference ? 'REF: ' + order.payment_reference : 'Pendiente de comprobante';
        
        // Items
        const itemsContainer = document.getElementById('modalOrderItems');
        itemsContainer.innerHTML = '';
        
        if (order.items && order.items.length > 0) {
            order.items.forEach(item => {
                itemsContainer.innerHTML += `
                    <div class="flex items-center justify-between bg-white p-3 rounded-2xl border border-gray-50 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 bg-gray-50 rounded-lg flex items-center justify-center text-[10px] font-black text-gray-400 border border-gray-100">${item.quantity}x</span>
                            <span class="text-xs font-bold text-textMain">${item.product ? item.product.name : 'Producto'}</span>
                        </div>
                        <span class="text-xs font-black text-primary">Bs. ${Number(item.price * item.quantity).toFixed(2)}</span>
                    </div>
                `;
            });
        } else {
            itemsContainer.innerHTML = '<p class="text-center text-gray-400 text-xs py-4">No se encontraron productos.</p>';
        }

        document.getElementById('modalOrderSubtotal').innerText = 'Bs. ' + Number(order.subtotal || 0).toFixed(2);
        document.getElementById('modalOrderDeliveryCost').innerText = 'Bs. ' + Number(order.delivery_cost || 0).toFixed(2);
        document.getElementById('modalOrderTotal').innerText = 'Bs. ' + Number(order.total || 0).toFixed(2);

        document.getElementById('orderDetailsModal').classList.remove('hidden');
    }

    function closeOrderModal() {
        document.getElementById('orderDetailsModal').classList.add('hidden');
    }
</script>
@endsection
