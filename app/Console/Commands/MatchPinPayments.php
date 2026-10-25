<?php

namespace App\Console\Commands;

use App\Actions\FindOrderCharges;
use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Console\Command;

/**
 * Fill in the payment method of older orders: an order with a clear
 * successful charge in Pin was paid by card. Orders with no such charge are
 * left as they are, since they may have been paid by direct deposit.
 */
class MatchPinPayments extends Command
{
    protected $signature = 'orders:match-pin-payments
        {--dry-run : Show what would change without saving anything}
        {--order=* : Only check these order ids}';

    protected $description = 'Set the payment method to card for orders with a successful Pin charge';

    public function handle(FindOrderCharges $findCharges): int
    {
        $orders = Order::whereNull('payment_method')
            ->when($this->option('order'), fn ($query, $ids) => $query->whereIn('id', $ids))
            ->orderBy('id')
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No orders have an unknown payment method.');

            return self::SUCCESS;
        }

        $this->info('Checking ' . $orders->count() . ' orders with Pin' . ($this->option('dry-run') ? ' (dry run, nothing will be saved)' : '') . '...');

        $rows = [];
        $counts = ['card' => 0, 'unclear' => 0, 'none' => 0, 'error' => 0];

        foreach ($orders as $i => $order) {
            // Stay well inside Pin's rate limits
            if ($i > 0 && ! app()->runningUnitTests()) {
                usleep(200_000);
            }

            try {
                $charges = $findCharges($order);
            } catch (\Throwable $e) {
                $counts['error']++;
                $rows[] = [$order->id, $order->email, $order->order_status_id?->label(), 'Pin error: ' . $e->getMessage()];

                continue;
            }

            if ($charge = FindOrderCharges::confirmedCharge($order, $charges)) {
                $counts['card']++;
                $note = 'Card (' . $charge['token'] . ')';
                if ($order->order_status_id === OrderStatus::InCart) {
                    $note .= ' - charged, but the order is still In Cart. Check it.';
                }
                if (! $this->option('dry-run')) {
                    FindOrderCharges::recordCardPayment($order, $charge);
                }
            } elseif (FindOrderCharges::matching($charges)->isNotEmpty()) {
                $counts['unclear']++;
                $note = 'Unclear: more than one possible charge. Check it on the order screen.';
            } else {
                $counts['none']++;

                continue;
            }

            $rows[] = [$order->id, $order->email, $order->order_status_id?->label(), $note];
        }

        if ($rows) {
            $this->table(['Order', 'Email', 'Status', 'Result'], $rows);
        }

        $this->info(sprintf(
            '%s card: %d. Unclear: %d. No successful charge in Pin: %d. Errors: %d.',
            $this->option('dry-run') ? 'Would set to' : 'Set to',
            $counts['card'], $counts['unclear'], $counts['none'], $counts['error']
        ));

        return $counts['error'] ? self::FAILURE : self::SUCCESS;
    }
}
