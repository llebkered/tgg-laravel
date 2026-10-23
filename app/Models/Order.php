<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The GST in a GST-inclusive amount. At 10% GST that is 1/11 of the total.
     */
    public static function gstIncluded($total)
    {
        return round($total / 11, 2);
    }

    public function isPaid()
    {
        return $this->order_status_id == OrderStatus::Paid->value;
    }

    public function order_status()
    {
        // return ['orderStatus'];
        return $this->belongsTo('App\Models\OrderStatus'); //,'order_status_id'
    }

    // address
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerAddress(){
        return $this->hasOneThrough(Customer::class, Address::class);
    }
}
