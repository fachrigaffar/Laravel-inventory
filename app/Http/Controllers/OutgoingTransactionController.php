<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OutgoingTransaction;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class OutgoingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('OutgoingTransactions/Index', [
            'transactions' => OutgoingTransaction::with(['customer', 'product'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('OutgoingTransactions/Create', [
            'customers' => Customer::all(),
            'products' => Product::select('id', 'name', 'stock')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {
            throw ValidationException::withMessages([
                'quantity' => 'Insufficient stock. Available: ' . $product->stock,
            ]);
        }

        $product->decrement('stock', $request->quantity);

        OutgoingTransaction::create([
            'customer_id' => $request->customer_id,
            'product_id'=> $request->product_id,
            'quantity' => $request->quantity,
            'transaction_date' => $request->transaction_date,
            'created_by' => Auth::user()->id,
        ]);

        return to_route('outgoing-transactions.index')->with('success', 'Outgoing transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('OutgoingTransactions/Show', [
            'transaction' => OutgoingTransaction::with(['customer', 'product'])->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('OutgoingTransactions/Edit', [
            'transaction' => OutgoingTransaction::with(['customer', 'product'])->findOrFail($id),
            'customers' => Customer::all(),
            'products' => Product::select('id', 'name', 'stock')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'created_by' => 'nullable',
        ]);

        $transaction = OutgoingTransaction::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        // Calculate available stock (add back old quantity if same product)
        $availableStock = $transaction->product_id === $request->product_id
            ? $product->stock + $transaction->quantity
            : $product->stock;

        if ($availableStock < $request->quantity) {
            throw ValidationException::withMessages([
                'quantity' => 'Insufficient stock. Available: ' . $availableStock,
            ]);
        }

        // Revert old quantity, apply new quantity
        if ($transaction->product_id === $request->product_id) {
            $product->decrement('stock', $request->quantity - $transaction->quantity);
        } else {
            // If product_id changed, revert stock for old product, update for new
            Product::findOrFail($transaction->product_id)->increment('stock', $transaction->quantity);
            $product->decrement('stock', $request->quantity);
        }

        $transaction->update($request->only(['customer_id', 'product_id', 'quantity', 'transaction_date']));

        return to_route('outgoing-transactions.index')->with('success', 'Outgoing transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = OutgoingTransaction::findOrFail($id);
        $product = Product::findOrFail($transaction->product_id);
        $product->increment('stock', $transaction->quantity);

        $transaction->delete();

        return to_route('outgoing-transactions.index')->with('success', 'Outgoing transaction deleted successfully.');
    }
}
