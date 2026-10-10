<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('category', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->paginate(10);
        return view('admin.inventory.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'critical_level' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ]);

        Inventory::create($request->all());

        return back()->with('success', 'Item inventaris berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'critical_level' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ]);

        $item->update($request->all());

        return back()->with('success', 'Stok inventaris berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Inventory::destroy($id);
        return back()->with('success', 'Item inventaris berhasil dihapus.');
    }
}
