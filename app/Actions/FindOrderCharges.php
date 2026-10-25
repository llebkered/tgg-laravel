<?php

namespace App\Actions;

use App\Libraries\Pin\PinPayments;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use RuntimeException;

/**
 * Ask Pin Payments which charges belong to an order, so staff can see whether
 * a card was charged without searching the Pin dashboard.
 */
class FindOrderCharges
{
    public function __construct(private PinPayments $pin)
    {
    }

    /**
     * The order's recorded charge, if it has one. Otherwise charges to the
     * order's email around when its card payment started, newest first.
     *
     * @return Collection<int, array>  see charge() for the keys
     *
     * @throws RuntimeException  when Pin can't be asked or gives an error
     */
    public function __invoke(Order $order): Collection
    {
        if ($order->charge_token) {
            $response = $this->pin->findCharge($order->charge_token);

            if ($response->notFound()) {
                return collect();
            }

            $this->ensureSuccessful($response);

            return collect([$this->charge($order, $response->json('response'))]);
        }

        [$from, $to] = $this->searchDates($order);

        $response = $this->pin->searchCharges([
            'query' => $order->email,
            'start_date' => $from->format('Y/m/d'),
            'end_date' => $to->format('Y/m/d'),
            'sort' => 'created_at',
            'direction' => -1,
        ]);

        $this->ensureSuccessful($response);

        return collect($response->json('response', []))
            ->map(fn (array $charge) => $this->charge($order, $charge));
    }

    /**
     * The days searched: from the day before the card payment started (or the
     * order was made) to two days after. Pin's dates are whole days, and the
     * margin covers time zones.
     *
     * @return array{0: Carbon, 1: Carbon}  from (inclusive) and to (exclusive), in UTC
     */
    public function searchDates(Order $order): array
    {
        $started = ($order->payment_started_at ?? $order->created_at)->copy()->utc()->startOfDay();

        return [$started->copy()->subDay(), $started->copy()->addDays(2)];
    }

    /**
     * Successful charges that look like this order's: sent with its order
     * number, or for its amount.
     */
    public static function matching(Collection $charges): Collection
    {
        return $charges->filter(fn (array $charge) => $charge['success'] && $charge['captured']
            && ($charge['for_this_order'] || $charge['matches_amount']))->values();
    }

    private function ensureSuccessful($response): void
    {
        if ($response->failed()) {
            throw new RuntimeException('Pin replied with an error (' . $response->status() . ': '
                . ($response->json('error_description') ?? $response->json('error') ?? 'no details') . ').');
        }
    }

    /**
     * The parts of a Pin charge shown to staff.
     */
    private function charge(Order $order, array $charge): array
    {
        $amount = (int) ($charge['amount'] ?? 0);

        return [
            'token' => $charge['token'] ?? null,
            'created_at' => isset($charge['created_at']) ? Carbon::parse($charge['created_at']) : null,
            'amount' => $amount / 100,
            'email' => $charge['email'] ?? null,
            'description' => $charge['description'] ?? null,
            'success' => (bool) ($charge['success'] ?? false),
            'captured' => (bool) ($charge['captured'] ?? false),
            'message' => $charge['error_message'] ?? $charge['status_message'] ?? null,
            'matches_amount' => $amount === (int) round($order->total * 100),
            // Charges made since the order number was sent to Pin say which order they were for
            'for_this_order' => ($charge['metadata']['order_id'] ?? null) === (string) $order->id,
        ];
    }
}
