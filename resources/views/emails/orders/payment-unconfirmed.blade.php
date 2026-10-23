The card payment for order {{ $order->id }} ({!! $order->name !!}, {!! $order->email !!}, ${{ number_format($order->total, 2) }}) could not be confirmed.

Check the Pin Payments dashboard to see whether the card was charged, then update the order.

Pin response: {!! $detail !!}
