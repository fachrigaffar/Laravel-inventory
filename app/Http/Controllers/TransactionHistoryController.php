<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        // Fetch incoming transactions with relationships
        $incomingQuery = IncomingTransaction::with(['supplier', 'product'])
            ->select('id', DB::raw("'Incoming' as type"), 'supplier_id', 'product_id', 'quantity', 'transaction_date', 'created_at', 'created_by');

        // Filter by created_by if user is not admin
        if (!$isAdmin) {
            $incomingQuery->where('created_by', $user->id);
        }

        $incoming = $incomingQuery->get();

        // Fetch outgoing transactions with relationships
        $outgoingQuery = OutgoingTransaction::with(['customer', 'product'])
            ->select('id', DB::raw("'Outgoing' as type"), 'customer_id', 'product_id', 'quantity', 'transaction_date', 'created_at', 'created_by');

        // Filter by created_by if user is not admin
        if (!$isAdmin) {
            $outgoingQuery->where('created_by', $user->id);
        }

        $outgoing = $outgoingQuery->get();

        // Combine and sort transactions
        $transactions = $incoming->concat($outgoing)
            ->map(function ($transaction) {
                $entity_name = $transaction->type === 'Incoming'
                    ? ($transaction->supplier ? $transaction->supplier->name : 'N/A')
                    : ($transaction->customer ? $transaction->customer->name : 'N/A');

                // Log warnings for missing relationships
                if (!$transaction->supplier && $transaction->type === 'Incoming' && $transaction->supplier_id) {
                    Log::warning('Missing supplier for IncomingTransaction ID: ' . $transaction->id . ', supplier_id: ' . $transaction->supplier_id);
                } elseif (!$transaction->customer && $transaction->type === 'Outgoing' && $transaction->customer_id) {
                    Log::warning('Missing customer for OutgoingTransaction ID: ' . $transaction->id . ', customer_id: ' . $transaction->customer_id);
                }

                return [
                    'id' => $transaction->id,
                    'type' => $transaction->type,
                    'entity_name' => $entity_name,
                    'product_name' => $transaction->product ? $transaction->product->name : 'N/A',
                    'product_stock' => $transaction->product ? $transaction->product->stock : null,
                    'quantity' => $transaction->quantity,
                    'transaction_date' => $transaction->transaction_date,
                    'created_by' => $transaction->created_by, // Include creator info if needed
                ];
            })
            ->sortByDesc(function ($transaction) {
                return [$transaction['transaction_date'], $transaction['id']];
            })
            ->values();

        return Inertia::render('TransactionHistory', [
            'transactions' => $transactions,
        ]);
    }
}
