<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'contract_id',
        'installment_number',
        'due_date',
        'principal_amount',
        'interest_amount',
        'total_amount',
        'paid_amount',
        'status',
        'paid_date',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
