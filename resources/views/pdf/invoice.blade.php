<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toad Gully Growers</title>
</head>

<body>
    <h1>Invoice</h1>


    <p><strong>Order ID:</strong> {{ $order->id }}</p>

    <p><strong>Order Email:</strong> {{ $order->email }}</p>

    <p><strong>Order Name:</strong> {{ $order->name }}</p>

    <p><strong>Order Total:</strong> ${{ round($order->total / 100, 2) }}</p>

    <p><strong>Items Ordered</strong></p>

    <div>
        @foreach ($order->products as $product)
        Name: {{ $product->name }} <br>
        Price: ${{ round($product->price / 100, 2)}} <br>
        @endforeach
    </div>

    <p>To pay for this please direct deposit to:</p>

    <p>
        <strong>Bank: </strong> {{ config('bank.name') }}<br>
        <strong>BSB: </strong> {{ config('bank.bsb') }}<br>
        <strong>Account: </strong> {{ config('bank.account') }}<br>
    </p>


    <p>Thank you again for choosing us.</p>

    <p>Regards,<br>
        {{ config('app.name') }}
    </p>
</body>

</html>
