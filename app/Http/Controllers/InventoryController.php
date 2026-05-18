<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::all();
        return view('admin.inventory.index', compact('items'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        Inventory::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('inventories.index')->with('success', 'Material inventariado con éxito.');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('inventories.index')->with('success', 'Material actualizado con éxito.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Material eliminado del inventario.');
    }
}
