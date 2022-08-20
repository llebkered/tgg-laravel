<?php

namespace App\Libraries\Pin;

use GuzzleHttp;
use Dotenv\Dotenv;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class PinPayments
{
    public function charge($card)
    {
        $client = new \GuzzleHttp\Client(
            [
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]
        );

        try {
            $res = $client->request('POST', 'https://' . config('pin.host') . '/1/charges', [
                'auth' => [config('pin.secret'), ''],
                'json' => $card
            ]);
            return $res;

        // Return error
        } catch (ClientException $e) {
            return $e->getResponse();
        }

    }
}
