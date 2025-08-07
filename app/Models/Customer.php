<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    public function outgoingTransactions()
    {
        return $this->hasMany(OutgoingTransaction::class);
    }
}
