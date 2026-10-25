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

    protected $casts = [
        'order_status_id' => OrderStatus::class,
        'payment_started_at' => 'datetime',
    ];

    /**
     * How long a card payment can take. Pin calls time out after 60 seconds,
     * so a payment started longer ago than this has finished one way or
     * another.
     */
    public const PAYMENT_TIMEOUT_MINUTES = 2;

    /**
     * The GST in a GST-inclusive amount. At 10% GST that is 1/11 of the total.
     */
    public static function gstIncluded($total)
    {
        return round($total / 11, 2);
    }

    /**
     * The GST included in this order's total. Use this to show GST rather than
     * the stored gst column. Orders placed before October 2026 stored 1/10 of
     * the total until a migration corrected them, keeping the figure their
     * invoices showed in gst_as_invoiced.
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
        return $this->order_status_id === OrderStatus::Paid;
    }

    /**
     * A card payment was started but its result is unknown, so the order is
     * blocked until staff check Pin. False while a payment is still running.
     */
    public function paymentNeedsChecking()
    {
        return ! in_array($this->order_status_id?->value, OrderStatus::settled(), true)
            && $this->payment_started_at
            && $this->payment_started_at->lte(now()->subMinutes(self::PAYMENT_TIMEOUT_MINUTES));
    }

    /**
     * Limit a query to orders whose card payment needs checking.
     */
    public function scopePaymentNeedsChecking($query)
    {
        return $query->whereNotIn('order_status_id', OrderStatus::settled())
            ->where('payment_started_at', '<=', now()->subMinutes(self::PAYMENT_TIMEOUT_MINUTES));
    }

    /**
     * The columns the backend order list can be sorted by, keyed by the name
     * used in the address bar.
     */
    public const SORTABLE = [
        'id' => 'id',
        'date' => 'created_at',
        'name' => 'name',
        'status' => 'order_status_id',
    ];

    /**
     * Sort by one of SORTABLE, newest first by default. Anything else in the
     * address bar is ignored. Status sorts in workflow order (In Cart first).
     */
    public function scopeSortedBy($query, $sort = null, $direction = null)
    {
        $column = is_string($sort) ? (self::SORTABLE[$sort] ?? 'id') : 'id';
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $query->orderBy($column, $direction);

        // Newest first among orders with the same name, date or status
        if ($column !== 'id') {
            $query->orderBy('id', 'desc');
        }

        return $query;
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
