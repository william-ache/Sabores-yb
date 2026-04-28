@extends('admin.superadmin.layout')

@section('content')
<div class="mb-4 text-center">
    <a href="{{ route('superadmin.index') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center justify-center gap-2 mb-6">
        <i class="fas fa-arrow-left text-xs"></i> Volver al Menú Maestro
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Generador de Módulos -->
    <div class="lg:col-span-5 space-y-8">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <h3 class="text-3xl font-display text-primary mb-8 flex items-center gap-4">
                <i class="fas fa-magic"></i> Constructor
            </h3>
            <form action="{{ route('superadmin.createModule') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-primary text-[10px] font-extra-bold uppercase tracking-widest mb-3 ml-1">Nombre (Estilo Model)</label>
                        <input type="text" name="name" placeholder="Ej: Proveedor" class="w-full bg-gray-50 border border-gray-50 rounded-2xl py-4 px-6 font-bold text-sm" required>
                    </div>
                    <div class="relative" id="icon-selector-container">
                        <label class="block text-primary text-[10px] font-extra-bold uppercase tracking-widest mb-3 ml-1">Icono del Módulo</label>
                        <input type="hidden" name="icon" id="icon-input-value" value="fas fa-magic">
                        <div id="icon-dropdown-trigger" class="w-full bg-gray-50 border border-gray-50 rounded-2xl py-4 px-6 flex items-center justify-between cursor-pointer hover:border-primary/50 transition">
                            <div id="icon-selected-preview" class="flex items-center gap-3">
                                <i class="fas fa-magic text-primary text-xl"></i>
                                <span class="font-bold text-textMain text-sm">fas fa-magic</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-300 transition-transform duration-300" id="icon-chevron"></i>
                        </div>

                        <!-- Dropdown List -->
                        <div id="icon-dropdown-list" class="hidden absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-[2rem] shadow-2xl z-[100] p-6 max-h-[350px] overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
                            <div class="relative mb-6">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
                                <input type="text" id="icon-search-input" placeholder="Buscar icono..." class="w-full bg-gray-50 border-none rounded-xl py-3 pl-10 pr-4 text-xs font-bold focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                            
                            <div class="overflow-y-auto flex-grow pr-2 custom-scrollbar">
                                @foreach($icons as $categoryGroup => $list)
                                    <div class="mb-6 icon-category-group text-left">
                                        <h4 class="text-[9px] font-bold text-gray-300 uppercase tracking-widest mb-4 ml-1 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-primary rounded-full"></span> {{ $categoryGroup }}
                                        </h4>
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach($list as $icon)
                                                <div class="icon-item p-3 rounded-2xl hover:bg-primary/5 border border-transparent hover:border-primary/10 cursor-pointer flex flex-col items-center gap-2 transition group" 
                                                     data-icon="{{ $icon }}"
                                                     onclick="selectIcon('{{ $icon }}')">
                                                    <div class="h-8 w-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-primary group-hover:bg-primary/10 transition">
                                                        <i class="{{ $icon }} text-lg"></i>
                                                    </div>
                                                    <span class="text-[7px] font-bold text-gray-400 truncate w-full text-center uppercase">{{ str_replace('fas fa-', '', $icon) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-primary text-[10px] font-extra-bold uppercase tracking-widest mb-3 ml-1">Identidad Visual (Color)</label>
                    <input type="color" name="color" value="#00A859" class="h-16 w-full rounded-2xl cursor-pointer shadow-sm">
                </div>

                <div>
                    <label class="block text-primary text-[10px] font-extra-bold uppercase tracking-widest mb-3 ml-1">Campos (Estructura JSON)</label>
                    <textarea name="fields" rows="4" class="w-full bg-gray-50 border border-gray-50 rounded-2xl py-4 px-6 font-mono text-xs" required>[{"name": "nombre", "type": "string"}, {"name": "valor", "type": "decimal"}]</textarea>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3 ml-1">
                        <label class="block text-primary text-[10px] font-extra-bold uppercase tracking-widest ">Relaciones y Visualización</label>
                        <span class="text-[9px] bg-secondary/10 text-secondary px-2 py-1 rounded font-bold uppercase tracking-widest">Avanzado</span>
                    </div>
                    <textarea name="relations" rows="3" class="w-full bg-gray-50 border border-gray-50 rounded-2xl py-4 px-6 font-mono text-xs" placeholder='[{"model": "Category", "type": "belongsTo", "display_column": "name"}]'></textarea>
                    <p class="text-[9px] text-gray-400 mt-3 italic leading-relaxed">
                        <i class="fas fa-info-circle mr-1"></i> Usa <span class="font-bold text-dark">"display_column"</span> para elegir qué campo se verá en el Selector Dinámico del nuevo módulo.
                    </p>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-green-700 text-white font-extra-bold py-5 rounded-3xl shadow-xl shadow-bg-primary/20 transition transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg mt-10 uppercase">
                    <i class="fas fa-hammer text-xl"></i> Crear Módulo
                </button>
            </form>
        </div>
    </div>

    <!-- Módulos Instalados -->
    <div class="lg:col-span-7 space-y-8">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <h3 class="text-3xl font-display text-textMain mb-8 flex items-center gap-4">
                <i class="fas fa-layer-group text-dark"></i> Instalados
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($modules as $module)
                    <div class="flex flex-col gap-4 p-6 bg-gray-50 rounded-3xl border border-gray-100 transition-all hover:bg-white hover:shadow-xl hover:shadow-gray-200/30 group">
                        <div class="flex items-center gap-4">
                            <div class="h-14 w-14 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-gray-200/50 group-hover:scale-110 transition" style="background-color: {{ $module->color }}">
                                <i class="{{ $module->icon }} text-2xl"></i>
                            </div>
                            <div>
                                <div class="font-display text-xl text-textMain tracking-wide group-hover:text-primary transition">{{ $module->name }}</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Activo</div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-200/50 flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-300">{{ $module->created_at->format('d/m/Y') }}</span>
                            <a href="{{ route('admin.modules.index', $module->name) }}" class="text-xs font-extra-bold text-primary hover:underline flex items-center gap-1">
                                VER CRUD <i class="fas fa-chevron-right text-[8px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-20 bg-gray-50 rounded-[2.5rem] border border-dashed border-gray-200">
                        <div class="text-gray-300 font-display text-2xl uppercase tracking-widest">Zona Vacía</div>
                        <p class="text-gray-400 text-xs font-medium italic mt-2">No has construido extensiones todavía.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
<script>
    function toggleIconDropdown() {
        const list = document.getElementById('icon-dropdown-list');
        const chevron = document.getElementById('icon-chevron');
        list.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }

    document.getElementById('icon-dropdown-trigger').addEventListener('click', function(e) {
        e.stopPropagation();
        toggleIconDropdown();
    });

    document.getElementById('icon-search-input').addEventListener('click', (e) => e.stopPropagation());

    document.getElementById('icon-search-input').addEventListener('input', function(e) {
        const search = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.icon-item');
        const groups = document.querySelectorAll('.icon-category-group');

        items.forEach(item => {
            const iconName = item.getAttribute('data-icon').toLowerCase();
            if (iconName.includes(search)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });

        groups.forEach(group => {
            const visibleItems = group.querySelectorAll('.icon-item[style="display: flex;"]').length;
            if (visibleItems === 0 && search !== '') {
                group.style.display = 'none';
            } else {
                group.style.display = 'block';
            }
        });
    });

    function selectIcon(iconCode) {
        document.getElementById('icon-input-value').value = iconCode;
        document.getElementById('icon-selected-preview').innerHTML = `
            <i class="${iconCode} text-primary text-xl"></i>
            <span class="font-bold text-textMain text-sm">${iconCode}</span>
        `;
        toggleIconDropdown();
    }

    // Close on outside click
    document.addEventListener('click', function(e) {
        const container = document.getElementById('icon-selector-container');
        const list = document.getElementById('icon-dropdown-list');
        const chevron = document.getElementById('icon-chevron');
        
        if (container && !container.contains(e.target)) {
            list.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    });
</script>
@endsection
