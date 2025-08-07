<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'stock',
    ];

    public function incomingTransactions()
    {
        return $this->hasMany(IncomingTransaction::class);
    }

    public function outgoingTransactions()
    {
        return $this->hasMany(OutgoingTransaction::class);
    }
}
