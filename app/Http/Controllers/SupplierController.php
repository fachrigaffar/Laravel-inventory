<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Suppliers/Index', [
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Suppliers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'nullable|max:15',
            'address' => 'nullable|max:500',
        ]);

        Supplier::create($request->only(['name', 'phone', 'address']));

        return to_route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Suppliers/Show', [
            'supplier' => Supplier::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Suppliers/Edit', [
            'supplier' => Supplier::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'nullable|max:15',
            'address' => 'nullable|max:500',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->only(['name', 'phone', 'address']));

        return to_route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::destroy($id);

        return to_route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
