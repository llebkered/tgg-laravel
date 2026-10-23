<?php

namespace App\Actions;

use App\Enums\ChargeStatus;
use App\Enums\OrderStatus;
use App\Libraries\Pin\PinPayments;
use App\Mail\PaymentUnconfirmedMail;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Charge an order's total to a card through Pin Payments, making sure the
 * order is never charged twice.
 */
class ChargeOrder
{
    public function __construct(private PinPayments $pin)
    {
    }

    /**
     * @param  array  $card  name, number, expiry_month, expiry_year and cvc
     */
    public function __invoke(Order $order, array $card): ChargeResult
    {
        // Check before claiming the order, so a missing key is an error rather
        // than a blocked order the customer is told may have been charged.
        $this->pin->ensureConfigured();

        // Claim the order so only one request can charge it. The update is
        // atomic, so a double click or resubmit finds the order already claimed.
        $claimed = Order::where('id', '=', $order->id)
            ->where('order_status_id', '!=', OrderStatus::Paid->value)
            ->whereNull('payment_started_at')
            ->update(['payment_started_at' => now()]);

        if (! $claimed) {
            return new ChargeResult(ChargeStatus::AlreadyClaimed);
        }

        try {
            $response = $this->pin->charge($this->chargeDetails($order, $card));
        } catch (\Throwable $e) {
            // No response (e.g. timeout): the card may have been charged.
            report($e);

            return $this->unconfirmed($order);
        }

        if ($response->status() == 201) {
            $order->order_status_id = OrderStatus::Paid;
            $order->charge_token = $response->json('response.token');
            $order->save();

            return new ChargeResult(ChargeStatus::Paid);
        }

        if ($response->clientError()) {
            // Pin rejected the charge (e.g. card declined), so nothing was
            // charged. Release the claim so the customer can try again.
            Order::where('id', '=', $order->id)->update(['payment_started_at' => null]);

            return new ChargeResult(
                ChargeStatus::Declined,
                $response->json('error_description') ?? 'Your card could not be charged. Please check your card details.'
            );
        }

        // 5xx or any other response: the outcome is unknown, so keep the order
        // claimed rather than risk charging the card twice.
        return $this->unconfirmed($order, $response->status() . ' ' . $response->body());
    }

    /**
     * The card may or may not have been charged. Leave the order claimed so
     * it can't be charged again, and ask staff to check the payment in Pin.
     */
    private function unconfirmed(Order $order, $detail = 'no response')
    {
        Log::error('Card payment outcome unknown for order ' . $order->id . ': ' . $detail);

        try {
            Mail::to(config('tgg.sales_email'))->send(new PaymentUnconfirmedMail($order, $detail));
        } catch (\Throwable $e) {
            report($e);
        }

        return new ChargeResult(ChargeStatus::Unconfirmed);
    }

    private function chargeDetails(Order $order, array $card)
    {
        return [
            'card' => $card + [
                'address_line1' => $order->line1,
                'address_line2' => $order->line2,
                'address_city' => $order->city,
                'address_postcode' => $order->postcode,
                'address_state' => $order->state,
                'address_country' => 'Australia',
            ],
            'description' => $this->description($order),
            'amount' => (int) round($order->total * 100),
            'email' => $order->email,
        ];
    }

    /**
     * The names of the items ordered.
     */
    private function description(Order $order)
    {
        return collect($order->products)
            ->map(fn ($item) => $item->name . ' <br> ')
            ->implode('');
    }
}
