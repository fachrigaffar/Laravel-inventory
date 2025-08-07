<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    public function IncomingTransactions(): HasMany
    {
        return $this->hasMany(IncomingTransaction::class);
    }
}
