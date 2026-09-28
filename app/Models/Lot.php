<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'development_id',
        'block',
        'number',
        'area',
        'price',
        'status',
    ];

    public function development()
    {
        return $this->belongsTo(Development::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
