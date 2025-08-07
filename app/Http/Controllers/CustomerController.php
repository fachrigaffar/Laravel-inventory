<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Customers/Index', [
            'customers' => Customer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Customers/Create');
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

        Customer::create($request->only(['name', 'phone', 'address']));

        return to_route('customers.index')->with('success', 'Customer created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Customers/Show', [
            'customer' => Customer::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Customers/Edit', [
            'customer' => Customer::findOrFail($id)
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

        $customer = Customer::findOrFail($id);
        $customer->update($request->only(['name', 'phone', 'address']));

        return to_route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::destroy($id);

        return to_route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
