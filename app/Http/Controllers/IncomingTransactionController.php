<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\IncomingTransaction;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IncomingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('IncomingTransactions/Index', [
            'transactions' => IncomingTransaction::with(['supplier', 'product'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('IncomingTransactions/Create', [
            'suppliers' => Supplier::all(),
            'products' => Product::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->increment('stock', $request->quantity);

        IncomingTransaction::create([
            'supplier_id' => $request->supplier_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'transaction_date' => $request->transaction_date,
            'created_by' => Auth::user()->id,
        ]);

        return to_route('incoming-transactions.index')->with('success', 'Incoming transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('IncomingTransactions/Show', [
            'transaction' => IncomingTransaction::with(['supplier', 'product'])->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('IncomingTransactions/Edit', [
            'transaction' => IncomingTransaction::with(['supplier', 'product'])->findOrFail($id),
            'suppliers' => Supplier::all(),
            'products' => Product::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
        ]);

        $transaction = IncomingTransaction::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        if ($transaction->product_id === $request->product_id) {
            $product->increment('stock', $request->quantity - $transaction->quantity);
        } else {
            Product::findOrFail($transaction->product_id)->decrement('stock', $transaction->quantity);
            $product->increment('stock', $request->quantity);
        }

        $transaction->update($request->only(['supplier_id', 'product_id', 'quantity', 'transaction_date']));

        return to_route('incoming-transactions.index')->with('success', 'Incoming transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = IncomingTransaction::findOrFail($id);
        $product = Product::findOrFail($transaction->product_id);
        $product->decrement('stock', $transaction->quantity);

        $transaction->delete();

        return to_route('incoming-transactions.index')->with('success', 'Incoming transaction deleted successfully.');
    }
}
