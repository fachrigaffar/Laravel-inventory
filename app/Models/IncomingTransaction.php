<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingTransaction extends Model
{
    protected $fillable = [
        'supplier_id',
        'product_id',
        'quantity',
        'transaction_date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
