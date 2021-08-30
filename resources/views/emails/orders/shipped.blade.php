<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Email</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff
        }

        h1 {
            margin: 0;
            padding: 0;
        }

        img {
            border: 0;
        }

        table {
            border-spacing: 0;
        }

        td {
            padding: 0;
        }

        .has-text-right {
            text-align: right;
        }

        .margin-bottom {
            display: block;
            margin-bottom: 30px;
            height: 30px;
        }

        .outer {
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            font-family: sans-serif;
            color: #4a4a4a;
        }

        .padding {
            padding: 15px;
        }

        .v-align-top {
            vertical-align: top;
        }


        .wrapper {
            background-color: #ffffff;
            width: 100%;
            table-layout: fixed;
            padding-bottom: 40px;

        }

        .webkit {
            max-width: 600px;
            background-color: #fffff;
        }


        /* @media screen and (max-width: 600px) {}

        @media screen and (max-width: 400px) {} */
    </style>
</head>

<body>
    <center class="wrapper">
        <div class="webkit">
            <table class="outer" align="center">
                <tr>
                    <td>
                        {{-- Heading and Logo --}}
                        <table width="100%">
                            <tr>
                                <td class="v-align-top">
                                    <img src="data:image/png;base64,{{base64_encode(file_get_contents(resource_path('images/email-logo.png')))}}"
                                        alt="TGG Logo" />
                                </td>
                                <td class="v-align-top has-text-right" align="right">
                                    <img src="data:image/png;base64,{{base64_encode(file_get_contents(resource_path('images/tgg-text.png')))}}"
                                        alt="Toad Gully Growers" />

                                    <p>
                                        361 Stumpy Gully Road<br />
                                        Balnarring, VIC 3926<br />
                                        ph (03) 5983 5688<br />
                                        email sales@toadgully.com.au
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="margin-bottom">
                                        <p> </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{-- Order recipient --}}
                        <table width="100%">
                            <tr>
                                <td>
                                    <p><strong>Order Number: </strong> {{ $orderDetails->id }}</p>
                                </td>
                                <td class="has-text-right" align="right">
                                    <p> {{ $orderDetails->name }} <br />
                                        {{ $orderDetails->address }} <br />
                                        {{ $orderDetails->city }} {{ $orderDetails->state }}
                                        {{ $orderDetails->postcode }}<br />
                                        {{ $orderDetails->country }}</p>
                                    <p> </p>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="margin-bottom">
                                        <p> </p>
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{-- Order Details --}}
                        <table width="100%" class="full-width">
                            <tr>
                                <td><strong>Item</strong> </td>
                                <td class="has-text-right" align="right"><strong>Price</strong> </td>
                            </tr>
                            @foreach ($orderDetails->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td class="has-text-right" align="right">${{ number_format($product->price,2) }}</td>
                            </tr>
                            @endforeach

                            <tr>
                                <td></td>
                                <td class="has-text-right" align="right">
                                    <strong>GST: </strong> ${{ $orderDetails->gst }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="has-text-right" align="right">
                                    <strong>Total: </strong> ${{ $orderDetails->total }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="margin-bottom">
                                        <p> </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        {{-- Message --}}
                        <table width="100%">
                            <tr>
                                <td>
                                    <p>Dear {{ $orderDetails->name }},</p>

                                    <p>Your order has been shipped.</p>

                                    @if ($orderDetails->tracking)
                                    <div><strong>Tracking Information: </strong>
                                        Orders are sent by Australia Post. <br />
                                        @if ($orderDetails->tracking)
                                        <strong>Tracking number: </strong> <em> {{$orderDetails->tracking}}</em>  
                                        @endif
                                    </div>
                                    @endif

                                    @if ($orderDetails->message)
                                    <p> {{$orderDetails->message}}</p>
                                    @endif

                                    <p>Thank you again for choosing us.</p>

                                    <p> Regards,<br />
                                        {{ config('app.name') }}
                                    </p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </div>
    </center>

</body>

</html>