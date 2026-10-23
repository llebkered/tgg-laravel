<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * The GST included in this order's total. Use this to show GST rather than
     * the stored gst column, which holds 1/10 of the total on orders placed
     * before October 2026.
     */
    public function gstAmount()
    {
        return static::gstIncluded($this->total);
    }

    /**
     * The items ordered, as they were in the cart when the order was placed.
     */
    protected function products(): Attribute
    {
        return Attribute::get(fn () => (array) json_decode($this->cart ?? '[]'));
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
