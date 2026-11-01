<?php

namespace App\Actions;

use App\Models\Variation;
use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * Bring the cart in line with the shop. Items keep the name and price they had
 * when added, so an item since unpublished, put out of stock or repriced would
 * otherwise be sold as it was.
 */
class RefreshCart
{
    /**
     * Remove items that can no longer be bought and update changed names and
     * prices.
     *
     * @return string|null  what changed, to tell the customer, or null
     */
    public function __invoke(): ?string
    {
        $cart = Cart::instance('cart');

        $variations = Variation::with('product')
            ->findMany($cart->content()->pluck('id'))
            ->keyBy('id');

        $changes = [];

        foreach ($cart->content() as $item) {
            $variation = $variations->get($item->id);
            $product = $variation?->product;

            if (! $variation?->is_published || ! $product?->published || ! $product->stocked) {
                $cart->remove($item->rowId);
                $changes[] = "{$item->name} is no longer available and has been removed.";

                continue;
            }

            $name = $product->title . ' - ' . $variation->title;

            // Compared in cents, as floats of the same price can differ slightly
            $priceChanged = (int) round($item->price * 100) !== (int) round($variation->price * 100);

            if ($priceChanged) {
                $changes[] = sprintf(
                    '%s has changed price from %s to %s.',
                    $name,
                    money($item->price),
                    money($variation->price)
                );
            }

            if ($item->name !== $name || $priceChanged) {
                $cart->update($item->rowId, ['name' => $name, 'price' => $variation->price]);
            }
        }

        return $changes ? implode(' ', $changes) : null;
    }
}
