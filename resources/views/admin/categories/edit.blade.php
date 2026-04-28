@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('categories.index') }}" class="text-sm font-bold text-gray-400 hover:text-primary transition flex items-center gap-2 mb-6">
            <i class="fas fa-arrow-left text-xs"></i> Volver a Categorías
        </a>
    </div>

    <div class="mb-10">
        <h2 class="text-4xl font-display text-textMain tracking-tight">Editar Categoría</h2>
        <p class="text-gray-500 font-medium">Actualiza el nombre de la categoría.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-300/40 border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-12">
            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-8">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Nombre de la Categoría</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Icono de la Categoría</label>
                        <div class="relative" id="icon-selector-container">
                            <input type="hidden" name="icon" id="icon-input-value" value="{{ $category->icon ?: 'fas fa-layer-group' }}">
                            <div id="icon-dropdown-trigger" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 flex items-center justify-between cursor-pointer hover:border-primary/50 transition">
                                <div id="icon-selected-preview" class="flex items-center gap-3">
                                    <i class="{{ $category->icon ?: 'fas fa-layer-group' }} text-primary text-xl"></i>
                                    <span class="font-bold text-textMain">{{ $category->icon ?: 'fas fa-layer-group' }}</span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-300 transition-transform duration-300" id="icon-chevron"></i>
                            </div>

                            <!-- Dropdown List -->
                            <div id="icon-dropdown-list" class="hidden absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-[2rem] shadow-2xl z-[100] p-6 max-h-[400px] overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
                                <div class="relative mb-6">
                                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
                                    <input type="text" id="icon-search-input" placeholder="Buscar icono..." class="w-full bg-gray-50 border-none rounded-xl py-3 pl-10 pr-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                                
                                <div class="overflow-y-auto flex-grow pr-2 custom-scrollbar">
                                    @foreach($icons as $categoryGroup => $list)
                                        <div class="mb-6 icon-category-group">
                                            <h4 class="text-[10px] font-bold text-gray-300 uppercase tracking-widest mb-4 ml-1 flex items-center gap-2">
                                                <span class="w-1 h-1 bg-primary rounded-full"></span> {{ $categoryGroup }}
                                            </h4>
                                            <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                                                @foreach($list as $icon)
                                                    <div class="icon-item p-3 rounded-2xl hover:bg-primary/5 border border-transparent hover:border-primary/10 cursor-pointer flex flex-col items-center gap-2 transition group" 
                                                         data-icon="{{ $icon }}"
                                                         onclick="selectIcon('{{ $icon }}')">
                                                        <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-primary group-hover:bg-primary/10 transition">
                                                            <i class="{{ $icon }} text-xl"></i>
                                                        </div>
                                                        <span class="text-[8px] font-bold text-gray-400 truncate w-full text-center uppercase">{{ str_replace('fas fa-', '', $icon) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Orden de Visualización</label>
                        <input type="number" name="sort_order" value="{{ $category->sort_order }}" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" required>
                    </div>
                    <div class="flex items-center gap-4 pt-8">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="sr-only peer" {{ $category->is_active ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                            <span class="ms-3 text-xs font-bold text-gray-400 uppercase tracking-widest">¿Categoría Activa?</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Color Distintivo</label>
                    <div class="flex items-center gap-4">
                        <input type="color" name="color" value="{{ $category->color ?: '#00A859' }}" class="h-14 w-14 rounded-2xl cursor-pointer shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-400 font-medium">Este color se usará en el menú digital.</p>
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="{{ url()->previous() }}" class="text-gray-400 font-bold hover:text-textMain transition order-2 sm:order-1">Cancelar</a>
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-green-600 text-white font-bold py-4 px-12 rounded-2xl shadow-lg shadow-primary/20 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 order-1 sm:order-2">
                        <i class="fas fa-sync-alt"></i> Actualizar categoría
                    </button>
                </div>
            </form>
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
            <span class="font-bold text-textMain">${iconCode}</span>
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
