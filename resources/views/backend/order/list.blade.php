<table class="table">
    <thead>
        <th>Id</th>
        <th>Date</th>
        <th>Customer</th>
        <th>Address</th>
        <th>Status</th>
        <th></th>
    </thead>
    @foreach ($orders as $order)
    <tr>
        <td>{{ $order->id }}</td>
        <td>{{ \Carbon\Carbon::parse($order->created_at)->timezone('Australia/Melbourne')}}</td>
        <td>{{ $order->name }}</td>
        <td>
            @if ($order->line1){{$order->line1}}<br /> @endif
            @if ($order->line2){{$order->line2}}<br /> @endif
            {{ $order->city }}, {{ $order->state }} {{ $order->postcode }}</td>
        <td>
            {{-- {{ $order->order_status->title }} --}}
            {{ $order->order_status }}
            {{ $order->order_status_id }}
            {{-- {{ $order_statuses[$order->order_status_id]->title }} --}}
            {{-- @php
            $status = (array)json_decode(json_encode($order->order_status));
            // dd($status['title']);
            @endphp
            {{ $status['title'] }} --}}
            @if ($order->paymentNeedsChecking())
            <span class="tag is-warning">Payment unconfirmed</span>
            @endif

        </td>
        <td><a href="{{ route('backend.orders.edit', $order->id ) }}"
                class="button is-link is-outlined is-small">edit</a></td>
    </tr>
    @endforeach
</table>