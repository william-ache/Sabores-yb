@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10">
        <h2 class="text-4xl font-display text-textMain tracking-tight">Editar Producto</h2>
        <p class="text-gray-500 font-medium">Modifica los detalles de <span class="text-primary font-bold">"{{ $product->title }}"</span>.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-300/40 border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-12">
            <form method="POST" action="{{ route('admin.update', $product) }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Nombre del Producto</label>
                        <input type="text" name="title" value="{{ $product->title }}" placeholder="Ej. Empanada de Mechada" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Descripción corta</label>
                        <textarea name="description" placeholder="Ingredientes o detalles especiales..." rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition">{{ $product->description }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Precio (Ref. USD)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-bold text-gray-400">$</span>
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}" placeholder="1.50" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Categoría</label>
                        <select name="category_id" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition appearance-none" required>
                            <option value="">Selecciona una categoría...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Orden de Visualización</label>
                        <input type="number" name="sort_order" value="{{ $product->sort_order }}" min="0" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-textMain font-bold focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" required>
                    </div>

                    <div class="md:col-span-2 space-y-4">
                        <label class="block text-primary text-xs font-bold uppercase tracking-widest mb-3 ml-1">Imagen del Producto (Cuadrada idealmente)</label>
                        
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <!-- Dropzone / Preview -->
                            <div class="relative w-full md:w-1/2 group">
                                <input type="file" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                                <div id="dropzone-content" class="w-full h-48 bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] flex flex-col items-center justify-center text-center group-hover:border-primary/50 transition group-hover:bg-primary/5 overflow-hidden">
                                    <div id="placeholder-info" class="{{ $product->image_path ? 'hidden' : '' }}">
                                        <i class="fas fa-image text-4xl text-gray-300 mb-2 group-hover:text-primary transition"></i>
                                        <p class="text-sm text-gray-400 font-bold group-hover:text-primary transition px-4">Click o arrastra para cambiar la foto</p>
                                    </div>
                                    <img id="imagePreview" src="{{ $product->image_path ? asset('storage/' . $product->image_path) : '' }}" class="{{ $product->image_path ? '' : 'hidden' }} w-full h-full object-cover">
                                </div>
                            </div>

                            <!-- Image Info / Reset -->
                            <div class="flex-grow space-y-3 w-full md:w-auto">
                                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
                                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                    <p class="text-xs text-blue-800 leading-relaxed">Si subes una nueva imagen, esta reemplazará a la actual automáticamente. Podrás <span class="font-bold">recortarla</span> al instante.</p>
                                </div>
                                <button type="button" id="resetImage" class="hidden text-xs font-bold text-accent uppercase tracking-widest hover:underline px-2">
                                    <i class="fas fa-undo mr-1"></i> Deshacer cambios
                                </button>
                            </div>
                        </div>

                        <!-- Hidden Cropped Image Input -->
                        <input type="hidden" name="cropped_image" id="croppedImageInput">
                    </div>

                    <div class="md:col-span-2 flex items-center justify-start pt-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="sr-only peer" {{ $product->is_active ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                            <span class="ms-3 text-xs font-bold text-gray-400 uppercase tracking-widest">¿Producto Visible en el Menú Digital?</span>
                        </label>
                    </div>
                </div>

                <!-- Cropper Modal -->
                <div id="cropperModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-dark/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div class="bg-white rounded-[2.5rem] w-full max-w-2xl overflow-hidden shadow-2xl animate-in zoom-in duration-300 flex flex-col max-h-[90vh]">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <div>
                                <h3 class="text-xl font-display text-primary uppercase">Actualizar Recorte</h3>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Prepara tu producto para lucir de diez</p>
                            </div>
                            <button type="button" onclick="closeCropper()" class="h-10 w-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-gray-400 hover:text-accent transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="p-6 flex-grow overflow-hidden flex items-center justify-center bg-gray-200/30">
                            <img id="cropperImage" class="max-w-full max-h-[50vh]">
                        </div>

                        <div class="p-8 border-t border-gray-100 flex justify-end gap-4 bg-gray-50/50">
                            <button type="button" onclick="closeCropper()" class="px-6 py-3 text-sm font-bold text-gray-400 hover:text-textMain transition">Cancelar</button>
                            <button type="button" id="cropButton" class="bg-primary hover:bg-green-600 text-white font-bold py-3 px-10 rounded-2xl shadow-lg shadow-primary/20 transition flex items-center gap-2">
                                <i class="fas fa-check"></i> Aplicar Recorte
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="{{ url()->previous() }}" class="text-gray-400 font-bold hover:text-textMain transition order-2 sm:order-1">Cancelar edición</a>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-primary hover:bg-green-600 text-white font-bold py-4 px-12 rounded-2xl shadow-lg shadow-primary/20 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 order-1 sm:order-2">
                        <i class="fas fa-sync-alt" id="submitIcon"></i> 
                        <span id="submitText">Actualizar producto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const cropperModal = document.getElementById('cropperModal');
    const cropperImage = document.getElementById('cropperImage');
    const imagePreview = document.getElementById('imagePreview');
    const placeholderInfo = document.getElementById('placeholder-info');
    const croppedImageInput = document.getElementById('croppedImageInput');
    const resetImageBtn = document.getElementById('resetImage');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitIcon = document.getElementById('submitIcon');
    const initialImageUrl = imagePreview.src;

    imageInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(event) {
                cropperImage.src = event.target.result;
                cropperModal.classList.remove('hidden');
                cropperModal.classList.add('flex');
                
                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 2,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            };
            reader.readAsDataURL(files[0]);
        }
    });

    document.getElementById('cropButton').addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({
            width: 800,
            height: 800,
        });

        canvas.toBlob(function(blob) {
            const url = URL.createObjectURL(blob);
            imagePreview.src = url;
            imagePreview.classList.remove('hidden');
            placeholderInfo.classList.add('hidden');
            resetImageBtn.classList.remove('hidden');
            
            // Convert to base64 to send in hidden input
            const base64data = canvas.toDataURL('image/jpeg', 0.9);
            croppedImageInput.value = base64data;
            
            closeCropper();
        }, 'image/jpeg');
    });

    function closeCropper() {
        cropperModal.classList.add('hidden');
        cropperModal.classList.remove('flex');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // If they cancelled without cropping and no previous image, reset input
        if (!croppedImageInput.value) {
            imageInput.value = '';
        }
    }

    resetImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        croppedImageInput.value = '';
        
        if (initialImageUrl && initialImageUrl.includes('storage')) {
            imagePreview.src = initialImageUrl;
            imagePreview.classList.remove('hidden');
            placeholderInfo.classList.add('hidden');
        } else {
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            placeholderInfo.classList.remove('hidden');
        }
        
        resetImageBtn.classList.add('hidden');
    });

    // Loading State on Submit
    document.querySelector('form').addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
        submitText.innerText = 'Actualizando...';
        submitIcon.className = 'fas fa-spinner fa-spin';
    });
</script>
@endsection
