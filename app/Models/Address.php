<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationships

    // address
    public function order()
    {
        $this->belongsTo(Order::class);
    }

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }
}
