<?php

namespace App\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Events\OrderPaid;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Payments staff record by hand: card payments whose result was unknown, once
 * checked in Pin, and direct deposits once they reach the bank.
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
                'payment_method' => PaymentMethod::Card->value,
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
     * A direct deposit for an invoiced order has reached the bank: mark the
     * order paid and, if asked, email the customer a receipt.
     */
    public function depositReceived(Request $request, Order $order)
    {
        // Atomic, so two staff clicking at once can't both send a receipt
        $updated = Order::whereKey($order->id)
            ->where('order_status_id', OrderStatus::Invoiced->value)
            ->update([
                'order_status_id' => OrderStatus::Paid->value,
                'payment_method' => PaymentMethod::DirectDeposit->value,
            ]);

        if (! $updated) {
            return back()->with('danger_message', "This order isn't waiting for a direct deposit.");
        }

        if ($request->boolean('email_receipt')) {
            OrderPaid::dispatch($order->fresh());

            return back()->with('success_message', 'Order marked as paid. The receipt has been emailed to the customer.');
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
