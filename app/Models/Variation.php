<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class Variation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The price in dollars. It is stored as whole cents in price_cents to
     * avoid rounding errors. A saved variation read without price_cents (the
     * migration not run, or a query that left it out) throws rather than
     * showing customers a price of $0.00.
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($this->exists && ! array_key_exists('price_cents', $attributes)) {
                    throw new LogicException('Variation '.$this->getKey().' was loaded without price_cents. Has the cents migration been run?');
                }

                return isset($attributes['price_cents']) ? $attributes['price_cents'] / 100 : null;
            },
            set: fn ($value) => ['price_cents' => $value === null || $value === '' ? null : (int) round((float) $value * 100)],
        );
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
