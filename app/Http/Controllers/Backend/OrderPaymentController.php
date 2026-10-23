<?php

namespace App\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Events\OrderPaid;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Resolves card payments whose result is unknown, once staff have checked
 * the Pin Payments dashboard.
 */
class OrderPaymentController extends Controller
{
    /**
     * The card was charged: mark the order paid.
     */
    public function markPaid(Request $request, Order $order)
    {
        $data = $request->validate([
            'charge_token' => ['nullable', 'string', 'max:255'],
        ]);

        // Atomic, so two staff clicking at once can't both act on the order
        $updated = Order::whereKey($order->id)
            ->paymentNeedsChecking()
            ->update([
                'order_status_id' => OrderStatus::Paid->value,
                'charge_token' => $data['charge_token'] ?? null,
            ]);

        if (! $updated) {
            return back()->with('danger_message', 'This order has no unconfirmed card payment to resolve.');
        }

        if ($request->boolean('email_receipt')) {
            OrderPaid::dispatch($order->fresh());
        }

        return back()->with('success_message', 'Order marked as paid.');
    }

    /**
     * There was no charge in Pin: release the order so it can be paid again.
     */
    public function release(Order $order)
    {
        $updated = Order::whereKey($order->id)
            ->paymentNeedsChecking()
            ->update(['payment_started_at' => null]);

        if (! $updated) {
            return back()->with('danger_message', 'This order has no unconfirmed card payment to resolve.');
        }

        return back()->with('success_message', 'Payment released. The order can be paid again.');
    }
}
