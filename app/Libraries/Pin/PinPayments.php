<?php

namespace App\Libraries\Pin;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use GuzzleHttp;


class PinPayments
{

    //
    // Charge a credit card


    //  Sample $charge array
    // $charge = [
    //     "card" =>
    //     [
    //         "number" => "552000000000000",
    //         "expiry_month"  => "05",
    //         "expiry_year"  => "2021",
    //         "cvc"  => "123",
    //         "name"  => "Roland Robot",
    //         "address_line1"  => "42 Sevenoaks St",
    //         // "address_line2" => "",
    //         "address_city"  => "Lathlain",
    //         "address_postcode"  => "6454",
    //         "address_state"  => "WA",
    //         "address_country"  => "Australia"
    //     ],
    //     "description"  => "A tiny widget description",
    //     "amount" => "700",
    //     "email" => "test@example.com"

    // ];




    public function charge($card)
    {

// dd($card);

        $client = new \GuzzleHttp\Client();
        // $res = $client->request('POST', 'https://' . config('pin.host') . '/1/charges', [
        //     'auth' => [config('pin.secret'), ''],
        //     'json' => $card
        // ]);


        // echo $res->getStatusCode();
        // // '200'
        // echo $res->getHeader('content-type')[0];
        // // 'application/json; charset=utf8'
        // echo $res->getBody();
        // // {'type':'User'...'

        // // Send an asynchronous request.
        // $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
        // $promise = $client->sendAsync($request)->then(function ($response) {
        //     echo 'I completed! ' . $response->getBody();
        // });
        // $promise->wait();



        try {
            $client->request('POST', 'https://' . config('pin.host') . '/1/charges', [
                'auth' => [config('pin.secret'), ''],
                'json' => $card
            ]);
        } catch (ClientException $e) {
            // echo Psr7\str($e->getRequest());
            // echo Psr7\str($e->getResponse());
            // dd($e->getResponse()->getBody()->getContents());
            return FALSE;
        }

        return TRUE;
    }
}
