<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order_status()
    {
        // return ['orderStatus'];
        return $this->belongsTo('App\Models\OrderStatus'); //,'order_status_id'
    }

    // address
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerAddress(){
        return $this->hasOneThrough(Customer::class, Address::class);
    }
}
