@extends('customer.layout')

@section('content')
@php $systemPrimary = \App\Models\Setting::get('primary_color', '#00A859'); @endphp
<div class="max-w-3xl mx-auto px-4 sm:px-0 py-10">
    <!-- Header -->
    <div class="mb-10 text-center sm:text-left flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-primary transition-all mb-6">
                <i class="fas fa-home text-xs"></i> Volver a la Tienda
            </a>
            <h2 class="text-4xl sm:text-5xl font-display text-textMain tracking-tight">Configurar Perfil</h2>
            <p class="text-gray-500 font-medium mt-2 italic">Personaliza cómo te contactamos y entregamos tus pedidos.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 bg-primary/10 border border-primary/20 text-primary px-6 py-4 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <i class="fas fa-check-circle"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        
        <!-- Profile Card -->
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-8">
            <!-- Banner/Avatar Background -->
            <div class="h-32 bg-gradient-to-r from-primary to-green-600 relative">
                <!-- Color Picker -->
                <div class="absolute top-4 right-6">
                </div>

                <div class="absolute -bottom-12 left-1/2 sm:left-12 transform -translate-x-1/2 sm:translate-x-0">
                    <div class="w-24 h-24 rounded-[2rem] bg-white p-1.5 shadow-xl rotate-3 hover:rotate-0 transition-transform duration-500 relative group cursor-pointer" onclick="document.getElementById('avatarInput').click()">
                        <div class="w-full h-full rounded-[1.5rem] overflow-hidden bg-gray-100 flex items-center justify-center relative">
                            @if($user->avatar)
                                <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover" alt="Profile">
                            @else
                                <img id="avatarPreview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=00A859&color=fff&bold=true" class="w-full h-full object-cover" alt="Profile">
                            @endif
                            
                            <!-- Overlay hover -->
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-camera text-white text-xl"></i>
                            </div>
                        </div>
                        <input type="file" id="avatarInput" class="hidden" accept="image/*">
                        <input type="hidden" name="cropped_avatar" id="croppedAvatarInput">
                    </div>
                </div>
            </div>

            <div class="pt-20 pb-12 px-8 sm:px-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Basic Info -->
                    <div class="md:col-span-2">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-6 flex items-center gap-2">
                            <span class="w-8 h-px bg-gray-200"></span> Datos de Cuenta
                        </h4>
                    </div>

                    <div class="group">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Nombre de Usuario</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-textMain font-bold focus:bg-white focus:border-primary/30 outline-none transition-all" required>
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Correo (No editable)</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input type="email" value="{{ $user->email }}" class="w-full bg-gray-100 border-2 border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-gray-400 font-bold outline-none cursor-not-allowed" readonly>
                        </div>
                    </div>

                    <!-- Delivery Info -->
                    <div class="md:col-span-2 pt-4">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-6 flex items-center gap-2">
                            <span class="w-8 h-px bg-gray-200"></span> Datos para Delivery
                        </h4>
                    </div>

                    <div class="group md:col-span-1">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Nombre para Entrega</label>
                        <div class="relative">
                            <i class="fas fa-id-badge absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input type="text" name="delivery_name" value="{{ old('delivery_name', $user->delivery_name) }}" placeholder="Ej. Juan Pérez" class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-textMain font-bold focus:bg-white focus:border-primary/30 outline-none transition-all">
                        </div>
                    </div>

                    <div class="group md:col-span-1">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Cédula de Identidad</label>
                        <div class="relative">
                            <i class="fas fa-address-card absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input type="text" name="id_card" value="{{ old('id_card', $user->id_card) }}" placeholder="V-00.000.000" class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-textMain font-bold focus:bg-white focus:border-primary/30 outline-none transition-all">
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Teléfono Principal</label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input type="tel" name="phone_1" value="{{ old('phone_1', $user->phone_1) }}" placeholder="0412-0000000" class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-textMain font-bold focus:bg-white focus:border-primary/30 outline-none transition-all">
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-primary text-[10px] font-black uppercase tracking-widest mb-3 ml-1 opacity-70">Teléfono Secundario</label>
                        <div class="relative">
                            <i class="fas fa-phone-alt absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input type="tel" name="phone_2" value="{{ old('phone_2', $user->phone_2) }}" placeholder="Opcional" class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-textMain font-bold focus:bg-white focus:border-primary/30 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="md:col-span-2 pt-4">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-6 flex items-center gap-2">
                            <span class="w-8 h-px bg-gray-200"></span> Direcciones de Entrega (Máx. 3)
                        </h4>
                        
                        <div id="addressesContainer" class="space-y-4">
                            @php $addressCount = 0; @endphp
                            @foreach($user->addresses as $i => $address)
                                @php $addressCount++; @endphp
                                <div class="address-block p-6 bg-gray-50/50 border-2 border-gray-100 rounded-3xl group/addr hover:border-primary/20 transition-all relative">
                                    <input type="hidden" name="addresses[{{ $i }}][id]" value="{{ $address->id }}">
                                    <input type="hidden" name="addresses[{{ $i }}][latitude]" value="{{ $address->latitude }}" class="addr-lat">
                                    <input type="hidden" name="addresses[{{ $i }}][longitude]" value="{{ $address->longitude }}" class="addr-lng">
                                    
                                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                                        <div class="sm:w-1/3">
                                            <input type="text" name="addresses[{{ $i }}][label]" value="{{ old("addresses.$i.label", $address->label) }}" placeholder="Ej. Casa, Trabajo..." class="w-full bg-white border border-gray-100 rounded-xl py-3 px-4 text-xs font-bold outline-none focus:border-primary/30">
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <label class="relative inline-flex items-center cursor-pointer scale-75 origin-left">
                                                <input type="checkbox" name="addresses[{{ $i }}][is_primary]" value="1" {{ old("addresses.$i.is_primary", $address->is_primary) ? 'checked' : '' }} class="sr-only peer primary-checkbox" onchange="onlyOnePrimary(this)">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                                <span class="ms-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Primaria</span>
                                            </label>
                                        </div>
                                        <div class="flex items-center gap-2 ml-auto">
                                            <button type="button" onclick="openMapModal(this)" class="bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm" title="Seleccionar en mapa">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </button>
                                            <button type="button" onclick="useGPS(this)" class="bg-green-50 text-green-500 hover:bg-green-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm" title="Usar GPS">
                                                <i class="fas fa-location-crosshairs"></i>
                                            </button>
                                            @if($i > 0)
                                            <button type="button" onclick="this.closest('.address-block').remove(); updateAddButton();" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                    <textarea name="addresses[{{ $i }}][address]" rows="2" placeholder="Describe tu dirección exacta, puntos de referencia, etc." class="addr-text w-full bg-white border border-gray-100 rounded-2xl py-3 px-5 text-xs font-bold outline-none focus:border-primary/30">{{ old("addresses.$i.address", $address->address) }}</textarea>
                                </div>
                            @endforeach

                            @if($addressCount == 0)
                                <div class="address-block p-6 bg-gray-50/50 border-2 border-gray-100 rounded-3xl group/addr hover:border-primary/20 transition-all relative">
                                    <input type="hidden" name="addresses[0][latitude]" class="addr-lat">
                                    <input type="hidden" name="addresses[0][longitude]" class="addr-lng">
                                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                                        <div class="sm:w-1/3">
                                            <input type="text" name="addresses[0][label]" placeholder="Ej. Casa, Trabajo..." class="w-full bg-white border border-gray-100 rounded-xl py-3 px-4 text-xs font-bold outline-none focus:border-primary/30">
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <label class="relative inline-flex items-center cursor-pointer scale-75 origin-left">
                                                <input type="checkbox" name="addresses[0][is_primary]" value="1" checked class="sr-only peer primary-checkbox" onchange="onlyOnePrimary(this)">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                                <span class="ms-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Primaria</span>
                                            </label>
                                        </div>
                                        <div class="flex items-center gap-2 ml-auto">
                                            <button type="button" onclick="openMapModal(this)" class="bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm" title="Seleccionar en mapa">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </button>
                                            <button type="button" onclick="useGPS(this)" class="bg-green-50 text-green-500 hover:bg-green-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm" title="Usar GPS">
                                                <i class="fas fa-location-crosshairs"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea name="addresses[0][address]" rows="2" placeholder="Describe tu dirección exacta, puntos de referencia, etc." class="addr-text w-full bg-white border border-gray-100 rounded-2xl py-3 px-5 text-xs font-bold outline-none focus:border-primary/30"></textarea>
                                </div>
                                @php $addressCount = 1; @endphp
                            @endif
                        </div>

                        <div class="mt-6" id="addButtonContainer">
                            <button type="button" onclick="addAddressBlock()" id="addAddressBtn" class="w-full py-4 border-2 border-dashed border-gray-200 rounded-2xl text-gray-400 font-black uppercase text-[10px] tracking-widest hover:border-primary hover:text-primary transition-all flex items-center justify-center gap-2 group">
                                <i class="fas fa-plus-circle group-hover:scale-110 transition-transform"></i> Añadir otra dirección
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-green-600 text-white font-black py-4 px-12 rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                        <i class="fas fa-save"></i>
                        <span class="uppercase text-xs tracking-widest">Guardar Cambios</span>
                    </button>
                    
                    <a href="{{ route('customer.dashboard') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-textMain transition-all">Cancelar y volver</a>
                </div>
            </div>
        </div>
    </form>

    <!-- Logout Area -->
    <div class="text-center">
        <form action="{{ route('customer.logout') }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="text-[10px] font-black text-red-400 hover:text-red-600 uppercase tracking-widest transition-all flex items-center gap-2 mx-auto">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión Segura
            </button>
        </form>
    </div>
</div>

<!-- Cropper Modal -->
<div id="cropperModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-xl overflow-hidden shadow-2xl animate-in zoom-in duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div>
                <h3 class="text-xl font-display text-primary uppercase">Ajustar Foto</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Elige cómo quieres verte</p>
            </div>
            <button type="button" onclick="closeCropper()" class="h-10 w-10 flex items-center justify-center text-gray-400 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 flex items-center justify-center bg-gray-100/50">
            <img id="cropperImage" class="max-w-full max-h-[50vh]">
        </div>
        <div class="p-6 border-t border-gray-100 flex justify-end gap-4 bg-gray-50/50">
            <button type="button" onclick="closeCropper()" class="px-6 py-3 text-xs font-black text-gray-400 uppercase">Cancelar</button>
            <button type="button" id="cropButton" class="bg-primary text-white font-black py-3 px-8 rounded-xl shadow-lg transition-all">Aplicar</button>
        </div>
    </div>
</div>

<!-- Map Modal -->
<div id="mapModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-2xl overflow-hidden shadow-2xl animate-in zoom-in duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div>
                <h3 class="text-xl font-display text-primary uppercase">Ubicación de Entrega</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Mueve el marcador hasta tu puerta</p>
            </div>
            <button type="button" onclick="closeMapModal()" class="h-10 w-10 flex items-center justify-center text-gray-400 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="h-[400px] w-full" id="map"></div>
        <div class="p-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
            <p id="mapAddress" class="text-[10px] font-bold text-gray-400 max-w-[60%] truncate">Cargando dirección...</p>
            <div class="flex gap-4">
                <button type="button" onclick="closeMapModal()" class="px-6 py-3 text-xs font-black text-gray-400 uppercase">Cancelar</button>
                <button type="button" id="confirmMapBtn" class="bg-primary text-white font-black py-3 px-8 rounded-xl shadow-lg transition-all">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cropper;
    const avatarInput = document.getElementById('avatarInput');
    const cropperModal = document.getElementById('cropperModal');
    const cropperImage = document.getElementById('cropperImage');
    const avatarPreview = document.getElementById('avatarPreview');
    const croppedAvatarInput = document.getElementById('croppedAvatarInput');

    avatarInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(event) {
                cropperImage.src = event.target.result;
                cropperModal.classList.remove('hidden');
                cropperModal.classList.add('flex');
                
                if (cropper) cropper.destroy();
                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 2,
                });
            };
            reader.readAsDataURL(files[0]);
        }
    });

    document.getElementById('cropButton').addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        const base64data = canvas.toDataURL('image/jpeg', 0.8);
        avatarPreview.src = base64data;
        croppedAvatarInput.value = base64data;
        closeCropper();
    });

    function closeCropper() {
        cropperModal.classList.add('hidden');
        cropperModal.classList.remove('flex');
        if (cropper) cropper.destroy();
    }

    // MAP LOGIC
    let map, marker, activeBlock;

    // Sucursales Logic (Dynamic from Database)
    const APP_BRANCHES = @json($branches);
    const SELECTED_BRANCH = JSON.parse(localStorage.getItem('selected_branch')) || (APP_BRANCHES.length > 0 ? APP_BRANCHES[0] : null);

    const DEFAULT_LAT = SELECTED_BRANCH ? parseFloat(SELECTED_BRANCH.lat) : 10.2586; // Maracay
    const DEFAULT_LNG = SELECTED_BRANCH ? parseFloat(SELECTED_BRANCH.lng) : -67.5856;
    
    function initMap(lat = DEFAULT_LAT, lng = DEFAULT_LNG) {
        if (!map) {
            map = L.map('map', { attributionControl: false }).setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            var clientIcon = L.divIcon({
                html: '<div class="text-orange-500 text-3xl drop-shadow-md -mt-8 -ml-3"><i class="fas fa-map-marker-alt"></i></div>',
                className: 'client-marker-icon'
            });
            marker = L.marker([lat, lng], { icon: clientIcon, draggable: true }).addTo(map);

            // Store Marker (Identity)
            const currentLogo = SELECTED_BRANCH && SELECTED_BRANCH.logo ? SELECTED_BRANCH.logo : "{{ $logo }}";
            const storeIcon = L.divIcon({
                html: `<div class="w-8 h-8 bg-white border-2 border-primary rounded-full shadow-lg flex items-center justify-center p-1"><img src="${currentLogo ? '/storage/' + currentLogo : '/images/brand/logo.png'}" class="w-full h-full object-cover"></div>`,
                className: 'store-marker-icon',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });
            const branchName = SELECTED_BRANCH ? SELECTED_BRANCH.name : "{{ $appName }}";
            L.marker([DEFAULT_LAT, DEFAULT_LNG], { icon: storeIcon }).addTo(map).bindPopup(`<b>${branchName}</b>`);
            
            marker.on('dragend', function() {
                updateMapAddress(marker.getLatLng());
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateMapAddress(e.latlng);
            });
        } else {
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
        }
        updateMapAddress(marker.getLatLng());
    }

    async function updateMapAddress(latlng) {
        const p = document.getElementById('mapAddress');
        p.innerText = "Obteniendo dirección...";
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latlng.lat}&lon=${latlng.lng}&format=json`);
            const data = await res.json();
            p.innerText = data.display_name;
        } catch(e) {
            p.innerText = `${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)}`;
        }
    }

    function openMapModal(btn) {
        activeBlock = btn.closest('.address-block');
        const lat = activeBlock.querySelector('.addr-lat').value || DEFAULT_LAT;
        const lng = activeBlock.querySelector('.addr-lng').value || DEFAULT_LNG;
        
        document.getElementById('mapModal').classList.remove('hidden');
        document.getElementById('mapModal').classList.add('flex');
        
        setTimeout(() => {
            initMap(parseFloat(lat), parseFloat(lng));
            map.invalidateSize();
        }, 300);
    }

    function closeMapModal() {
        document.getElementById('mapModal').classList.add('hidden');
        document.getElementById('mapModal').classList.remove('flex');
    }

    document.getElementById('confirmMapBtn').addEventListener('click', function() {
        const latlng = marker.getLatLng();
        const addrText = document.getElementById('mapAddress').innerText;
        
        activeBlock.querySelector('.addr-lat').value = latlng.lat;
        activeBlock.querySelector('.addr-lng').value = latlng.lng;
        activeBlock.querySelector('.addr-text').value = addrText;
        
        closeMapModal();
    });

    function useGPS(btn) {
        const block = btn.closest('.address-block');
        const icon = btn.querySelector('i');
        
        if ("geolocation" in navigator) {
            icon.classList.remove('fa-location-crosshairs');
            icon.classList.add('fa-spinner', 'fa-spin');
            
            navigator.geolocation.getCurrentPosition(async (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                
                block.querySelector('.addr-lat').value = lat;
                block.querySelector('.addr-lng').value = lng;
                
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
                    const data = await res.json();
                    block.querySelector('.addr-text').value = data.display_name;
                } catch(e) {
                    block.querySelector('.addr-text').value = `Ubicación GPS: ${lat}, ${lng}`;
                }
                
                icon.classList.add('fa-location-crosshairs');
                icon.classList.remove('fa-spinner', 'fa-spin');
            }, (err) => {
                alert("Error al obtener GPS: " + err.message);
                icon.classList.add('fa-location-crosshairs');
                icon.classList.remove('fa-spinner', 'fa-spin');
            });
        } else {
            alert("Tu navegador no soporta GPS.");
        }
    }

    // Primary logic
    function onlyOnePrimary(checkbox) {
        if (checkbox.checked) {
            document.querySelectorAll('.primary-checkbox').forEach(cb => {
                if (cb !== checkbox) cb.checked = false;
            });
        }
    }

    // Dynamic Addresses
    function addAddressBlock() {
        const container = document.getElementById('addressesContainer');
        const count = container.querySelectorAll('.address-block').length;
        
        if (count >= 3) return;

        const newBlock = document.createElement('div');
        newBlock.className = 'address-block p-6 bg-gray-50/50 border-2 border-gray-100 rounded-3xl group/addr hover:border-primary/20 transition-all animate-in slide-in-from-top-2 duration-300 relative';
        newBlock.innerHTML = `
            <input type="hidden" name="addresses[${count}][latitude]" class="addr-lat">
            <input type="hidden" name="addresses[${count}][longitude]" class="addr-lng">
            <div class="flex flex-col sm:flex-row gap-4 mb-4">
                <div class="sm:w-1/3">
                    <input type="text" name="addresses[${count}][label]" placeholder="Ej. Casa, Trabajo..." class="w-full bg-white border border-gray-100 rounded-xl py-3 px-4 text-xs font-bold outline-none focus:border-primary/30">
                </div>
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer scale-75 origin-left">
                        <input type="checkbox" name="addresses[${count}][is_primary]" value="1" class="sr-only peer primary-checkbox" onchange="onlyOnePrimary(this)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        <span class="ms-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Primaria</span>
                    </label>
                </div>
                <div class="flex items-center gap-2 ml-auto">
                    <button type="button" onclick="openMapModal(this)" class="bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm" title="Seleccionar en mapa">
                        <i class="fas fa-map-marker-alt"></i>
                    </button>
                    <button type="button" onclick="useGPS(this)" class="bg-green-50 text-green-500 hover:bg-green-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm" title="Usar GPS">
                        <i class="fas fa-location-crosshairs"></i>
                    </button>
                    <button type="button" onclick="this.closest('.address-block').remove(); updateAddButton();" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white h-10 w-10 rounded-xl transition-all flex items-center justify-center shadow-sm">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            <textarea name="addresses[${count}][address]" rows="2" placeholder="Describe tu dirección exacta, puntos de referencia, etc." class="addr-text w-full bg-white border border-gray-100 rounded-2xl py-3 px-5 text-xs font-bold outline-none focus:border-primary/30"></textarea>
        `;
        container.appendChild(newBlock);
        updateAddButton();
    }

    function updateAddButton() {
        const count = document.getElementById('addressesContainer').querySelectorAll('.address-block').length;
        document.getElementById('addAddressBtn').style.display = count >= 3 ? 'none' : 'flex';
    }

    $(document).ready(function() {
        updateAddButton();
    });
</script>
@endsection
