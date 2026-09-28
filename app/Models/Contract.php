<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lot_id',
        'customer_id',
        'date',
        'total_amount',
        'down_payment',
        'financing_term_months',
        'interest_rate',
        'status',
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
