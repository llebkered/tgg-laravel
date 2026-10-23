<table class="table">
    <thead>
        @include('backend.order.sort-header', ['column' => 'id', 'label' => 'Id'])
        @include('backend.order.sort-header', ['column' => 'date', 'label' => 'Date'])
        @include('backend.order.sort-header', ['column' => 'name', 'label' => 'Customer'])
        <th>Address</th>
        @include('backend.order.sort-header', ['column' => 'status', 'label' => 'Status'])
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
            {{ $order->order_status_id?->label() }}
            @if ($order->paymentNeedsChecking())
            <span class="tag is-warning">Payment unconfirmed</span>
            @endif

        </td>
        <td><a href="{{ route('backend.orders.edit', $order->id ) }}"
                class="button is-link is-outlined is-small">edit</a></td>
    </tr>
    @endforeach
</table>