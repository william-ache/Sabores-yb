<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index');
    }

    public function index()
    {
        $products = Product::orderBy('category_id')->orderBy('sort_order')->get();
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'sort_order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Manejar imagen recortada (Base64)
        if ($request->filled('cropped_image')) {
            $imageData = $request->input('cropped_image');
            $fileName = 'products/' . time() . '_' . uniqid() . '.jpg';
            
            // Eliminar el prefijo data:image/jpeg;base64,
            $data = explode(',', $imageData);
            $decodedImage = base64_decode($data[1]);
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $decodedImage);
            $validated['image_path'] = $fileName;
        } 
        // Fallback para imagen normal si no hay recorte o si falla
        elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Producto creado con éxito.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'sort_order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Manejar imagen recortada (Base64)
        if ($request->filled('cropped_image')) {
            $imageData = $request->input('cropped_image');
            $fileName = 'products/' . time() . '_' . uniqid() . '.jpg';
            
            $data = explode(',', $imageData);
            $decodedImage = base64_decode($data[1]);
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $decodedImage);
            $validated['image_path'] = $fileName;
        } 
        elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }
}
