@php
    $payment = in_array(request('payment'), ['card', 'direct_deposit', 'unknown'], true) ? request('payment') : null;
    $paymentFilters = [null => 'All', 'card' => 'Card', 'direct_deposit' => 'Direct deposit', 'unknown' => 'Unknown'];
@endphp
<div class="buttons has-addons mb-3">
    <span class="mr-2">Payment:</span>
    @foreach ($paymentFilters as $value => $label)
    <a href="{{ request()->fullUrlWithQuery(['payment' => $value ?: null]) }}"
        class="button is-small {{ $payment === ($value ?: null) ? 'is-link is-selected' : '' }}">{{ $label }}</a>
    @endforeach
</div>
<table class="table">
    <thead>
        @include('backend.order.sort-header', ['column' => 'id', 'label' => 'Id'])
        @include('backend.order.sort-header', ['column' => 'date', 'label' => 'Date'])
        @include('backend.order.sort-header', ['column' => 'name', 'label' => 'Customer'])
        <th>Address</th>
        @include('backend.order.sort-header', ['column' => 'status', 'label' => 'Status'])
        <th>Payment</th>
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
        <td>
            @if ($order->payment_method)
            {{ $order->payment_method->label() }}
            @else
            <span class="has-text-grey">Unknown</span>
            @endif
        </td>
        <td><a href="{{ route('backend.orders.edit', $order->id ) }}"
                class="button is-link is-outlined is-small">edit</a></td>
    </tr>
    @endforeach
</table>