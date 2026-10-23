<?php

namespace App\Libraries\Pin;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

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
        return Http::withBasicAuth(config('pin.secret'), '')
            ->acceptJson()
            ->timeout(60)
            ->post('https://' . config('pin.host') . '/1/charges', $charge);
    }
}
