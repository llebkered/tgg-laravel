<?php

namespace App\Libraries\Pin;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PinPayments
{
    /**
     * Create a charge.
     * https://pinpayments.com/developers/api-reference/charges
     *
     * Error responses from Pin (4xx and 5xx) are returned, not thrown. Throws
     * a ConnectionException when Pin can't be reached or doesn't reply in time.
     */
    public function charge(array $charge): Response
    {
        return $this->request()
            ->timeout(60)
            ->post($this->url('charges'), $charge);
    }

    /**
     * Look up one charge by its token (ch_...). Errors are returned, as for
     * charge().
     */
    public function findCharge(string $token): Response
    {
        return $this->request()
            ->timeout(20)
            ->get($this->url('charges/' . rawurlencode($token)));
    }

    /**
     * Search charges. Pin matches `query` against the email, description and
     * metadata, among others; dates are YYYY/MM/DD. Errors are returned, as
     * for charge().
     */
    public function searchCharges(array $query): Response
    {
        return $this->request()
            ->timeout(20)
            ->get($this->url('charges/search'), $query);
    }

    /**
     * Throws when the secret key isn't set.
     */
    public function ensureConfigured(): void
    {
        if (blank(config('pin.secret'))) {
            throw new RuntimeException('Pin Payments is not configured. Set PIN_SECRET in .env.');
        }
    }

    private function request(): PendingRequest
    {
        $this->ensureConfigured();

        return Http::withBasicAuth(config('pin.secret'), '')->acceptJson();
    }

    private function url(string $path): string
    {
        return 'https://' . config('pin.host') . '/1/' . $path;
    }
}
