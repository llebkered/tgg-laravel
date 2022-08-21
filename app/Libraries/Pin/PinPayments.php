<?php

namespace App\Libraries\Pin;

use GuzzleHttp;
use Dotenv\Dotenv;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class PinPayments
{
    public function charge($card)
    {
        // https://pinpayments.com/developers/api-reference/charges

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

        // Return processing error
        } catch (ClientException $e) {
            return $e->getResponse();
        }

        // Return server error
        catch (ServerException $e) {
            return $e->getResponse();
        }
    }
}
