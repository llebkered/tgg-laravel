@component('mail::message')
# Order Sent 

Dear {{ $order['name']}},

Your order has been sent.

** Tracking Info ** {{ $order['tracking']}}

{{ $order['comments'] }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
