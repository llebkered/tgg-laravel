The {{ $email }} email for order {{ $order->id }} could not be sent to {!! $order->name !!} ({!! $order->email !!}).

The order itself is saved. Please contact the customer and send the {{ $email }} another way.

Order total: {{ money($order->total) }}
Phone: {!! $order->phone !!}

Error: {!! $error !!}
