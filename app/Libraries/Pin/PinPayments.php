<?php

namespace App\Libraries\Pin;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use GuzzleHttp;

class PinPayments
{
    public function charge($card)
    {
        $client = new \GuzzleHttp\Client();
      
        try {
            $client->request('POST', 'https://' . config('pin.host') . '/1/charges', [
                'auth' => [config('pin.secret'), ''],
                'json' => $card
            ]);
        } catch (ClientException $e) {
            return false;
        }

        return true;
    }
}
