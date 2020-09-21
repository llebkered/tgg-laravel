<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        table {
            border-spacing: 0px;
            border-color: transparent;
            border: none;
            border: 0px;
            border-collapse: collapse;
            vertical-align: bottom;
            margin: 0;
        }

        td {
            margin: 0;
            border-spacing: 0px;
            border-color: transparent;
            border: none;
            border: 0px;
            border-collapse: collapse;
            vertical-align: bottom;
        }

        .full-width {
            width: 100%;
        }

        .has-test-right {
            text-align: right;
        }
    </style>
</head>

<body>

<p>Dear {{ $orderDetails->name }}</p>

<p>Your order has been shipped.</p>

    <table class="full-width">
        <tr>
            <td>
                <h4>Toad Gully Growers</h4>

                <p>
                    361 Stumpy Gully Road<br>
                    Balnarring, VIC 3926
                </p>
            </td>
            <td>
                {{ $orderDetails->name }} <br>
                {{ $orderDetails->address }} <br>
                {{ $orderDetails->city }} {{ $orderDetails->state }} {{ $orderDetails->postcode }}<br>
                {{ $orderDetails->country }}
            </td>
        </tr>
    </table>

    <table class="full-width">
        <tr>
            <td>Item</td>
            <td class="has-text-right">Price</td>
        </tr>
        @foreach ($orderDetails->products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td class="has-text-right">${{ number_format($product->price,2) }}</td>
        </tr>
        @endforeach

        <tr>
            <td></td>
            <td class="has-text-right">
                <strong>GST: </strong> ${{ $orderDetails->gst }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="has-text-right">
                <strong>Total: </strong> ${{ $orderDetails->total }}
            </td>
        </tr>
    </table>
    <div class="content">

        <p>Thank you again for choosing us.</p>

        <p> Regards,<br>
            {{ config('app.name') }}
        </p>
    </div>

</body>

</html>
