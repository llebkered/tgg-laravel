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
        <td>{{ $order->created_at }}</td>
        <td>{{ $order->name }}</td>
        <td>{{ $order->address }}, {{ $order->city }}, {{ $order->state }} {{ $order->postcode }}</td>
        <td>{{ $order->order_status->title }}</td>
        <td><a href="{{ route('backend.orders.edit', $order->id ) }}"
                class="button is-link is-outlined is-small">edit</a></td>
    </tr>
    @endforeach
</table>
