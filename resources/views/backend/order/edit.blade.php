@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="title">
                        Edit Order #{{ $order->id }}
                    </h1>
                    <div class="has-text-weight-light">
                        <p>Created: {{ $order->created_at->format('j M, Y') }}</p>
                        <p>Updated: {{ $order->updated_at->format('j M, Y') }}</p>
                    </div>
                </div>
                <div class="column has-text-right">
                    <p>{{ $order->name  }}</p>
                    <p>${{ $order->total  }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    @if ($order->paymentNeedsChecking())
    <div class="container mb-6">
        <div class="notification is-warning">
            <p><strong>Card payment not confirmed.</strong>
                A card payment was started on
                {{ $order->payment_started_at->timezone('Australia/Melbourne')->format('j M Y, g:i a') }}
                but its result is unknown, so the order can't be charged again until it's resolved.</p>
            <p class="mt-2">Check the Pin Payments dashboard for a charge to {{ $order->email }}
                for ${{ number_format($order->total, 2) }}, then:</p>

            <div class="columns mt-4">
                <div class="column">
                    <form action="{{ route('backend.orders.payment.paid', $order->id) }}" method="POST"
                        onsubmit="return confirm('Mark order #{{ $order->id }} as paid?')">
                        @csrf
                        <div class="field">
                            <label class="label" for="charge_token">Pin charge token (optional)</label>
                            <div class="control">
                                <input class="input" type="text" id="charge_token" name="charge_token" placeholder="ch_...">
                            </div>
                        </div>
                        <label class="checkbox">
                            <input type="checkbox" name="email_receipt" value="1" checked>
                            Email the receipt to the customer
                        </label>
                        <div class="mt-3">
                            <button type="submit" class="button is-success">The card was charged: mark as paid</button>
                        </div>
                    </form>
                </div>
                <div class="column">
                    <form action="{{ route('backend.orders.payment.release', $order->id) }}" method="POST"
                        onsubmit="return confirm('Release order #{{ $order->id }} so it can be paid again?')">
                        @csrf
                        <p>If there's no charge in Pin, release the order so it can be paid again.</p>
                        <div class="mt-3">
                            <button type="submit" class="button is-danger is-outlined">No charge in Pin: release the order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- <div class="container">

        <div class="columns has-background-light mb-6">
            <div class="column">
                Order ID: {{ $order->id }}

            </div>

            <div class="column">
                Customer ID: {{ $order->customer_id }}
            </div>

            <div class="column">
                User ID: {{ $order->user_id }}
            </div>

            <div class="column">
                Address ID: {{ $order->address_id }}
            </div>
        </div>
    </div> --}}

    <div class="container">
        <div class="columns has-background-light mb-6">
            <div class="column is-3">

            <a href="{{ route('backend.orders.sendshippedemail', $order->id)}}" class="button is-primary is-outlined">Send Order Shipped Email</a>

            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('backend.orders.update', $order->id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="columns">
                <div class="column is-2"><label class="label" for="order_status_id">Order Status</label></div>
                <div class="column">
                    <div class="control">
                        <div class="select">
                            <select name="order_status_id">
                                @foreach ($order_statuses as $status)
                                <option value="{{ $status->value }}" @selected($order->order_status_id === $status)>
                                    {{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="columns">
                <div class="column is-2"><label class="label" for="name">Name</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="name" id="name" type="text" placeholder="Name"
                            value="{{ old('name') ? old('name') : $order->name }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="email">Email</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="email" id="email" type="text" placeholder="email"
                            value="{{ old('email') ? old('email') : $order->email }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" foline1">Address</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="line1" id="line1" type="text" placeholder="address"
                            value="{{ old('line1') ? old('line1') : $order->line1 }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="line2">Line 2</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="line2" id="line2" type="text" placeholder="line2"
                            value="{{ old('line2') ? old('line2') : $order->line2 }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="name">Phone</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="phone" id="phone" type="text" placeholder="phone"
                            value="{{ old('phone') ? old('phone') : $order->phone }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="city">City</label>
                        <div class="control">
                            <input class="input" name="city" id="city" type="text" placeholder="city"
                                value="{{ old('city') ? old('city') : $order->city }}">
                        </div>
                    </div>

                </div>
                <div class="column">
                    <div class="field">
                        <label class="label" for="state">State</label>
                        <div class="control">
                            <div class="select">
                                <select name="state">
                                    @foreach ($states as $key => $state)
                                    <option value="{{ $key }}" {{ ($order->state == $key) ? 'selected' : ''}}>
                                        {{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label" for="name">Postcode</label>
                        <div class="control">
                            <input class="input" name="postcode" id="postcode" type="text" placeholder="postcode"
                                value="{{ old('postcode') ? old('postcode') : $order->postcode }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <h3>Order Items</h3>
                <table>
                    @foreach ($order->products as $item)
                    <tr>
                        <td>{{ $item->qty }} x {{ $item->name }} {{ $item->qty }}</td>
                        <td class="has-text-right"> ${{ $item->subtotal }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td class="has-text-right"><strong>${{ $order->total}}</strong></td>
                    </tr>
                </table>
            </div>

            <div class="content">
                <h3>Comments</h3>
                <textarea class="textarea" name="comments" id="comments" cols="30" rows="10"
                    placeholder="Comments about order">{{ $order->comments}}</textarea>
            </div>

            <div class="columns">
                <div class="column">
                    <button class="button is-primary">Update Order</button>
                </div>
                <div class="column">
                    <a href="{{ route('backend.orders.delete', $order->id) }}" class="button is-danger is-pulled-right" onclick="return confirm('Are you sure you want to delete this order?')">Delete Order</a>
                </div>
            </div>

            
        </form>
    </div>
</section>




@endsection
